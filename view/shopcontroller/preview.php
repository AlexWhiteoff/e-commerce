<?php

use models\AccountModel;

$userModel = new AccountModel();
$user = $userModel->getCurrentUser();
?>
<main id="main" class='preview'>
    <section class="product">
        <div class="product__container-left">
            <div class="product__image-wrapper">
            </div>
        </div>
        <div class="product__container-right">
            <div class="product__product-info-block">
                <div class="product__title"><?= $model["productName"]; ?></div>
                <div class="product__material"><?= $model["productMaterial"]; ?></div>
                <div class="product__price">$<?= $model["price"]; ?></div>

                <? if ($model['count'] > 0) : ?>
                    <span class="product__add-to-cart-btn">Add to cart</span>
                <? else : ?>
                    <span class="product__out-of-stock-btn">Out Of Stock</span>
                <? endif; ?>

                <span class="product__ships-in">Ships In 2-3 Weeks</span>
            </div>
        </div>
    </section>

    <section class="description">
        <h2 class="description__title"><?= $model["descriptionTitle"]; ?></h2>
        <div class="description__text"><?= $model["descriptionText"]; ?></div>
    </section>

    <section class="specifications">
        <h2 class="specifications__title">Technical Specifications</h2>
        <div class="specifications__info">
            <div class="specifications__material">
                <div class="specifications__material-subtitle">material</div>
                <div class="specifications__material-text"><?= $model["material"]; ?></div>
            </div>
            <div class="specifications__dimensions">
                <div class="specifications__dimensions-subtitle">dimensions</div>
                <div class="specifications__dimensions-text"><?= $model["dimensions"]; ?></div>
            </div>
            <div class="specifications__origin">
                <div class="specifications__origin-subtitle">origin</div>
                <div class="specifications__origin-text"><?= $model["origin"]; ?></div>
            </div>
        </div>
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

<script>
    const imgURL = <?= json_encode($productModel['imgPath']); ?>;
    const imageWrapper = document.querySelector(".product__image-wrapper");
    if (imgURL === null) {
        const productImgURL = "/files/products/" + <?= json_encode($productModel["image"] . '_xl.png') ?>;
        document.addEventListener("DOMContentLoaded", () => {
            const image = document.createElement("img");
            image.src = productImgURL;
            imageWrapper.appendChild(image);
        });
    } else {
        document.addEventListener("DOMContentLoaded", () => {
            const image = document.createElement("img");
            image.src = imgURL;
            imageWrapper.appendChild(image);
        });
    }
</script>