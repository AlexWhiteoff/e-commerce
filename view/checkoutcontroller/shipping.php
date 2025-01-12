<?php

use core\Configuration;
use models\ProductModel;

$productModel = new ProductModel;
$productImageDir = Configuration::get('paths', 'Paths')['ProductImagesDirRelative'];
?>

<main id="main">
    <article id="article">
        <section class="header">
            <a href="/" class="logo header__link">
                <div class="logo-image"></div>Woodmade
            </a>
            <div id="nav" class="header__navigation">
                <a href="/">Cart</a>
                <i class="fas fa-chevron-right"></i>
                <a href="/checkout">Information</a>
                <i class="fas fa-chevron-right"></i>
                <b>Shipping</b>
                <i class="fas fa-chevron-right"></i>
                <span class="disabled">Payment</span>
            </div>
        </section>
        <section class="form-section">
            <form method="POST" action="/checkout?previous_step=shipping_method&step=payment_method">
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
                            <?= $moduleUser['country']; ?>
                        </div>
                        <a href="/checkout" class="form-section__info-block--changeButton">Change</a>
                    </div>
                </div>
                <div class="form-section__shipping-block">
                    <h2 class="form-section__shipping-block--title">Shipping method</h2>
                    <fieldset class="content-box">
                        <div class="form-section__shipping-block--block">
                            <input type="radio" name="shippingMethod" id="radio_parcel_shipping-method" class="radio form-section__shipping-block--check" checked value="Small parcel">
                            <label for="radio_parcel_shipping-method" class="radio-label form-section__shipping-block--label">
                                <span class="form-section__shipping-block--name">Small parcel local post (transit time 30-40 days, may be extended due to COVID)</span>
                                <div class="form-section__shipping-block--price" id='small-parcel-price' data-price="20">$20.00</div>
                            </label>
                        </div>
                        <div class="form-section__shipping-block--block">
                            <input type="radio" name="shippingMethod" id="radio_ups_shipping-method" class="radio form-section__shipping-block--check" value="UPS International">
                            <label for="radio_ups_shipping-method" class="radio-label form-section__shipping-block--label">
                                <span class="form-section__shipping-block--name">UPS International (Transit time 7-14 days)</span>
                                <div class="form-section__shipping-block--price" id='ups-international-price' data-price="35">$35.00</div>
                            </label>
                        </div>
                    </fieldset>
                </div>
                <div class="controls-block">
                    <button type="submit" id="continue-button">Continue to payment</button>
                    <a href="/checkout">Return to Information</a>
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
                            <? if (is_file($productImageDir . $product['image']  . '_s.png')) : ?>
                                <img src="/<?= $productImageDir . $product['image'] . '_s.png'; ?>" class="order-summary__section--product-image" alt="Product thumbnail">
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
            $total = bcdiv($totalPrice - $discountPrice + 20, 1, 2);
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
                    <?= count($moduleCart) > 1 ? '$' . bcdiv(20, 1, 2) . ' <i class="fas fa-times" style="font-size: 11px"></i> ' . count($moduleCart) . " = $" . bcdiv(20 * count($moduleCart), 1, 2) : '$' . bcdiv(20, 1, 2); ?>
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

<script>
    let radio_parcel_shipping = document.getElementById("radio_parcel_shipping-method");
    let radio_UPS_shipping = document.getElementById("radio_ups_shipping-method");
    let total = document.getElementById("total-value");

    radio_parcel_shipping.addEventListener('change', () => {
        const currentPrice = +document.getElementById('small-parcel-price').getAttribute('data-price');
        const shippingPrice = document.getElementById("shipping-value");

        if (radio_parcel_shipping.checked === true) {
            <? if (count($moduleCart) === 1) : ?>
                shippingPrice.innerHTML = "$" + Number(currentPrice).toFixed(2);
                total.innerHTML = "$" + (Number(<?= $subtotal; ?>) + Number(currentPrice) - Number(<?= $discountPrice; ?>)).toFixed(2);
            <? else : ?>
                shippingPrice.innerHTML = "$" + currentPrice.toFixed(2) + ' <i class="fas fa-times" style="font-size: 11px"></i> ' + "<?= count($moduleCart) ?>" + " = $" + Number(currentPrice * <?= count($moduleCart) ?>).toFixed(2);
                total.innerHTML = "$" + (Number(<?= $subtotal; ?>) - Number(<?= $discountPrice; ?>) + Number(currentPrice * <?= count($moduleCart) ?>)).toFixed(2);
            <? endif; ?>
        }
    });

    radio_UPS_shipping.addEventListener('change', () => {
        let currentPrice = +document.getElementById('ups-international-price').innerHTML.slice(1);
        let shippingPrice = document.getElementById("shipping-value");

        if (radio_UPS_shipping.checked === true) {
            <? if (count($moduleCart) === 1) : ?>
                shippingPrice.innerHTML = "$" + Number(currentPrice).toFixed(2);
                total.innerHTML = "$" + (Number(<?= $subtotal; ?>) + Number(currentPrice) - Number(<?= $discountPrice; ?>)).toFixed(2);
            <? else : ?>
                shippingPrice.innerHTML = "$" + currentPrice.toFixed(2) + ' <i class="fas fa-times" style="font-size: 11px"></i> ' + "<?= count($moduleCart) ?>" + " = $" + Number(currentPrice * <?= count($moduleCart) ?>).toFixed(2);
                total.innerHTML = "$" + (Number(<?= $subtotal; ?>) - Number(<?= $discountPrice; ?>) + Number(currentPrice * <?= count($moduleCart) ?>)).toFixed(2);
            <? endif; ?>
        }
    });
</script>