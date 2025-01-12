<?php

use core\Configuration;
use models\AccountModel;

$userModel = new AccountModel();
$productImageDir = Configuration::get('paths', 'Paths')['ProductImagesDirRelative'];
$user = $userModel->isUserAuthenticated() ? $userModel->getCurrentUser() : NULL;
?>

<main id="main">
    <? if ($userModel->isUserAuthenticated() && $user['UserID'] === $model['sellerID'] || $userModel->getUserAccessLevel() == 3) : ?>
        <section class="access-product-controls-section">
            <div class="access-product-controls-section__access-product-controls" id="access-product-controls">
                <a href="/shop/edit?id=<?= $_GET['id'] ?>" class="access-product-controls-section__product-edit">Edit product</a>
                <span class="header-right access-product-controls-section__product-delete-modal-block" id="product-delete-modal-block-button">Delete product</span>
                <div class="access-product-controls-section__modal-product-background" id="modal-product-background"></div>
                <div class="access-product-controls-section__modal-content-product" id="modal-content-product">
                    <h2>Are you sure you want to permanently delete this product?</h2>
                    <span class="access-product-controls-section__modal-content-cancel">Cancel</span>
                    <a href="/shop/delete?id=<?= $_GET['id'] ?>&confirm=true" class="access-product-controls-section__modal-content-delete">Delete</a>
                </div>
            </div>
            <div class="access-product-controls-section__dropdown-arrow">
                <i class="fas fa-chevron-up" id="product-controls-dropdown-arrow"></i>
            </div>
        </section>

    <? endif; ?>

    <? if (!empty($messageClass)) : ?>
        <div class="snackbar snack-<?= $messageClass ?>" role="alert">
            <div class="snackbar__header" id='dropdown-btn'>
                <div class="snackbar__title"><?= $messageText ?></div>
            </div>
        </div>
    <? endif; ?>

    <section class="product">
        <div class="product__container">
            <div class="product__image-wrapper">
                <? if (is_file($productImageDir . $model['image']  . '_xl.png')) : ?>
                    <img src="\<?= $productImageDir . $model['image']  . '_xl.png'; ?>" class="image__img">
                <? endif; ?>
            </div>
        </div>
        <div class="product__container">
            <div class="product__product-info-block">
                <div class="product__title"><?= $model["productName"]; ?></div>
                <div class="product__material"><?= $model["productMaterial"]; ?></div>
                <div class="product__price">$<?= $model["price"]; ?></div>

                <? if ($model['quantity'] > 0) : ?>
                    <a href="/shop/product?id=<?= $_GET['id'] ?>&action=add" class="product__add-to-cart-btn">Add to cart</a>
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