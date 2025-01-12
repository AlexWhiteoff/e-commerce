<?php

use core\Configuration;
use models\AccountModel;
use models\ProductModel;

$userModel = new AccountModel();
$productModel = new ProductModel();
$productImageDir = Configuration::get('paths', 'Paths')['ProductImagesDirRelative'];

$users = $userModel->getUsers(null);
$categories = $productModel->getCategories();
$products = $productModel->getProducts();
$orderList = $productModel->getOrderList(null, ['datetime' => 'DESC']);
$orderList = $orderList === null ? [] : $orderList;
$sellers = $userModel->getUsers(['access' => 2]);


//---------------------------------------------------------
// Order list sort

function orderSortByAdded_ASC($orderVal1, $orderVal2)
{
    $datetime_current = date('Y-m-d', strtotime($orderVal1['datetime']));
    $datetime_prev = date('Y-m-d', strtotime($orderVal2['datetime']));

    if ($datetime_current == $datetime_prev) {
        return 0;
    }
    return ($datetime_current < $datetime_prev) ? -1 : 1;
}

function orderSortByAdded_DESC($orderVal1, $orderVal2)
{
    $datetime_current = date('Y-m-d', strtotime($orderVal1['datetime']));
    $datetime_prev = date('Y-m-d', strtotime($orderVal2['datetime']));

    if ($datetime_current == $datetime_prev) {
        return 0;
    }
    return ($datetime_current < $datetime_prev) ? 1 : -1;
}

$orderList_sortedAdded_ASC = $orderList;
$orderList_sortedAdded_DESC = $orderList;
usort($orderList_sortedAdded_ASC, "orderSortByAdded_ASC");
usort($orderList_sortedAdded_DESC, "orderSortByAdded_DESC");

// --------------------------------------------------------------------------------------
// Overview chart values
$endDate = new \DateTime('today');
$startDate = (clone $endDate)->modify('-27 days');

$endDate->setTime(23, 59, 59);

$totalSalesPerDay = array_fill(0, 28, 0);
for ($i = 0; $i < count($orderList_sortedAdded_ASC); $i++) {
    $orderDate = new \DateTime($orderList_sortedAdded_ASC[$i]['datetime']);

    if ($orderDate >= $startDate && $orderDate <= $endDate) {
        $dayIndex = $orderDate->diff($startDate)->days;
        $totalSalesPerDay[$dayIndex] += $orderList_sortedAdded_ASC[$i]['quantity'];
    }
}

$startDateFormatted = $startDate->format('jS M');
$endDateFormatted = $endDate->format('jS M');


$totalsales = 0;
foreach ($products as $product) {
    $totalsales += $product['sales'];
}

$revenue = 0;
foreach ($orderList as $order) {
    if ($order['status'] !== 'Canceled')
        $revenue += $order['price'];
}


?>


