<?php

use models\ProductModel;

$Model = new ProductModel();
$categories = $Model->getCategories();

$date = new \DateTime('-1 month');
$previousMonthDate = $date->format('Y-m-d');
?>

<main id="main">
    <section class="banner-desk-shelf-system-shop">
        <div class="banner-desk-shelf-system-shop__innerText">
            <h1 class="banner-desk-shelf-system-shop__title">Design Inspires What You Do</h1>
        </div>
    </section>
    <section class="categories">
        <div class="categories__categories-block">
            <table>
                <tr>
                    <th class="categories__header">Shop</th>
                    <th class="categories__header"><a href="/shop?category=<?= $categories[0]["categoryID"]; ?>"><?= $categories[0]['categoryName'] ?></a></th>
                    <th class="categories__header"><a href="/shop?category=<?= $categories[1]["categoryID"]; ?>"><?= $categories[1]['categoryName'] ?></a></th>
                    <th class="categories__header"><a href="/shop?category=<?= $categories[2]["categoryID"]; ?>"><?= $categories[2]['categoryName'] ?></a></th>
                    <th class="categories__header"><a href="/shop?category=<?= $categories[3]["categoryID"]; ?>"><?= $categories[3]['categoryName'] ?></a></th>
                    <th class="categories__header"><a href="/shop?category=<?= $categories[4]["categoryID"]; ?>"><?= $categories[4]['categoryName'] ?></a></th>
                </tr>
                <tr>
                    <td class="categories__category-item"><a href="/shop/">Shop All</a></td>
                    <td class="categories__category-item"><a href="/shop?subcategory=Desc Pads">Desc Pads</a></td>
                    <td class="categories__category-item"><a href="/shop?subcategory=Desc Shelves">Desc Shelves</a></td>
                    <td class="categories__category-item"><a href="/shop?subcategory=Pens">Pens</a></td>
                    <td class="categories__category-item"><a href="/shop?subcategory=Apple Keyboard Tray">Apple Keyboard Tray</a></td>
                    <td class="categories__category-item"><a href="/shop?subcategory=Catch-All">Catch-All</a></td>
                </tr>
                <tr>
                    <td class="categories__category-item"></td>
                    <td class="categories__category-item"><a href="/shop?subcategory=Mouse Pads">Mouse Pads</a></td>
                    <td class="categories__category-item"><a href="/shop?subcategory=Monitor Shelves">Monitor Shelves</a></td>
                    <td class="categories__category-item"><a href="/shop?subcategory=Stationery">Stationery</a></td>
                    <td class="categories__category-item"><a href="/shop?subcategory=Apple Trackpad Tray">Apple Trackpad Tray</a></td>
                    <td class="categories__category-item"><a href="/shop?subcategory=Wall Shelves">Wall Shelves</a></td>
                </tr>
                <tr>
                    <td class="categories__category-item"></td>
                    <td class="categories__category-item"><a href="/shop?subcategory=Coasters">Coasters</a></td>
                    <td class="categories__category-item"><a href="/shop?subcategory=Laptop Stands">Laptop Stands</a></td>
                    <td class="categories__category-item"><a href="/shop?subcategory=Notebooks">Notebooks</a></td>
                    <td class="categories__category-item"><a href="/shop?subcategory=Wrist Rests">Wrist Rests</a></td>
                    <td class="categories__category-item"></td>
                </tr>
                <tr>
                    <td class="categories__category-item"></td>
                    <td class="categories__category-item"></td>
                    <td class="categories__category-item"><a href="/shop?subcategory=Headphone Stands">Headphone Stands</a></td>
                    <td class="categories__category-item"><a href="/shop?subcategory=Knives">Knives</a></td>
                    <td class="categories__category-item"></td>
                    <td class="categories__category-item"></td>
                </tr>
                <tr>
                    <td class="categories__category-item"></td>
                    <td class="categories__category-item"></td>
                    <td class="categories__category-item"><a href="/shop?subcategory=iPhone Docks">iPhone Docks</a></td>
                    <td class="categories__category-item"><a href="/shop?subcategory=Trays">Trays</a></td>
                    <td class="categories__category-item"></td>
                    <td class="categories__category-item"></td>
                </tr>
                <tr>
                    <td class="categories__category-item"></td>
                    <td class="categories__category-item"></td>
                    <td class="categories__category-item"><a href="/shop?subcategory=iPad Stands">iPad Stands</a></td>
                    <td class="categories__category-item"><a href="/shop?subcategory=Pen Cups & Planters">Pen Cups & Planters</a></td>
                    <td class="categories__category-item"></td>
                    <td class="categories__category-item"></td>
                </tr>
            </table>
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
                                <? if (is_file('files/products/' . $product['image']  . '_l.png')) : ?>
                                    <img src="/files/products/<?= $product['image'] . '_l.png'; ?>" alt="<?= $product["productShortName"]; ?>" class="shop-list__image" />
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
                <div class="shop-list__empty-error-subtitle">Look at our other products. We are sure you will find what you like.</div>
            </div>
        <? endif; ?>
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