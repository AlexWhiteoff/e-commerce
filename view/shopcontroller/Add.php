<?php

use models\ProductModel;

$Model = new ProductModel();
$categories = $Model->getCategories();
$subcategories = $Model->getSubcategories();

?>

<main id="main">
    <section class="create-product" id="add-product">
        <h2>Adding a new product</h2>

        <? if (!empty($messageClass)) : ?>
            <div class="error-alert-block alert-<?= $messageClass ?>" role="alert">
                <div class="error-alert-block__header action_clck" id='err-dropdown-btn'>
                    <div class="error-alert-block__title">
                        <span class="material-symbols-outlined">info</span>
                        <?= $warningsCount ?> errors found
                    </div>
                    <div class="error-alert-block__dropdown-btn"><i class="fas fa-chevron-right" id="error-dropdown-arrow"></i></div>
                </div>
                <div class="error-alert-block__text">
                    <?= $messageText ?>
                </div>
            </div>
        <? endif; ?>

        <form method="post" enctype="multipart/form-data" id='postForm'>
            <table class='create-product__general-information'>
                <tr>
                    <th colspan="2">General info</th>
                </tr>
                <tr>
                    <td><label for="productName-blockEditor">Product name:</label></td>
                    <td>
                        <input type="text" name="productName" id="productName-input" class="hidden">
                        <div class="productName titleEditor" id="productName-blockEditor"><?= $_POST['productName']; ?></div>
                    </td>
                </tr>
                <tr>
                    <td><label for="productMaterial">Product material:</label></td>
                    <td><input type="text" name="productMaterial" id="productMaterial" value="<?= $_POST['productMaterial']; ?>" autocomplete="off"></td>
                </tr>
                <tr>
                    <td><label for="productShortName">Product short name:</label></td>
                    <td><input type="text" name="productShortName" id="productShortName" value="<?= $_POST['productShortName']; ?>" autocomplete="off"></td>
                </tr>
                <tr>
                    <td><label for="price">Price:</label></td>
                    <td><input type="number" name="price" id="price" min="0" value="<?= $_POST['price']; ?>" autocomplete="off"></td>
                </tr>
                <tr>
                    <td><label for="quantity">Quantity:</label></td>
                    <td><input type="number" name="quantity" id="quantity" min="0" value="<?= $_POST['quantity']; ?>" autocomplete="off"></td>
                </tr>
                <tr>
                    <td><label for="image">Image:</label></td>
                    <td>
                        <div class="image">
                            <div class="image__select-file-button">
                                <input type="file" name="image" id="image" accept="image/jpeg, image/png">
                                <label for="image" class="image__button">
                                    <span class="image__upload"><i class="fas fa-upload"></i>&nbsp;Select a file</span>
                                </label>
                            </div>
                        </div>
                    </td>
                </tr>
                <tr id="previewRow">
                    <td><label for="image">Preview:</label></td>
                    <td>
                        <div class="image">
                            <div class="image__wrapper">
                            </div>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td><label for="category">Category:</label></td>
                    <td>
                        <select name="categoryID" id="category">
                            <option value="undefined" disabled selected>Select a category</option>
                            <? foreach ($categories as $key => $value) : ?>
                                <option value="<?= $value['categoryID']; ?>"><?= $value['categoryName']; ?></option>
                            <? endforeach; ?>
                        </select>
                    </td>
                </tr>
                <tr id="subcategory-row">
                    <td><label for="subcategory">Subcategory:</label></td>
                    <td><select name="subcategoryName" id="subcategory">
                            <option value="undefined" disabled selected>Select a subcategory</option>
                        </select></td>
                </tr>
            </table>
            <hr>
            <table class="create-product__description">
                <tr>
                    <th colspan="2">Description</th>
                </tr>
                <tr>
                    <td><label for="descriptionTitle">Description title:</label></td>
                    <td><input type="text" name="descriptionTitle" id="descriptionTitle" value="<?= $_POST['descriptionTitle']; ?>" autocomplete="off"></td>
                </tr>
                <tr>
                    <td><label for="descriptionText-blockEditor">Description text:</label></td>
                    <td>
                        <textarea name="descriptionText" id="descriptionText-input" class="hidden"><?= $_POST['descriptionText']; ?></textarea>
                        <div class="descriptionText descriptionEditor" id="descriptionText-blockEditor"><?= $_POST['descriptionText']; ?></div>
                    </td>
                </tr>
            </table>
            <hr>
            <table class="create-product__technical-specifications">
                <tr>
                    <th colspan="2">Technical Specifications</th>
                </tr>
                <tr>
                    <td><label for="dimensions">Dimensions:</label></td>
                    <td><textarea name="dimensions" id="dimensions"><?= $_POST['dimensions']; ?></textarea></td>
                </tr>
                <tr>
                    <td><label for="origin">Origin:</label></td>
                    <td><textarea name="origin" id="origin"><?= $_POST['origin']; ?></textarea></td>
                </tr>
                <tr>
                    <td><label for="material">Material:</label></td>
                    <td><textarea name="material" id="material"><?= $_POST['material']; ?></textarea></td>
                </tr>
                <tr class="create-product__controls">
                    <td>
                        <a href="/">Cancel</a>
                    </td>
                    <td>
                        <button type="submit" class="create-product__add">Add product</button>
                    </td>
                </tr>
            </table>
            <div class="live-preview__wrapper">
                <button type="submit" name="live_preview" class="edit-product__preview" value="true">Preview</button>
            </div>
        </form>
    </section>
</main>

<script src="/node_modules/ckeditor/build/ckeditor.js"></script>
<script>
    const editorClasses = ['titleEditor', 'descriptionEditor'];

    editorClasses.forEach(editorClass => {
        BalloonEditor
            .create(document.querySelector(`.${editorClass}`), {

                licenseKey: '',



            })
            .then(editor => {
                window.editor = editor;




            })
            .catch(error => {
                console.error('Oops, something went wrong!');
                console.error('Please, report the following error on https://github.com/ckeditor/ckeditor5/issues with the build id and the error stack trace:');
                console.warn('Build id: j1qvgmgz0u3i-jzlc2xkakovw');
                console.error(error);
            });
    });
</script>

<script>
    const subcategories = <? echo json_encode($subcategories); ?>;

    <? if (!empty($messageClass)) : ?>
        const messageText = <? echo json_encode($messageText); ?>;
    <? endif; ?>

    const form = document.querySelector("#postForm");
    form.addEventListener("submit", () => {
        const productNameData = document.querySelector("#productName-blockEditor").innerHTML;
        const descriptionData = document.querySelector('#descriptionText-blockEditor').innerHTML;
        const productNameInput = document.querySelector("#productName-input");
        const descriptionInput = document.querySelector("#descriptionText-input");
        productNameInput.value = productNameData;
        descriptionInput.value = descriptionData;
    });
</script>