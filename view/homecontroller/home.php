<?php

use models\ProductModel;

$productModel = new ProductModel;

$products = $productModel->getProducts(['count > 0'], ['sales' => 'DESC']);

$date = new \DateTime('-1 month');
$previousMonthDate = $date->format('Y-m-d');
?>

<main id="main">
    <section class="banner-desk-shelf-system">
        <a href="/shop?subcategory=Desc Shelves" class="banner-desk-shelf-system__link">
            <div class="banner-desk-shelf-system__innerText">
                <h2 class="banner-desk-shelf-system__title">The Desk Shelf System</h2>
                <div class="banner-desk-shelf-system__subtitle">Available in Walnut or Matte Black</div>
                <span class="banner-desk-shelf-system__span">learn more</span>
            </div>
        </a>
    </section>

    <section class="design-inspires">
        <h2 class="design-inspires__title">Design Inspires</h2>
        <div class="design-inspires__text">Build your dream workspace, so you can get your best work done.</div>
        <a href="/shop/" class="design-inspires__goto_shop">get started</a>
    </section>

    <section class="sample-products">
        <div class="desk_pads">
            <div class="desk_pads__img"></div>
            <div class="desk_pads__text">Desk Pads</div>
            <a href="/shop?category=1" class="desk_pads__link link">learn more</a>
        </div>
        <div class="laptop_stands">
            <div class="laptop_stands__img"></div>
            <div class="laptop_stands__text">Laptop Stands</div>
            <a href="/shop?subcategory=Laptop Stands" class="laptop_stands__link link">learn more</a>
        </div>
    </section>

    <section class="featured_products">
        <h2 class="featured_products__title">Featured Products</h2>
        <div class="featured_products__text">See What’s Trending Right Now</div>
        <div class="featured_products-carousel">
            <? for ($i = 0; $i < 4; $i++) : ?>
                <div class="product">
                    <a href="/shop/product?id=<?= $products[$i]["productID"] ?>">
                        <? if ($products[$i]['added'] > $previousMonthDate) : ?>
                            <div class="product__label new-label-wrapper">
                                <div class="product__label new-label"></div>
                            </div>
                        <? endif; ?>
                        <div class="product__background">
                            <div class="product__image-wrapper">
                                <? if (is_file('files/products/' . $products[$i]['image']  . '_l.png')) : ?>
                                    <img src="/files/products/<?= $products[$i]['image'] . '_l.png'; ?>" alt="<?= $products[$i]["productShortName"]; ?>" class="product__image" />
                                <? endif; ?>
                            </div>
                            <div class="product__title"><?= $products[$i]["productShortName"]; ?></div>
                            <div class="product__price">$<?= $products[$i]["price"]; ?></div>
                        </div>
                    </a>
                </div>
            <? endfor; ?>
        </div>
    </section>

    <section class="banner-home-office-inspiration">
        <a href="http://grovemade/shop?category=3" class="banner-home-office-inspiration__link">
            <div class="banner-home-office-inspiration__innerText">
                <h2 class="banner-home-office-inspiration__title">Home Office Inspiration</h2>
                <div class="banner-home-office-inspiration__subtitle">Working from home can be a challenge—see some creative solutions to get it just right.</div>
                <span class="banner-home-office-inspiration__span">learn more</span>
            </div>
        </a>
    </section>

    <section class="about">
        <h2 class="about__title">Made The Hard Way</h2>
        <div class="about__text">
            Our signature craftsmanship has been honed over a decade of manufacturing innovation here in Portland, Oregon. We combine the skills of our small in-house team with the collective strength of collaborators throughout the US to deliver quality products worth investing in.
        </div>
        <div class="about__image">
            <img src="/view/images/https___siteleaf.grovemade.com_uploads_building.jpg" alt="building">
        </div>
    </section>

    <section class="employees">
        <h2 class="employees__title">Make Work Meaningful</h2>
        <div class="employees__text">
            We're here because we believe that your work deserves the best. A team that loves working together is the magic that makes it all happen.
        </div>
        <div class="employees__grid" id="grovemade-team">
            <img src="/view/images/employees/https___grovemade.com_shop-static_team_image1.jpg" alt="employee" class="employee" id="employee-1">
            <img src="/view/images/employees/https___grovemade.com_shop-static_team_image2.jpg" alt="employee" class="employee" id="employee-2">
            <img src="/view/images/employees/https___grovemade.com_shop-static_team_image3.jpg" alt="employee" class="employee" id="employee-3">
            <img src="/view/images/employees/https___grovemade.com_shop-static_team_image4.jpg" alt="employee" class="employee" id="employee-4">
            <img src="/view/images/employees/https___grovemade.com_shop-static_team_image5.jpg" alt="employee" class="employee" id="employee-5">
            <img src="/view/images/employees/https___grovemade.com_shop-static_team_image6.jpg" alt="employee" class="employee" id="employee-6">
            <img src="/view/images/employees/https___grovemade.com_shop-static_team_image7.jpg" alt="employee" class="employee" id="employee-7">
            <img src="/view/images/employees/https___grovemade.com_shop-static_team_image8.jpg" alt="employee" class="employee" id="employee-8">
            <img src="/view/images/employees/https___grovemade.com_shop-static_team_image9.jpg" alt="employee" class="employee" id="employee-9">
            <img src="/view/images/employees/https___grovemade.com_shop-static_team_image10.jpg" alt="employee" class="employee" id="employee-10">
            <img src="/view/images/employees/https___grovemade.com_shop-static_team_image11.jpg" alt="employee" class="employee" id="employee-11">
            <img src="/view/images/employees/https___grovemade.com_shop-static_team_image12.jpg" alt="employee" class="employee" id="employee-12">
            <img src="/view/images/employees/https___grovemade.com_shop-static_team_image13.jpg" alt="employee" class="employee" id="employee-13">
            <img src="/view/images/employees/https___grovemade.com_shop-static_team_image14.jpg" alt="employee" class="employee" id="employee-14">
            <img src="/view/images/employees/https___grovemade.com_shop-static_team_image15.jpg" alt="employee" class="employee" id="employee-15">
            <img src="/view/images/employees/https___grovemade.com_shop-static_team_image16.jpg" alt="employee" class="employee" id="employee-16">
            <img src="/view/images/employees/https___grovemade.com_shop-static_team_image17.jpg" alt="employee" class="employee" id="employee-17">
            <img src="/view/images/employees/https___grovemade.com_shop-static_team_image18.jpg" alt="employee" class="employee" id="employee-18">
            <img src="/view/images/employees/https___grovemade.com_shop-static_team_image19.jpg" alt="employee" class="employee" id="employee-19">
            <img src="/view/images/employees/https___grovemade.com_shop-static_team_image20.jpg" alt="employee" class="employee" id="employee-20">
            <img src="/view/images/employees/https___grovemade.com_shop-static_team_image21.jpg" alt="employee" class="employee" id="employee-21">
            <img src="/view/images/employees/https___grovemade.com_shop-static_team_image22.jpg" alt="employee" class="employee" id="employee-22">
            <img src="/view/images/employees/https___grovemade.com_shop-static_team_image23.jpg" alt="employee" class="employee" id="employee-23">
            <img src="/view/images/employees/https___grovemade.com_shop-static_team_image24.jpg" alt="employee" class="employee" id="employee-24">
        </div>
    </section>

    <section class="read-about">
        <h2 class="read-about__title">We Hope You'll Join Us</h2>
    </section>

    <section class="desing-inspiring">
        <div class="desing-inspiring__innerText">
            <div class="logo-image"></div>
            <h2 class="desing-inspiring__title">Design Inspires</h2>
            <div class="desing-inspiring__subtitle">
                Build your dream workspace, so you can get your best work done.
            </div>
        </div>
    </section>
</main>