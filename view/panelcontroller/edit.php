<?php

use core\Configuration;
use models\ProductModel;

$productModel = new ProductModel();
// $categories = $productModel->getCategories();
// $subcategories = $productModel->getSubcategories();

$exceptionRow = ['password', 'UserID', 'orderID', 'productID', 'userID'];

if ($_GET['object'] === 'user')
    $selectOptions = [
        3 => 'Admin',
        2 => 'Seller',
        1 => 'User'
    ];
else if ($_GET['object'] === 'order') {
    $selectOptions = [
        'Placed' => 'Placed',
        'Processed' => 'Processed',
        'Packing' => 'Packing',
        'Shipping' => 'Shipping',
        'Awaiting' => 'Awaiting',
        'Complete' => 'Complete',
        'Canceled' => 'Canceled'
    ];

    $product = $productModel->getProductById($model['productID']);
}

$productImageDir = Configuration::get('paths', 'Paths')['ProductImagesDirRelative'];

?>

<main id="main">
    <section class="edit-section" id="edit">
        <h1><?= ucfirst($_GET['object']); ?> Editing</h1>

        <? if ($_GET['object'] === 'order') : ?>
            <div class="product">
                <a href="/shop/product?id=<?= $product["productID"]; ?>" target="_blank">
                    <div class="product-image-wrapper">
                        <? if (is_file($productImageDir . $product['image']  . '_s.png')) : ?>
                            <img src="\<?= $productImageDir . $product['image'] . '_s.png'; ?>" alt="<?= $products[$i]["productShortName"]; ?>" class="product-image" />
                        <? endif; ?>
                    </div>
                    <div class="product-body">
                        <div class="product-title">
                            <?=
                            ($product["productName"] !== '') ? $product["productName"] : "'<i>NULL</i>'";
                            ?>
                        </div>
                        <? if (!empty($product["productMaterial"])) : ?>
                            <div class="product-subtitle">
                                <?= $product["productMaterial"]; ?>
                            </div>
                        <? endif; ?>
                    </div>
                </a>
            </div>
        <? endif; ?>

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

        <form method="post">
            <div class="form-wrapper">
                <table class='edit-form table'>
                    <? foreach ($model as $key => $value) : ?>
                        <? if (!in_array($key, $exceptionRow)) : ?>
                            <? if (!is_int($key)) : ?>
                                <tr>
                                    <td>
                                        <label for="input<?= ucfirst($key); ?>">
                                            <?= ucfirst($key); ?>
                                        </label>
                                    </td>
                                    <td>
                                        <? if ($key === 'email') : ?>

                                            <input type="email" value="<?= $value; ?>" name="<?= $key; ?>" id="input<?= ucfirst($key); ?>" class="input-text">

                                        <? elseif (stristr($key, 'date') && $key !== 'birthdayDate') : ?>

                                            <?
                                            $datetime = strtotime($value);
                                            $date = date('Y-m-d', $datetime);
                                            $time = date('H:i:s', $datetime);
                                            ?>
                                            <div class="input-datetime">
                                                <input type="date" value="<?= $date; ?>" name="date" class="input-date" max="<?= date('Y-m-d') ?>">
                                                <input type="time" value="<?= $time; ?>" name="time" step="1" class="input-time">
                                            </div>

                                        <? elseif ($key === 'birthdayDate') : ?>

                                            <input type="date" max="<?= date('Y-m-d') ?>" min="<?= date('Y-m-d', strtotime('1900-01-01')) ?>" value="<?= $value; ?>" name="<?= $key; ?>" id="input<?= ucfirst($key); ?>" class="input-date">

                                        <? elseif ($key === 'access' || $key === 'status') : ?>

                                            <select name="<?= $key ?>" class="input-select" id="input<?= ucfirst($key); ?>">
                                                <? foreach ($selectOptions as $selectKey => $selectValue) : ?>

                                                    <option value="<?= $selectKey ?>" <? echo ($selectKey == $model['access'] || $selectKey == $model['status']) ? 'selected' : '' ?>>
                                                        <?= $selectValue ?>
                                                    </option>

                                                <? endforeach; ?>
                                            </select>
                                        <? elseif ($key === 'gender') : ?>

                                            <select name="gender" id="gender" id="input<?= ucfirst($key); ?>" class="input-select">
                                                <option value="male">Male</option>
                                                <option value="female">Female</option>
                                            </select>

                                        <? else : ?>
                                            <input type="text" value="<?= $value; ?>" name="<?= $key; ?>" id="input<?= ucfirst($key); ?>" class="input-text">
                                        <? endif; ?>
                                    </td>
                                </tr>
                            <? endif; ?>
                        <? endif; ?>
                    <? endforeach; ?>
                    <tr class="edit-form__controls">
                        <td>
                            <a href="/panel/">Cancel</a>
                        </td>
                        <td>
                            <button type="submit" class="edit-section__update-button">Update</button>
                        </td>
                    </tr>
                </table>
            </div>
        </form>
    </section>
</main>

<script>
    <? if (!empty($messageClass)) : ?>
        var messageText = <? echo json_encode($messageText); ?>;
    <? endif; ?>
</script>