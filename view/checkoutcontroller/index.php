<?php

use files\library\mainFunctions;
use models\ProductModel;

$functions = new mainFunctions();
$productModel = new ProductModel;

$countries = $functions->getCountries();
?>

<main id="main">
    <? if (!empty($messageClass)) : ?>
        <div class="snackbar snack-<?= $messageClass ?>" role="alert">
            <div class="snackbar__header" id='dropdown-btn'>
                <div class="snackbar__title"><?= $warningsCount ?> errors found</div>
                <div class="snackbar__dropdown-btn"><i class="fas fa-chevron-right" id="snackbar-dropdown-arrow"></i></div>
            </div>
            <div class="snackbar__text">
            </div>
        </div>
    <? endif; ?>

    <article id="article">
        <section class="header">
            <a href="/" class="logo header__link">
                <div class="logo-image"></div>Grovemade
            </a>
            <div id="nav" class="header__navigation">
                <a href="/">Cart</a>
                <i class="fas fa-chevron-right"></i>
                <b>Information</b>
                <i class="fas fa-chevron-right"></i>
                <span class="disabled">Shipping</span>
                <i class="fas fa-chevron-right"></i>
                <span class="disabled">Payment</span>
            </div>
        </section>
        <section class="form-section">
            <form method="POST" action="/checkout?step=shipping_method">
                <div class="form-section__contact-info">
                    <h3 class="form-section__contact-info-title">Contact information</h3>
                    <input type="email" class="form-section__email-input" placeholder="Email" id="email" autocapitalize="off" spellcheck="false" id="checkout_email" name="email" value="<?= $moduleUser['email'] ?>">
                    <label for="email-checkbox">
                        <input type="checkbox" name="check" id="email-checkbox" class="checkbox form-section__email-checkbox" checked>
                        Email me with news and offers
                    </label>
                </div>
                <div class="form-section__shipping-address">
                    <h3 class="form-section__shipping-address-title">Shipping address</h3>
                    <select id="country" name="country">
                        <? foreach ($countries as $key => $value) : ?>
                            <option value="<?= $key; ?>"><?= $value; ?></option>
                        <? endforeach; ?>
                    </select>
                    <div class="row-block">

                        <? if ($moduleUser['firstname'] == null) : ?>
                            <input type="text" id="firstname" name="firstname" required placeholder="First name">
                        <? else : ?>
                            <input type="text" id="firstname" name="firstname" required placeholder="First name" value="<?= $moduleUser['firstname'] ?>">
                        <? endif; ?>

                        <? if ($moduleUser['lastname'] == null) : ?>
                            <input type="text" id="lastname" name="lastname" required placeholder="Last name">
                        <? else : ?>
                            <input type="text" id="lastname" name="lastname" required placeholder="Last name" value="<?= $moduleUser['lastname'] ?>">
                        <? endif; ?>

                    </div>
                    <input type="text" id="company" name="company" placeholder="Company (optional)">

                    <? if ($moduleUser['address'] == null) : ?>
                        <input type="text" id="address" name="address" required placeholder="Address">
                    <? else : ?>
                        <input type="text" id="address" name="address" required placeholder="Address" value="<?= $moduleUser['address'] ?>">
                    <? endif; ?>

                    <input type="text" id="apartment" name="apartment" placeholder="Apartment, suite, etc. (optional)">
                    <div class="row-block">
                        <input type="text" id="city" name="city" required placeholder="City">
                        <input type="text" id="postalCode" name="postalCode" required placeholder="Postal code">
                    </div>

                    <? if ($moduleUser['telephone'] == null) : ?>
                        <input type="text" id="phone" name="phone" required placeholder="Phone">
                    <? else : ?>
                        <input type="text" id="phone" name="phone" placeholder="Phone" value="<?= $moduleUser['telephone'] ?>">
                    <? endif; ?>

                    <label for="saveinfo-checkbox">
                        <input type="checkbox" name="saveinfo" id="saveinfo-checkbox" class="checkbox form-section__email-checkbox">
                        Save this information for next time
                    </label>
                    <div class="name-block">
                        <button type="submit" id="continue-button">Continue to shipping</button>
                        <a href="/">Return to main page</a>
                    </div>
                </div>
            </form>
        </section>
    </article>
    <aside id="aside" class="order-summary">
        <div class="order-summary__sections">

            <div class="order-summary__section order-summary__section--product-list">
                <?php
                $totalPrice = 0;
                foreach ($moduleCart as $cartProduct) :
                ?>
                    <?php
                    $product = $productModel->getProductById($cartProduct['productID']);
                    $totalPrice += $product['price'] * $cartProduct['quantity'];
                    ?>

                    <div class="order-summary__section--product-container">
                        <div class="order-summary__section--product-image-wrapper">
                            <? if (is_file('files/products/' . $product['image']  . '_s.png')) : ?>
                                <img src="/files/products/<?= $product['image'] . '_s.png'; ?>" class="order-summary__section--product-image">
                            <? endif; ?>
                        </div>
                        <div class="order-summary__section--product-quantity"><?= $cartProduct['quantity']; ?></div>
                        <div class="order-summary__section--product-title"><?= $product['productShortName']; ?></div>
                        <div class="order-summary__section--product-price">$<?= $product['price'] * $cartProduct['quantity']; ?></div>
                    </div>
                <? endforeach; ?>
            </div>
            <hr>
            <div class="order-summary__section--discount">
                <form method="get">
                    <? if ($_GET['discount'] == null) : ?>
                        <input type="text" name="discount" id="discount-input" class="order-summary__section--discount-input" placeholder="Gift card or discount code">
                    <? else : ?>
                        <input type="text" name="discount" id="discount-input" class="order-summary__section--discount-input" placeholder="Gift card or discount code" value="<?= $_GET['discount']; ?>">
                    <? endif; ?>
                    <button class="order-summary__section--discount-button-check" id="discount-button-check" type="submit">Apply</button>
                </form>
            </div>
            <hr>
            <div class="order-summary__section--subtotal">
                <div class="order-summary__section--subtotal-text">Subtotal</div>
                <div class="order-summary__section--subtotal-value">$<?= bcdiv($totalPrice, 1, 2); ?></div>
            </div>
            <div class="order-summary__section--subtotal">
                <div class="order-summary__section--subtotal-text">Discount</div>
                <div class="order-summary__section--subtotal-value">
                    <? if ($discount > 0)
                        echo $discount;
                    else
                        echo 0;
                    ?>
                    %</div>
            </div>
            <hr>
            <div class="order-summary__section--total">
                <div class="order-summary__section--total-text">Total</div>
                <div class="order-summary__section--total-currency">USD</div>
                <div class="order-summary__section--total-value" name='total-value'>
                    $<?
                        $discountPrice = $totalPrice * ($discount / 100);
                        $totalPrice = bcdiv($totalPrice - $discountPrice, 1, 2);
                        echo $totalPrice;
                        ?>
                </div>
            </div>
        </div>
    </aside>
