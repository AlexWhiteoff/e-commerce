<?php

use core\Configuration;
use models\ProductModel;

$Model = new ProductModel();
$categories = $Model->getCategories();

$productImageDir = Configuration::get('paths', 'Paths')['ProductImagesDirRelative'];

$date = new \DateTime('-1 month');
$previousMonthDate = $date->format('Y-m-d');
?>

<main id="main">
    <section class="banner-desk-shelf-system-shop">
        <div class="banner-desk-shelf-system-shop__image"></div>
        <div class="banner-desk-shelf-system-shop__innerText">
            <h1 class="banner-desk-shelf-system-shop__title">Bring Your Imagination to Life</h1>
        </div>
    </section>
    <section class="shop-list">
        <? if (!empty($products)) : ?>
            <? foreach ($products as $product) : ?>
                <div class="shop-list__product">
                    <a href="/shop/product?id=<?= $product["productID"] ?>">
                        <? if ($product['added'] > $previousMonthDate) : ?>
                            <div class="shop-list__product-label new-label-wrapper">
                                <div class="shop-list__product-label new-label"></div>
                            </div>
                        <? endif; ?>
                        <div class="shop-list__product-background">
                            <div class="shop-list__image-wrapper">
                                <? if (is_file($productImageDir . $product['image']  . '_l.png')) : ?>
                                    <img src="/<?= $productImageDir . $product['image'] . '_l.png'; ?>" alt="<?= $product["productShortName"]; ?>" class="shop-list__image" />
                                <? endif; ?>
                            </div>
                            <div class="shop-list__product-title"><?= $product["productShortName"]; ?></div>
                            <div class="shop-list__product-price">$<?= $product["price"]; ?></div>
                        </div>
                    </a>
                </div>
            <? endforeach; ?>
        <? else : ?>
            <div class="shop-list__empty">
                <div class="shop-list__empty-error-title">Sorry, but there's nothing here :(</div>
                <div class="shop-list__empty-error-subtitle">Let's head back and explore more, you're bound to find something you'll love!</div>
            </div>
        <? endif; ?>
    </section>

    <section class="brand-highlight">
        <div class="brand-highlight__innerText">
            <div class="logo-image"></div>
            <h2 class="brand-highlight__title">Create Your Space</h2>
            <div class="brand-highlight__subtitle">
                Transform your interior with pieces that reflect your style and elevate your everyday.
            </div>
        </div>
    </section>
</main>