<main id="main">
    <section class="overview">
        <h1 class="overview__title">Overview</h1>
        <h3 class="overview__subtitle">Here’s what’s going on at your business right now</h3>
        <div class="overview__left-block">
            <div class="overview__current-stats">
                <div class="overview__stats-block">
                    <div class="overview__block-icon">
                        <div class="overview__block-icon-inner">
                            <div class="icon-wrapper">
                                <i class="fas fa-box"></i>
                            </div>
                            <div class="icon-wrapper">
                                <i class="fas fa-plus-circle"></i>
                            </div>
                        </div>
                    </div>
                    <h4 class="overview__block-innerText">
                        <?
                        $newOrderlist = [];
                        foreach ($orderList as $order) {
                            if ($order['status'] === 'Placed') {
                                array_push($newOrderlist, $order);
                            }
                        }
                        echo count($newOrderlist);
                        ?> new orders</h4>
                    <p class="overview__block-innerSubtext">Awating processing</p>
                </div>
                <div class="overview__stats-block">
                    <div class="overview__block-icon">
                        <div class="overview__block-icon-inner">
                            <div class="icon-wrapper">
                                <i class="fas fa-box"></i>
                            </div>
                            <div class="icon-wrapper">
                                <i class="fa-solid fa-circle-down"></i>
                            </div>
                        </div>
                    </div>
                    <h4 class="overview__block-innerText">
                        <?
                        $newOrderlist = [];
                        foreach ($orderList as $order) {
                            if ($order['status'] === 'Packing') {
                                array_push($newOrderlist, $order);
                            }
                        }
                        echo count($newOrderlist);
                        ?> orders</h4>
                    <p class="overview__block-innerSubtext">Are packing now</p>
                </div>
                <div class="overview__stats-block">
                    <div class="overview__block-icon">
                        <div class="overview__block-icon-inner">
                            <div class="icon-wrapper">
                                <i class="fas fa-box"></i>
                            </div>
                            <div class="icon-wrapper">
                                <i class="fa-solid fa-circle-xmark"></i>
                            </div>
                        </div>
                    </div>
                    <h4 class="overview__block-innerText">
                        <?
                        $outOfStockProductCount = 0;
                        foreach ($products as $product) {
                            if ($product['quantity'] === '0') {
                                $outOfStockProductCount++;
                            }
                        }
                        echo $outOfStockProductCount;
                        ?> products</h4>
                    <p class="overview__block-innerSubtext">Out of stock</p>
                </div>
            </div>
            <div class="overview__total-sales-block">
                <h2 class="overview__total-sales-title">
                    Total Sells
                </h2>
                <p class="overview__total-sales-text">
                    Payment received per month
                </p>
                <div class="overview__total-sales-chart-wrapper">
                    <canvas id="total-sales-chart" style="width: 770px; height: 320px;">
                    </canvas>
                    <div class="xAxis-label">
                        <div class="xAxis-label left">
                            <?= $startDateFormatted; ?>
                        </div>
                        <div class="xAxis-label center">
                            <?= $startDate->modify('+13 days')->format('jS M'); ?>
                        </div>
                        <div class="xAxis-label right">
                            <?= $endDateFormatted; ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="overview__right-block">
            <div class="overview__block-content">
                <div class="overview__block-content--icon">
                    <i class="fa-solid fa-money-bill-wave"></i>
                </div>
                <div class="overview__block-content--text">Revenue</div>
                <div class="overview__block-content--count">$<?= $revenue; ?></div>
            </div>
            <div class="overview__block-content">
                <div class="overview__block-content--icon">
                    <i class="fa-solid fa-tags"></i>
                </div>
                <div class="overview__block-content--text">Total sales</div>
                <div class="overview__block-content--count"><?= $totalsales; ?></div>
            </div>
            <div class="overview__block-content">
                <div class="overview__block-content--icon">
                    <i class="fas fa-cart-shopping"></i>
                </div>
                <div class="overview__block-content--text">Orders</div>
                <div class="overview__block-content--count"><?= count($orderList) ?></div>
            </div>
            <div class="overview__block-content">
                <div class="overview__block-content--icon">
                    <i class="fas fa-boxes-stacked"></i>
                </div>
                <div class="overview__block-content--text">Products</div>
                <div class="overview__block-content--count"><?= count($products); ?></div>
            </div>
            <div class="overview__block-content">
                <div class="overview__block-content--icon">
                    <i class="fas fa-users"></i>
                </div>
                <div class="overview__block-content--text">Users</div>
                <div class="overview__block-content--count"><?= count($users); ?></div>
            </div>
            <div class="overview__block-content">
                <div class="overview__block-content--icon">
                    <i class="fas fa-user"></i>
                </div>
                <div class="overview__block-content--text">Sellers</div>
                <div class="overview__block-content--count"><?= count($sellers); ?></div>
            </div>
        </div>
    </section>

    <section class="user-list">
        <h1 class="user-list__title">
            User List
        </h1>
        <div class="user-list__table-wrapper">
            <table class="user-list__table" cellpadding="0" cellspacing="0">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Email</th>
                        <th>First name</th>
                        <th>Last name</th>
                        <th>Birthday Date</th>
                        <th>Gender</th>
                        <th>Address</th>
                        <th>Telephone</th>
                        <th>Date of registration</th>
                        <th>Access level</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    <? for ($i = 0; $i < count($users); $i++) : ?>
                        <tr id="usr-<?= $users[$i]["UserID"]; ?>">
                            <td>
                                <div class="usrId-<?= $users[$i]["UserID"]; ?>">
                                    <?=
                                    $users[$i]["UserID"] !== null ? $users[$i]["UserID"] : "<i>NULL</i>";
                                    ?>
                                </div>
                            </td>
                            <td>
                                <div class="usrEml-<?= $users[$i]["UserID"]; ?>">
                                    <?=
                                    $users[$i]["email"] !== null ? $users[$i]["email"] : "<i>NULL</i>";
                                    ?>
                                </div>
                            </td>
                            <td>
                                <div class="usrFn-<?= $users[$i]["UserID"]; ?>">
                                    <?=
                                    $users[$i]["firstname"] !== null ? $users[$i]["firstname"] : "<i>NULL</i>";
                                    ?>
                                </div>
                            </td>
                            <td>
                                <div class="usrLn-<?= $users[$i]["UserID"]; ?>">
                                    <?=
                                    $users[$i]["lastname"] !== null ? $users[$i]["lastname"] : "<i>NULL</i>";
                                    ?>
                                </div>
                            </td>
                            <td>
                                <div class="usrBd-<?= $users[$i]["UserID"]; ?>">
                                    <?=
                                    $users[$i]["birthdayDate"] !== null ? date('M j Y', strtotime($users[$i]["birthdayDate"])) : "<i>NULL</i>";
                                    ?>
                                </div>
                            </td>
                            <td>
                                <div class="usrGndr-<?= $users[$i]["UserID"]; ?>">
                                    <?=
                                    $users[$i]["gender"] !== null ? $users[$i]["gender"] : "<i>NULL</i>";
                                    ?>
                                </div>
                            </td>
                            <td>
                                <div class="usrAdrs-<?= $users[$i]["UserID"]; ?>">
                                    <?
                                    $address = '';

                                    $address .= ($users[$i]["address"] !== '') && ($users[$i]["address"] !== null) ? $users[$i]["address"] . ', ' :  '';
                                    $address .= ($users[$i]["apartment"] !== '') && ($users[$i]["apartment"] !== null) ? $users[$i]["apartment"] . ', ' :  '';
                                    $address .= ($users[$i]["postalCode"] !== '') && ($users[$i]["postalCode"] !== null) ? $users[$i]["postalCode"] . ', ' :  '';
                                    $address .= ($users[$i]["city"] !== '') && ($users[$i]["city"] !== null) ? $users[$i]["city"] . ', ' :  '';
                                    $address .= ($users[$i]["country"] !== '') && ($users[$i]["country"] !== null) ? $users[$i]["country"] :  '';

                                    echo !empty($address) ? $address : "<i>NULL</i>";
                                    ?>
                                </div>
                            </td>
                            <td>
                                <div class="usrPhn-<?= $users[$i]["UserID"]; ?>">
                                    <?=
                                    $users[$i]["telephone"] !== null ? $users[$i]["telephone"] : "<i>NULL</i>";
                                    ?>
                                </div>
                            </td>
                            <td>
                                <div class="usrReg-<?= $users[$i]["UserID"]; ?>">
                                    <?=
                                    $users[$i]["registrationDate"] !== null ? date('M j Y, g:i a', strtotime($users[$i]["registrationDate"])) : "<i>NULL</i>";
                                    ?>
                                </div>
                            </td>
                            <td>
                                <?
                                $userStatus = '';
                                if ($users[$i]["access"] !== null) {
                                    if ($users[$i]["access"] === '1')
                                        $userStatus = 'User';
                                    else if ($users[$i]["access"] === '2')
                                        $userStatus = 'Seller';
                                    else if ($users[$i]["access"] === '3')
                                        $userStatus = 'Admin';
                                } else
                                    $userStatus = null;
                                ?>
                                <div class="usrSt-<?= $users[$i]["UserID"]; ?> status-<?= $userStatus; ?>">
                                    <?= $userStatus; ?>
                                </div>
                            </td>
                            <td>
                                <div class="controls">
                                    <a href="/panel/edit?object=user&id=<?= $users[$i]["UserID"]; ?>" class="user-change-btn usr-<?= $users[$i]["UserID"]; ?>">Change</a>
                                    <a href="/panel/delete?object=user&id=<?= $users[$i]["UserID"]; ?>&confirm=true" class="user-delete-btn">Delete</a>
                                </div>
                            </td>
                        </tr>
                    <? endfor; ?>
                </tbody>
            </table>
        </div>
    </section>

    <? if ($products !== []) : ?>
        <?
        $salesByCategiries = array_fill(0, count($categories), 0);
        $categoryList = [];

        for ($i = 0; $i < count($categories); $i++) {
            $categoryList[$i] = $categories[$i]['categoryName'];
            foreach ($products as $product) {
                if ($product['categoryID'] === $categories[$i]['categoryID']) {
                    $salesByCategiries[$i] += $product['sales'];
                }
            }
        }

        $percentOfSales = [];

        for ($i = 0; $i < count($salesByCategiries); $i++) {
            $percentOfSales[$i] = round($salesByCategiries[$i] * 100 / array_sum($salesByCategiries), 0);
        }

        $chartBackgroundColor = [
            '#00a878',
            '#6e5b40',
            '#00d2d3',
            '#f4a261',
            '#264653',
            '#fafafa',
        ];
        ?>

        <section class="product-section">
            <div class="product-section__body">
                <div class="product-left">
                    <div class="product-section__header">
                        <h1 class="product-section__title">
                            Product section
                        </h1>
                        <a href="/shop/add" class="product-section__add-button"><i class="fas fa-plus"></i></a>
                    </div>
                    <div class="product-section__table-wrapper">
                        <table class="product-section__table" cellpadding="0" cellspacing="0">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Image</th>
                                    <th>Name</th>
                                    <th>Seller Id</th>
                                    <th>Quantity</th>
                                    <th>Sales</th>
                                    <th>Category</th>
                                    <th>Added</th>
                                    <th>Price</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                <? for ($i = 0; $i < count($products); $i++) : ?>
                                    <tr>
                                        <td>
                                            <?
                                            if ($products[$i]["productID"] !== null)
                                                echo $products[$i]["productID"];
                                            else
                                                echo "<i>NULL</i>";
                                            ?>
                                        </td>
                                        <td>
                                            <a href="/shop/product?id=<?= $products[$i]["productID"]; ?>">
                                                <div class="image-wrapper">
                                                    <? if (is_file($productImageDir . $products[$i]['image']  . '_s.png')) : ?>
                                                        <img src="\<?= $productImageDir . $products[$i]['image'] . '_s.png'; ?>" alt="<?= $products[$i]["productShortName"]; ?>" class="image" />
                                                    <? endif; ?>
                                                </div>
                                            </a>
                                        </td>
                                        <td>
                                            <div class="product-name">
                                                <a href="/shop/product?id=<?= $products[$i]["productID"]; ?>" class="product-name--link">
                                                    <?=
                                                    ($products[$i]["productName"] !== null) ? $products[$i]["productName"] : "<i>NULL</i>";
                                                    ?>
                                                </a>
                                            </div>
                                            <? if (!empty($products[$i]["productMaterial"])) : ?>
                                                <div class="product-material">
                                                    <?=
                                                    $products[$i]["productMaterial"];
                                                    ?>
                                                </div>
                                            <? endif; ?>
                                        </td>
                                        <td>
                                            <?=
                                            ($products[$i]["sellerID"] !== null) ? $products[$i]["sellerID"] : "<i>NULL</i>";
                                            ?>
                                        </td>
                                        <td>
                                            <?=
                                            ($products[$i]["quantity"] !== null) ? $products[$i]["quantity"] : "<i>NULL</i>";
                                            ?>
                                        </td>
                                        <td>
                                            <?=
                                            ($products[$i]["sales"] !== null) ? $products[$i]["sales"] : "<i>NULL</i>";
                                            ?>
                                        </td>
                                        <td>
                                            <div class="category">
                                                <?=
                                                ($products[$i]["categoryID"] !== null) ? $categories[$products[$i]["categoryID"] - 1]["categoryName"] : "<i>NULL</i>";
                                                ?>
                                            </div>
                                            <div class="subcategory">
                                                <?=
                                                ($products[$i]["subcategoryName"] !== null) ? $products[$i]["subcategoryName"] : "<i>NULL</i>";
                                                ?>
                                            </div>
                                        </td>
                                        <td>
                                            <?=
                                            ($products[$i]["added"] !== null) ? date('M j Y, g:i a', strtotime($products[$i]["added"])) : "<i>NULL</i>";
                                            ?>
                                        </td>
                                        <td><b>
                                                <?=
                                                ($products[$i]["price"] !== null) ? '$' . $products[$i]["price"] : "<i>NULL</i>";
                                                ?>
                                            </b>
                                        </td>
                                        <td>
                                            <div class="controls">
                                                <a href="/shop/edit?id=<?= $products[$i]["productID"]; ?>" class="product-change-btn">Change</a>
                                                <a href="/shop/delete?id=<?= $products[$i]["productID"]; ?>&confirm=true" class="product-delete-btn">Delete</a>
                                            </div>
                                        </td>
                                    </tr>
                                <? endfor; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="product-chart product-right">
                    <div class="product-chart__title">Quantity of sales</div>
                    <div class="product-chart__subtitle">By categories</div>
                    <canvas id="product-chart">
                    </canvas>
                    <div class="product-chart__legend">
                        <? for ($i = 0; $i < count($categoryList); $i++) : ?>
                            <div class="legend-item">
                                <div class="item-left">
                                    <div class="legend-item__color" style="background-color: <?= $chartBackgroundColor[$i]; ?>;"></div>
                                    <div class="legend-item__name"><?= $categoryList[$i]; ?></div>
                                </div>
                                <div class="legend-item__percent item-right"><?= $percentOfSales[$i]; ?>%</div>
                            </div>
                        <? endfor; ?>
                    </div>
                </div>
            </div>
        </section>

    <? else : ?>
        <section class="product-section">
            <div class="product-section__body">
                <div class="product-left">
                    <div class="product-section__header">
                        <h1 class="product-section__title">
                            Product section
                        </h1>
                        <a href="/shop/add" class="product-section__add-button"><i class="fas fa-plus"></i></a>
                    </div>
                    <div class="product-section__body">
                        <div class="product-section__empty">
                            <div class="product-section__empty-error-title">Sorry, but there's nothing here :(</div>
                            <div class="product-section__empty-error-subtitle">Press "+" button to add new product</div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    <? endif; ?>

    <? if ($orderList !== []) : ?>

        <?
        $productsByID = [];
        ?>

        <section class="orders-section">
            <h1 class="orders-section__title">
                Orders
            </h1>
            <div class="orders-section__table-wrapper">
                <table class="orders-section__table" cellpadding="0" cellspacing="0">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Product Image</th>
                            <th>Product Name</th>
                            <th>Client's Id</th>
                            <th>Client's Name</th>
                            <th>Email</th>
                            <th>Address</th>
                            <th>Phone Number</th>
                            <th>Quantity</th>
                            <th>Shipping Method</th>
                            <th>Price</th>
                            <th>Added</th>
                            <th>Status</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        <? for ($i = 0; $i < count($orderList); $i++) : ?>

                            <?
                            foreach ($products as $product) {
                                if (!isset($productsByID[$orderList[$i]['productID']])) {
                                    if ($product['productID'] === $orderList[$i]['productID']) {
                                        $productsByID[$orderList[$i]['productID']] = $product;
                                    }
                                }
                            }
                            ?>
                            <tr>
                                <td>
                                    <?=
                                    $orderList[$i]["orderID"] !== null ? $orderList[$i]["orderID"] : "<i>NULL</i>";
                                    ?>
                                </td>
                                <td>
                                    <a href="/shop/product?id=<?= $productsByID[$orderList[$i]['productID']]["productID"]; ?>">
                                        <div class="image-wrapper">
                                            <? if (is_file($productImageDir . $productsByID[$orderList[$i]['productID']]['image']  . '_s.png')) : ?>
                                                <img src="\<?= $productImageDir . $productsByID[$orderList[$i]['productID']]['image'] . '_s.png'; ?>" alt="<?= $products[$i]["productShortName"]; ?>" class="image" />
                                            <? endif; ?>
                                        </div>
                                    </a>
                                </td>
                                <td>
                                    <div class="product-name">
                                        <a href="/shop/product?id=<?= $productsByID[$orderList[$i]['productID']]["productID"]; ?>" class="product-name--link">
                                            <?=
                                            ($productsByID[$orderList[$i]['productID']]["productName"] !== null) ? $productsByID[$orderList[$i]['productID']]["productName"] : "<i>NULL</i>";
                                            ?>
                                        </a>
                                    </div>
                                    <? if (!empty($productsByID[$orderList[$i]['productID']]["productMaterial"])) : ?>
                                        <div class="product-material">
                                            <?= $productsByID[$orderList[$i]['productID']]["productMaterial"]; ?>
                                        </div>
                                    <? endif; ?>
                                </td>
                                <td>
                                    <?=
                                    $orderList[$i]["userID"] !== null ? $orderList[$i]["userID"] : "<i>NULL</i>";
                                    ?>
                                </td>
                                <td>
                                    <?
                                    $clientsName = '';
                                    if ($orderList[$i]["firstname"] !== null)
                                        $clientsName = $orderList[$i]["firstname"] . ' ';

                                    if ($orderList[$i]["lastname"] !== null)
                                        $clientsName .= $orderList[$i]["lastname"];

                                    echo $clientsName !== '' ? $clientsName : "<i>Null</i>";
                                    ?>
                                </td>
                                <td>
                                    <?=
                                    $orderList[$i]["email"] !== null ? $orderList[$i]["email"] : "<i>NULL</i>";
                                    ?>
                                </td>
                                <td>
                                    <?
                                    $address = '';

                                    $address .= ($orderList[$i]["company"] !== '') && ($orderList[$i]["company"] !== null) ? $orderList[$i]["company"] . ', ' :  '';
                                    $address .= $orderList[$i]["address"] !== null ? $orderList[$i]["address"] . ', ' :  '';
                                    $address .= ($orderList[$i]["apartment"] !== '') && ($orderList[$i]["apartment"] !== null) ? $orderList[$i]["apartment"] . ', ' :  '';
                                    $address .= $orderList[$i]["postalCode"] !== null ? $orderList[$i]["postalCode"] . ', ' :  '';
                                    $address .= $orderList[$i]["city"] !== null ? $orderList[$i]["city"] . ', ' :  '';
                                    $address .= $orderList[$i]["country"] !== null ? $orderList[$i]["country"] :  '';

                                    echo $address;
                                    ?>
                                </td>
                                <td>
                                    <?=
                                    $orderList[$i]["phone"] !== null ? $orderList[$i]["phone"] : "<i>NULL</i>";
                                    ?>
                                </td>
                                <td>
                                    <?=
                                    $orderList[$i]["quantity"] !== null ? $orderList[$i]["quantity"] : "<i>NULL</i>";
                                    ?>
                                </td>
                                <td>
                                    <?=
                                    $orderList[$i]["shippingMethod"] !== null ? $orderList[$i]["shippingMethod"] : "<i>NULL</i>";
                                    ?>
                                </td>
                                <td>
                                    <?=
                                    $orderList[$i]["price"] !== null ? '<b>$' . $orderList[$i]["price"] . "</b>" : "<i>NULL</i>";
                                    ?>
                                </td>
                                <td>
                                    <?=
                                    $orderList[$i]["datetime"] !== null ? date('M j Y, H:i:s', strtotime($orderList[$i]["datetime"])) : "<i>NULL</i>";
                                    ?>
                                </td>
                                <td>
                                    <div class="order-status status-<?= $orderList[$i]["status"]; ?>">
                                        <?= $orderList[$i]["status"]; ?>
                                    </div>
                                </td>
                                <td>
                                    <div class="controls">
                                        <a href="/panel/edit?object=order&id=<?= $orderList[$i]["orderID"]; ?>" class="order-change-btn">Change</a>
                                        <a href="/panel/delete?object=order&id=<?= $orderList[$i]["orderID"]; ?>&confirm=true" class="order-delete-btn">Delete</a>
                                    </div>
                                </td>
                            </tr>
                        <? endfor; ?>
                    </tbody>
                </table>
            </div>
        </section>
    <? else : ?>
        <section class="orders-section">
            <h1 class="orders-section__title">
                Orders
            </h1>
            <div class="orders-section__body">
                <div class="orders-section__empty">
                    <div class="orders-section__empty-error-title">Sorry, but there's nothing here :(</div>
                </div>
            </div>
        </section>
    <? endif; ?>
</main>

<script src="/node_modules/chart.js/dist/chart.min.js"></script>

<script>
    const totalSalesPhpArray = <?= json_encode($totalSalesPerDay); ?>;
    const quantitySalesByCategories = <?= json_encode($salesByCategiries) ?>;
    const categoryList = <?= json_encode($categoryList) ?>;
    const chartBackgroundColor = <?= json_encode($chartBackgroundColor) ?>;
    const test = <?= json_encode($users); ?>;

    console.log(test);
</script>