</main>

<script>
    if (localStorage.getItem("checkOutFields") !== null) {
        document.addEventListener("DOMContentLoaded", () => {
            let checkOutFields = JSON.parse(localStorage.checkOutFields);
            for (const key in checkOutFields) {
                const element = document.getElementsByName(key)[0];
                if (element.value !== checkOutFields[key])
                    element.value = checkOutFields[key];
                if (key === 'saveinfo')
                    element.checked = checkOutFields[key];
            }
        });
    }

    let discountButton = document.getElementById("discount-button-check");
    let inputsArray = [];

    const saveCheckoutField = () => {
        inputsArray.push(document.getElementById("email"));
        inputsArray.push(document.getElementById("country"));
        inputsArray.push(document.getElementById("firstname"));
        inputsArray.push(document.getElementById("lastname"));
        inputsArray.push(document.getElementById("company"));
        inputsArray.push(document.getElementById("address"));
        inputsArray.push(document.getElementById("apartment"));
        inputsArray.push(document.getElementById("city"));
        inputsArray.push(document.getElementById("postalCode"));
        inputsArray.push(document.getElementById("phone"));
        inputsArray.push(document.getElementById("saveinfo-checkbox"));

        let checkOutFields = {};

        for (let i = 0; i < inputsArray.length; i++) {
            if (inputsArray[i].id === 'saveinfo-checkbox') {
                let elementName = inputsArray[i].getAttribute("name");
                checkOutFields[elementName] = inputsArray[i].checked;
                continue;
            }
            if (inputsArray[i].value !== '') {
                let elementName = inputsArray[i].getAttribute("name");
                checkOutFields[elementName] = inputsArray[i].value;
            }
        }
        localStorage.checkOutFields = JSON.stringify(checkOutFields);
        console.log("click");
    }

    discountButton.addEventListener("click", saveCheckoutField);

    const continueButton = document.getElementById("continue-button");
    console.log(document.getElementById("saveinfo-checkbox").checked);
    continueButton.addEventListener("click", () => {
        if (document.getElementById("saveinfo-checkbox").checked === true)
            saveCheckoutField();
    });
    <? if (!empty($messageClass)) : ?>
        var messageText = <? echo json_encode($messageText); ?>;
    <? endif; ?>
</script>