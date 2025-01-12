<?php

use core\Configuration;
use models\ProductModel;

$productModel = new ProductModel;

$products = $productModel->getProducts(['count > 0'], ['sales' => 'DESC'], 4);

$date = new \DateTime('-1 month');
$previousMonthDate = $date->format('Y-m-d');
$productImageDir = Configuration::get('paths', 'Paths')['ProductImagesDirRelative'];

?>

<main id="main">
    <section class="banner-desk-shelf-system">
        <a href="/shop?category=1" class="banner-desk-shelf-system__link">
            <div class="banner-desk-shelf-system__innerText">
                <h2 class="banner-desk-shelf-system__title">Where Function Meets Elegance</h2>
                <div class="banner-desk-shelf-system__subtitle">Discover our premium wooden furniture collection, designed to elevate your productivity and style.</div>
                <div class="banner-desk-shelf-system__subtitle">Available in multiple designs and sizes to fit your needs.</div>
                <span class="banner-desk-shelf-system__span">Shop Now</span>
            </div>
        </a>
    </section>

    <section class="cta-banner">
        <h2 class="cta-banner__title">Design for Excellence</h2>
        <div class="cta-banner__text">Assemble your dream environment to excel in your work.</div>
        <a href="/shop/" class="cta-banner__goto_shop">get started</a>
    </section>

    <section class="sample-products">
        <div class="sample">
            <div class="sample__image-wrapper">
                <img src="/assets/images/sample/engraving.png" alt="Sample Image 1. Custom Engravings" class="sample__image" draggable="false" />
            </div>
            <div class="sample__text">Custom Engravings</div>
            <a href="/shop?category=Custom%20Engravings" class="sample__link link">Learn more</a>
        </div>
        <div class="sample">
            <div class="sample__image-wrapper">
                <img src="/assets/images/sample/giftset.png" alt="Sample Image 2. Gift sets" class="sample__image" draggable="false" />
            </div>
            <div class="sample__text">Gift Sets</div>
            <a href="/shop?subcategory=Gift%20Sets" class="sample__link link">Learn more</a>
        </div>
    </section>

    <section class="featured_products">
        <h2 class="featured_products__title">What’s Trending</h2>
        <div class="featured_products__text">Discover the Latest Trends Now</div>
        <div class="featured_products-carousel">
            <? foreach ($products as $product) : ?>
                <div class="product">
                    <a href="/shop/product?id=<?= $product["productID"] ?>">
                        <? if ($product['added'] > $previousMonthDate) : ?>
                            <div class="product__label new-label-wrapper">
                                <div class="product__label new-label"></div>
                            </div>
                        <? endif; ?>
                        <div class="product__wrapper">
                            <div class="product__image-wrapper">
                                <? if (is_file($productImageDir . $product['image']  . '_l.png')) : ?>
                                    <img
                                        src="/<?= $productImageDir . $product['image'] . '_l.png'; ?>"
                                        alt="<?= $product["productShortName"]; ?>"
                                        class="product__image"
                                        draggable="false" />
                                <? endif; ?>
                            </div>
                            <div class="product__title"><?= $product["productShortName"]; ?></div>
                            <div class="product__price">$<?= $product["price"]; ?></div>
                        </div>
                    </a>
                </div>
            <? endforeach; ?>
        </div>
    </section>

    <section class="banner-home-office-inspiration">
        <a href="/shop?category=3" class="banner-home-office-inspiration__link">
            <div class="banner-home-office-inspiration__innerText">
                <h2 class="banner-home-office-inspiration__title">Where Craft Meets Productivity</h2>
                <div class="banner-home-office-inspiration__subtitle">Elevate your workspace with elegant wooden designs, crafted to inspire focus and creativity in any office setting.</div>
                <span class="banner-home-office-inspiration__span">Explore the Collection</span>
            </div>
        </a>
    </section>

    <section class="cta-banner">
        <h2 class="cta-banner__title">Crafted with Passion</h2>
        <div class="cta-banner__text">
            Decades of innovation have honed our unique craftsmanship in Testville, Texora. Our dedicated team and US-wide collaborators create premium wooden designs for your space.
        </div>
        <div class="cta-banner__image-wrapper">
            <img src="/assets/images/promo/promo3.png" alt="Woodmade Team" class="cta-banner__image" draggable="false" />
        </div>
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