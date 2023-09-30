<?php

use models\AccountModel;
use models\ProductModel;

$pathParts = [];

if (array_key_exists('path', $_GET)) {
    $path = $_GET['path'];
    $pathParts = explode('/', $path);
}

empty($pathParts[0]) ? $className = 'Home' : $className = ucfirst($pathParts[0]);

$userModel = new AccountModel();

if ($userModel->isUserAuthenticated()) {
    $user = $userModel->getCurrentUser();
    $productModel = new ProductModel();
    $cartProducts = $productModel->getCartProductsByUserId($user['UserID']);
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title><?= $namePage ?></title>
    <link rel="stylesheet" href="/view/sourse/css/header.css">
    <link rel="stylesheet" href="/view/sourse/css/style<?= $className ?>.css">
    <link rel="stylesheet" href="/view/sourse/css/footer.css">
    <link rel="icon" href="/view/images/gm_logo_small.png" type="image/png" sizes="16x16">

    <script src="https://kit.fontawesome.com/e0f50ec62a.js" crossorigin="anonymous"></script>
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@48,400,0,-25" />
</head>

<body>
    <? if ($className != 'Checkout') : ?>
        <header id="header">
            <nav id="nav">
                <a href="/shop" class="header-left header__link">shop</a>
                <? if ($userModel->getUserAccessLevel() == 3) : ?>
                    <a href="/panel/admin" class="header-left header__link">panel</a>
                <? elseif ($userModel->getUserAccessLevel() == 2) : ?>
                    <a href="/panel/seller" class="header-left header__link">panel</a>
                <? endif; ?>

                <div class="header-left header__burder-menu" id="header-burder-menu">
                    <span></span>
                </div>

                <a href="/" class="logo header__link">
                    <div class="logo-image"></div>Grovemade
                </a>
                <? if ($userModel->isUserAuthenticated()) : ?>
                    <span href="#" class="header-right cart-modal-block" id="header-modal-cart-button">my cart</span>
                <? endif; ?>

                <div id="modal-block-cart-background"></div>

                <!-- shopping cart -->
                <? if ($userModel->isUserAuthenticated()) : ?>
                    <div id="modal-block-content-cart" class="modal-block-content-cart">
                        <div class="modal-block-content-cart__title">
                            My Cart
                        </div>

                        <? if (empty($cartProducts)) : ?>
                            <div class="modal-block-content-cart__cart-empty">
                                <hr>
                                <h2>Your Bag is Empty</h2>
                                <a href="/shop" class="modal-block-content-cart__back-to-shop">Back to shop</a>
                            </div>
                        <? else : ?>
                            <a href="/checkout/" class="modal-block-content-cart__checkout-button">Continue to check out</a>

                            <div class="modal-block-content-cart__product-list">
                                <?php
                                $totalPrice = 0;
                                foreach ($cartProducts as $cartProduct) :
                                ?>
                                    <?php
                                    $product = $productModel->getProductById($cartProduct['productID']);
                                    $totalPrice += $product['price'] * $cartProduct['quantity'];
                                    ?>

                                    <div class="modal-block-content-cart__product-item">
                                        <a href="/shop/product?id=<?= $product['productID'] ?>">
                                            <div class="modal-block-content-cart__image-wrapper">
                                                <? if (is_file('files/products/' . $product['image']  . '_m.png')) : ?>
                                                    <img src="/files/products/<?= $product['image'] . '_m.png'; ?>" class="modal-block-content-cart__image">
                                                <? endif; ?>
                                            </div>
                                        </a>
                                        <div class="modal-block-content-cart__overlay-info">
                                            <a href="/shop/product?id=<?= $product['productID'] ?>" class="link-text">
                                                <div class="modal-block-content-cart__overlay-product-title"><?= $product['productName']; ?></div>
                                                <div class="modal-block-content-cart__overlay-product-material"><?= $product['productMaterial']; ?></div>
                                            </a>
                                            <div class="modal-block-content-cart__overlay-product-quantity">
                                                <div class="modal-block-content-cart__overlay-product-quantity-label">Quantity: </div>
                                                <form method="post" action="/shop/product/update?id=<?= $product['productID'] ?>&action=update">
                                                    <input type="number" name='quantity' class="modal-block-content-cart__overlay-product-quantity-value" value="<?= $cartProduct['quantity']; ?>" min="1" max="50">
                                                    <button type="submit" class="modal-block-content-cart__overlay-product-quantity-update">Update</button>
                                                </form>
                                            </div>
                                            <div class="modal-block-content-cart__overlay-product-lead-time">Ships by <?= date("m/d/Y", mktime(0, 0, 0, date("m"), date('d') + 14, date('Y'))); ?></div>
                                        </div>
                                        <div class="modal-block-content-cart__product-price">$<?= $product['price'] * $cartProduct['quantity']; ?></div>
                                        <div class="modal-block-content-cart__product-remove-link"><a href="/shop/product/remove?id=<?= $product['productID'] ?>&action=remove">Remove</a></div>
                                    </div>
                                <? endforeach; ?>
                            </div>

                            <hr>

                            <div class="modal-block-content-cart__totals">
                                <div class="modal-block-content-cart__totals-label">Subtotal</div>
                                <div class="modal-block-content-cart__totals-value">$<?= $totalPrice; ?></div>
                            </div>

                            <a href="/checkout/" class="modal-block-content-cart__checkout-button">Continue to check out</a>
                        <? endif; ?>
                    </div>
                <? endif; ?>

                <? if (!$userModel->isUserAuthenticated()) : ?>
                    <span class="header-right account-modal-block" id="header-modal-account-button">account</span>

                    <div id="modal-block-account-background"></div>
                    <div id="modal-block-content-account">
                        <div class="modal-block-content__sign-inCust">
                            Already have an account?<br>
                            <a href="/account/login" class="modal-block-content__loginBtn">Sign-In</a>
                        </div>
                        <div class="modal-block-content__newCust">
                            New custumer?<br>
                            <a href="/account/registration" class="modal-block-content__CreateAccBtn">Create an account</a>
                        </div>
                    </div>
                <? else : ?>
                    <a href="/account/index" class="header-right header__link" id="header-modal-account-button">account</a>
                <? endif; ?>
                <div id="responsive-nav-block">
                    <a href="/shop" class="header__resonsive-button-shop">shop</a>
                    <? if ($userModel->getUserAccessLevel() == 3) : ?>
                        <a href="/panel/admin" class="header-left header__link">panel</a>
                    <? elseif ($userModel->getUserAccessLevel() == 2) : ?>
                        <a href="/panel/seller" class="header-left header__link">panel</a>
                    <? endif; ?>
                    <? if (!$userModel->isUserAuthenticated()) : ?>
                        <span class="header__resonsive-button-account account-modal-block" id="header-modal-account-button">account</span>
                    <? else : ?>
                        <a href="/account/index" class="header__resonsive-button-account account-modal-block" id="header-modal-account-button">account</a>
                    <? endif; ?>
                    <? if ($userModel->isUserAuthenticated()) : ?>
                        <span class="header__resonsive-button-cart cart-modal-block" id="header__resonsive-button-cart">my cart</span>
                    <? endif; ?>
                </div>
            </nav>
        </header>

    <? endif; ?>
    <?= $Content ?>