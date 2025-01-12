<?php

use core\Configuration;
use core\Logger;
use models\AccountModel;
use models\ProductModel;

$userModel = new AccountModel();
$productModel = new ProductModel();

$user = $userModel->getCurrentUser();
$categories = $productModel->getCategories();
$products = $productModel->getProducts();
$sellers = $userModel->getUsers(['access' => 2]);
$productImageDir = Configuration::get('paths', 'Paths')['ProductImagesDirRelative'];
// --------------------------------------------------------------------------------------
// Getting seller order list
$totalsales = 0;

$sellerProduct = [];
$productsID = [];
foreach ($products as $product) {
    if ($product['sellerID'] == $user['UserID']) {
        array_push($sellerProduct, $product);
        array_push($productsID, $product['productID']);
    }
}

$products = $sellerProduct;

foreach ($products as $product) {
    $totalsales += $product['sales'];
}

$orderWhereString = '`productID` = ' . implode(" OR `productID` = ", $productsID);

$orderList = $productModel->getOrderList($orderWhereString, ['datetime' => 'DESC']);
$orderList = $orderList === null ? [] : $orderList;


$revenue = 0;
foreach ($orderList as $order) {
    if ($order['status'] !== 'Canceled')
        $revenue += $order['price'];
}

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
                                                        <img src="/<?= $productImageDir . $products[$i]['image'] . '_s.png'; ?>" alt="<?= $products[$i]["productShortName"]; ?>" class="image" />
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
                    <div class="orders-section__empty-error-title">Sorry, there’s nothing here.<br /><span>Maybe it’s hiding in the grain?</span></div>
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

    console.log(totalSalesPhpArray);
</script>