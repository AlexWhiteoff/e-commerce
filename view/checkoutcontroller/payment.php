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
                <a href="/checkout">Information</a>
                <i class="fas fa-chevron-right"></i>
                <a href="/checkout?step=shipping_method">Shipping</a>
                <i class="fas fa-chevron-right"></i>
                <b>Payment</b>
            </div>
        </section>
        <section class="form-section">
            <form method="POST" action="/checkout?successfully=true">
                <div class="form-section__info-block">
                    <div class="form-section__info-block--block">
                        <div class="form-section__info-block--name">Contact</div>
                        <div class="form-section__info-block--value"><?= $moduleUser['email']; ?></div>
                        <a href="/checkout" class="form-section__info-block--changeButton">Change</a>
                    </div>
                    <hr>
                    <div class="form-section__info-block--block">
                        <div class="form-section__info-block--name">Ship to</div>
                        <div class="form-section__info-block--value">
                            <?= $moduleUser['company'] !== '' ? $moduleUser['company'] . ', ' : ''; ?>
                            <?= $moduleUser['address']; ?>,
                            <?= $moduleUser['apartment'] !== '' ? $moduleUser['apartment'] . ', ' : ''; ?>
                            <?= $moduleUser['city']; ?>,
                            <?= $moduleUser['postalCode']; ?>,
                            <?= $moduleUser['country']; ?> </div>
                        <a href="/checkout" class="form-section__info-block--changeButton">Change</a>
                    </div>
                    <hr>
                    <div class="form-section__info-block--block">
                        <div class="form-section__info-block--name">Method</div>
                        <div class="form-section__info-block--value"><?
                                                                        if ($moduleUser['shippingMethod'] == 'UPS International')
                                                                            echo 'UPS International (Transit Time 7-14 Days)';
                                                                        else if ($moduleUser['shippingMethod'] == 'Small parcel')
                                                                            echo 'Small Parcel Local Post (Transit Time 30-40 Days, May Be Extended Due To COVID)';
                                                                        ?></div>
                        <a href="/checkout" class="form-section__info-block--changeButton">Change</a>
                    </div>
                </div>

                <div class="form-section__payment-block">
                    <div class="form-section__payment-block--header">
                        <h2 class="form-section__payment-block--title">Payment</h2>
                        <p class="form-section__payment-block--text">All transactions are secure and encrypted.</p>
                    </div>
                    <div class="form-section__payment-block--content-box">
                        <div class="form-section__payment-block--content-header">
                            <h3 class="form-section__payment-block--content-label">Credit card</h3>
                            <div class="form-section__payment-block--content-accessory">
                                <ul>
                                    <li class="payment-icon payment-icon--visa" id="visa"><span class="visually-hidden">Visa</span></li>
                                    <li class="payment-icon payment-icon--mastercard" id="mastercard"><span class="visually-hidden">Mastercard</span></li>
                                    <li class="payment-icon payment-icon--american-express" id="american-express"><span class="visually-hidden">American Express</span></li>
                                    <li class="payment-icon payment-icon--discover" id="discover"><span class="visually-hidden">Discover</span></li>
                                </ul>
                            </div>
                        </div>
                        <div class="form-section__payment-block--content-main">
                            <input type="text" name="card-number" id="card-number" maxlength="19" placeholder="Card number" inputmode="numeric" required>
                            <input type="text" name="card-name" id="card-name" placeholder="Name on card" required>
                            <input type="text" name="card-expiry" id="card-expiry" maxlength="7" placeholder="Expiration date (MM / YY)" inputmode="numeric" required>
                            <input type="text" name="card-security-code" id="card-security-code" placeholder="Security code" maxlength="4" inputmode="numeric" pattern="[0-9]{3,4}" required>
                        </div>
                    </div>
                </div>

                <div class="form-section__billing-address-block">
                    <div class="form-section__billing-address-block--header">
                        <h2 class="form-section__billing-address-block--title">Billing address</h2>
                        <p class="form-section__billing-address-block--text">Select the address that matches your card or payment method.</p>
                    </div>
                    <fieldset class="content-box">
                        <div class="form-section__billing-address-block--block">
                            <label for="radio-same-billing-address">
                                <div class="form-section__billing-address-block--check">
                                    <input type="radio" name="billing-address" id="radio-same-billing-address" value="same" checked>
                                </div>
                                <span class="form-section__billing-address-block--name">Same as shipping address</span>
                            </label>
                        </div>
                        <div class="form-section__billing-address-block--block">
                            <label for="radio-different-billing-address">
                                <div class="form-section__billing-address-block--check">
                                    <input type="radio" name="billing-address" id="radio-different-billing-address" value="different">
                                </div>
                                <span class="form-section__billing-address-block--name">Use a different billing address</span>
                            </label>
                        </div>
                        <div class="form-section__billing-address-block--block" id="different-billing-address">
                            <div class="form-section__billing-address">
                                <select id="country" name="country">
                                    <? foreach ($countries as $key => $value) : ?>
                                        <option value="<?= $key; ?>"><?= $value; ?></option>
                                    <? endforeach; ?>
                                </select>
                                <div class="row-block">
                                    <input type="text" id="firstname" name="firstname" placeholder="First name">
                                    <input type="text" id="lastname" name="lastname" placeholder="Last name">
                                </div>
                                <input type="text" id="company" name="company" placeholder="Company (optional)">
                                <input type="text" id="address" name="address" placeholder="Address">
                                <input type="text" id="apartment" name="apartment" placeholder="Apartment, suite, etc. (optional)">
                                <div class="row-block">
                                    <input type="text" id="city" name="city" placeholder="City">
                                    <input type="text" id="postalCode" name="postalCode" placeholder="Postal code">
                                </div>
                                <input type="text" id="phone" name="phone" placeholder="Phone">
                            </div>
                        </div>
                    </fieldset>
                </div>
                <div class="controls-block">
                    <button type="submit" id="continue-button">Continue to payment</button>
                    <a href="/checkout?step=shipping_method">Return to shipping</a>
                </div>
            </form>
        </section>
    </article>
    <aside id="aside" class="order-summary">
        <div class="order-summary__sections">

            <div class="order-summary__section order-summary__section--product-list">
                <?
                $totalPrice = 0;
                foreach ($moduleCart as $cartProduct) :
                    $product = $productModel->getProductById($cartProduct['productID']);
                    $totalPrice += $product['price'] * $cartProduct['quantity'];

                    $_SESSION['__cart']['product' . $cartProduct['productID']] = ($product['price'] * $cartProduct['quantity']) - ($product['price'] * $cartProduct['quantity']) * ($discount / 100);
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

            <?php
            $discountPrice = $totalPrice * ($discount / 100);
            $subtotal = bcdiv($totalPrice, 1, 2);
            $total = bcdiv($totalPrice - $discountPrice + $shipping * count($moduleCart), 1, 2);
            $_SESSION['__cart']['total'] = $total;
            ?>

            <div class="order-summary__section--subtotal">
                <div class="order-summary__section--subtotal-text">Subtotal</div>
                <div class="order-summary__section--subtotal-value">$<?= $subtotal; ?></div>
            </div>
            <? if ($discount > 0) : ?>
                <div class="order-summary__section--subtotal">
                    <div class="order-summary__section--subtotal-text">Discount</div>
                    <div class="order-summary__section--subtotal-value"><?= $discount; ?>%</div>
                </div>
            <? endif; ?>
            <div class="order-summary__section--subtotal">
                <div class="order-summary__section--subtotal-text">Shipping</div>
                <div class="order-summary__section--subtotal-value" id="shipping-value">
                    <?= count($moduleCart) > 1 ? '$' . bcdiv($shipping, 1, 2) . ' <i class="fas fa-times" style="font-size: 11px"></i> ' . count($moduleCart) . " = $" . bcdiv($shipping * count($moduleCart), 1, 2) : '$' . bcdiv($shipping, 1, 2); ?>
                </div>
            </div>
            <hr>
            <div class="order-summary__section--total">
                <div class="order-summary__section--total-text">Total</div>
                <div class="order-summary__section--total-currency">USD</div>
                <div class="order-summary__section--total-value" id="total-value" value="<?= $total; ?>">$<?= $total; ?></div>
            </div>
        </div>
    </aside>
</main>

<script src="https://unpkg.com/imask"></script>
<script src="/view/sourse/JavaScript/payment.js" async type="module"></script>