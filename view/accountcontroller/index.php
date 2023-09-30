<?php

use files\library\mainFunctions;
use models\AccountModel;
use models\ProductModel;

$functions = new mainFunctions();
$userModel = new AccountModel();
$productModel = new ProductModel();

$user = $userModel->getCurrentUser();
$countries = $functions->getCountries();
$orderList = $productModel->getOrderList(['userID' => $user['UserID']], ['datetime' => 'DESC']);
$products = $productModel->getProducts();

?>

<main id="main">
    <? if (!empty($messageClass)) : ?>
        <div class="error-alert-block alert-<?= $messageClass ?>" role="alert">
            <div class="error-alert-block__header action_clck" id='err-dropdown-btn'>
                <div class="error-alert-block__title">
                    <span class="material-symbols-outlined">info</span>
                    <?= $warningsCount ?> errors found
                </div>
                <div class="error-alert-block__dropdown-btn"><i class="fas fa-chevron-right" id="error-dropdown-arrow"></i></div>
            </div>
            <div class="error-alert-block__text">
                <?= $messageText ?>
            </div>
        </div>
    <? endif; ?>

    <div class="personal-account" id="personal-account">
        <div class="main-title">Personal Information</div>
        <section class="userInfoBlock">
            <fieldset class="userInfoBlock__PersonalInfo">
                <legend class="userInfoBlock__PersonalInfo-title">
                    <i class="far fa-user"></i>&nbsp;&nbsp;Personal Information
                </legend>
                <div class="userInfoBlock__formBlock">
                    <form method="post">
                        <table>
                            <tr>
                                <td>
                                    <div class="userInfoBlock__input-block">
                                        <label for="user-personalInfo-firstName">First Name</label>
                                        <div type="text" placeholder="Enter your first name" id="user-personalInfo-firstName" name="firstname" class="userInfoBlock__infoInput">
                                            <?= ($user['firstname'] !== null) ? $user['firstname'] : "Not specified"; ?>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <div class="userInfoBlock__input-block">
                                        <label for="user-personalInfo-lastName">Last Name</label>
                                        <div type="text" placeholder="Enter your last name" id="user-personalInfo-lastName" name="lastname" class="userInfoBlock__infoInput">
                                            <?= ($user['lastname'] !== null) ? $user['lastname'] : "Not specified"; ?>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <div class="userInfoBlock__input-block">
                                        <label for="user-personalInfo-gender">Gender</label>
                                        <div type="text" placeholder="What's your gender" id="user-personalInfo-gender" name="gender" class="userInfoBlock__infoInput">
                                            <?= ($user['gender'] !== null) ? $user['gender'] : "Not specified"; ?>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <div class="userInfoBlock__input-block">
                                        <label for="user-personalInfo-birthdayDate">Birthday date</label>
                                        <div type="date" placeholder="Enter your date of birth" id="user-personalInfo-birthdayDate" name="birthdayDate" class="userInfoBlock__infoInput" min='1920-01-01' max='<?= date('Y-m-d'); ?>'>
                                            <?= ($user['birthdayDate'] !== null) ? $user['birthdayDate'] : "Not specified"; ?>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <div class="userInfoBlock__input-block">
                                        <label for="user-personalInfo-phoneNum">Phone number</label>
                                        <div type="text" placeholder="+1 123-456-7890" id="user-personalInfo-phoneNum" name="telephone" class="userInfoBlock__infoInput">
                                            <?= ($user['telephone'] !== null) ? $user['telephone'] : "Not specified"; ?>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <div class="userInfoBlock__input-block">
                                        <label for="user-personalInfo-email">Email</label>
                                        <div type="email" placeholder="Enter your email" id="user-personalInfo-email" name="email" class="userInfoBlock__infoInput">
                                            <?= ($user['email'] !== null) ? $user['email'] : "Not specified"; ?>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        </table>
                        <div class="userInfoBlock__changing-info-controls controls-block">
                            <span class="userInfoBlock__changing-info-control-button cancel-btn" id="user-info-button-cancel-changes">Cancel</span>
                            <button type="submit" name="save" class="userInfoBlock__changing-info-control-button save-btn" id="user-info-button-save-changes" value="user-info">Save</buuton>
                        </div>
                    </form>
                    <button class="userInfoBlock__change-info change-btn" id="user-info-button-change">Change</button>
                </div>
            </fieldset>
        </section>

        <section class="user-address-section">
            <fieldset class="user-address-section__fieldset">
                <legend class="user-address-section__title">
                    <i class="fas fa-shipping-fast"></i>&nbsp;&nbsp;Shipping Address
                </legend>
                <form method="post">
                    <div class="user-address-section__block">
                        <? if (!empty($user["address"]) || !empty($user["apartment"]) || !empty($user["city"]) || !empty($user["postalCode"]) || !empty($user["country"])) : ?>
                            <div class="user-address-section__label">
                                Address
                            </div>
                            <div class="user-address-section__content">
                                <?
                                $address = '';

                                $address .= ($user["address"] !== '') && ($user["address"] !== null) ? $user["address"] . ', ' :  '';
                                $address .= ($user["apartment"] !== '') && ($user["apartment"] !== null) ? $user["apartment"] . ', ' :  '';
                                $address .= ($user["city"] !== '') && ($user["city"] !== null) ? $user["city"] . ', ' :  '';
                                $address .= ($user["postalCode"] !== '') && ($user["postalCode"] !== null) ? $user["postalCode"] . ', ' :  '';
                                $address .= ($user["country"] !== '') && ($user["country"] !== null) ? $user["country"] :  '';

                                echo $address;
                                ?>
                            </div>
                        <? else : ?>
                            <div class="user-address-section__label">
                                Address not specified
                            </div>
                        <? endif; ?>
                    </div>
                    <div class="user-address-section__change-block">
                        <div class="user-address-section__change-block-content">
                            <div class="user-address-section__input-block">
                                <label for="user-address">Address</label>
                                <input type="text" id="user-address" name="address" class="user-address-section__input" value="<?= ($user['address'] !== null) ? $user['address'] : false; ?>">
                            </div>
                            <div class="user-address-section__input-block">
                                <label for="user-appartment">Apartment, suite, etc. (optional)</label>
                                <input type="text" id="user-appartment" name="apartment" class="user-address-section__input" value="<?= ($user['apartment'] !== null) ? $user['apartment'] : false; ?>">
                            </div>
                            <div class="user-address-section__input-block">
                                <label for="user-postalCode">Postal Code</label>
                                <input type="text" id="user-postalCode" name="postalCode" class="user-address-section__input" value="<?= ($user['city'] !== null) ? $user['postalCode'] : false; ?>">
                            </div>
                            <div class="user-address-section__input-block">
                                <label for="user-city">City</label>
                                <input type="text" id="user-city" name="city" class="user-address-section__input" value="<?= ($user['postalCode'] !== null) ? $user['city'] : false; ?>">
                            </div>
                            <div class="user-address-section__input-block">
                                <label for="country">Country</label>
                                <select id="country" name="country" class="user-address-section__input">
                                    <? foreach ($countries as $key => $value) : ?>
                                        <option value="<?= $key ?>" <?= ($user['country'] === $key) ? "selected" : false; ?>><?= $value ?></option>
                                    <? endforeach; ?>
                                </select>
                            </div>
                        </div>
                        <div class="user-address-section__changing-info-controls controls-block" id="user-address-change-controls-block">
                            <span class="user-address-section__cancel-button cancel-btn" id="user-address-button-cancel-changes">Cancel</span>
                            <button type="submit" name="save" class="user-address-section__save-address-button save-btn" id="user-address-button-save-changes" value="user-address">Save</buuton>
                        </div>
                    </div>
                </form>
                <button class="user-address-section__change-info change-btn" id="user-address-button-change-info">Change</button>
            </fieldset>
        </section>

        <section class="orders-section" id="user-order">
            <fieldset class="orders-section__fieldset">
                <legend class="orders-section__title">
                    <i class="fas fa-boxes"></i>&nbsp;&nbsp;Orders
                </legend>
                <? if (!empty($orderList)) : ?>
                    <div class="orders-section__table-wrapper">
                        <table class="orders-section__table" cellpadding="0" cellspacing="0">
                            <thead>
                                <tr>
                                    <th>Order ID</th>
                                    <th>Product Image</th>
                                    <th>Product Name</th>
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
                                                    <? if (is_file('files/products/' . $productsByID[$orderList[$i]['productID']]['image']  . '_s.png')) : ?>
                                                        <img src="/files/products/<?= $productsByID[$orderList[$i]['productID']]['image'] . '_s.png'; ?>" alt="<?= $products[$i]["productShortName"]; ?>" class="image" />
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
                                                <? if ($orderList[$i]["status"] !== "Canceled" && $orderList[$i]["status"] !== "Complete") : ?>
                                                    <a href="/account?id=<?= $orderList[$i]["orderID"]; ?>&action=cancel-order" class="order-change-btn">Cancel</a>
                                                <? endif; ?>
                                            </div>
                                        </td>
                                    </tr>
                                <? endfor; ?>
                            </tbody>
                        </table>
                    </div>
                <? else : ?>
                    <div class="orders-section__empty-block">
                        <h2 class="orders-section__empty-title">
                            Order list is empty
                        </h2>
                        <div class="orders-section__empty-subtitle">
                            You haven't ordered anything yet
                        </div>
                        <a href="/shop/" class="orders-section__shop-link">Go to shop</a>
                    </div>
                <? endif; ?>
            </fieldset>
        </section>

        <section class="account-control">
            <a href="/account/logout" class="account-control__user-logout">Log Out</a>
            <span class="account-control__user-delete">Delete account</span>
            <div class="account-control__modal-block-background" id="modal-block-background"></div>
            <div class="account-control__modal-block-content" id="modal-block-content">
                <h2>Are you sure you want to permanently delete this account?</h2>
                <span class="account-control__modal-content-cancel">Cancel</span>
                <a href="/account/delete?id=<?= $user['UserID'] ?>&confirm=true" class="account-control__modal-content-delete">Delete</a>
            </div>
        </section>
    </div>
</main>

<?
$addressArray = [];
array_push(
    $addressArray,
    $user["address"] !== null ? $user["address"] : "",
    $user["apartment"] !== null ? $user["apartment"] : "",
    $user["city"] !== null ? $user["city"] : "",
    $user["postalCode"] !== null ? $user["postalCode"] : "",
    $user["country"] !== null ? $user["country"] : ""
);
?>

<script>
    const addressArray = <?= json_encode($addressArray) ?>;
</script>