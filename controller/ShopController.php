<?php

namespace controller;

use core\Controller;
use models\AccountModel;
use models\ProductModel;

/**
 * Controller for Shop module
 * @package controller
 */
class ShopController extends Controller
{
    protected $user;
    protected $userModel;
    protected $productModel;
    public function __construct()
    {
        $this->userModel = new AccountModel();
        $this->productModel = new ProductModel();
        $this->user = $this->userModel->getCurrentUser();
    }

    /**
     * Adding products image
     */
    private function addImage($product_id, $file, $save_file = true)
    {
        $allowed_types = ['image/png', 'image/jpeg'];
        if (is_file($file['tmp_name']) && in_array($file['type'], $allowed_types)) {

            switch ($file['type']) {
                case 'image/png':
                    $extension = 'png';
                    break;

                default:
                    $extension = 'jpg';
                    break;
            }

            $image_name = $product_id . '_' . uniqid() . '.' . $extension;

            if ($save_file === true) {
                move_uploaded_file($file['tmp_name'], 'files/products/' . $image_name);
                $this->productModel->changeMainImage($product_id, $image_name);
                return true;
            } else {
                move_uploaded_file($file['tmp_name'], 'files/tmp/' . $image_name);
                $path = $this->productModel->createTmpImage($product_id, $image_name);
                return $path;
            }
        } else
            return false;
    }

    /**
     * Display the module index page
     */
    public function actionIndex()
    {

        if (isset($_GET['subcategory'])) {
            $subcategory = $_GET['subcategory'];

            $products = $this->productModel->getProducts("`subcategoryName` = \"$subcategory\"");
            if (count($products) === 1) {
                header('Location: /shop/product?id=' . $products[0]["productID"]);
            }
        } else if (isset($_GET['category'])) {
            $category = $_GET['category'];

            $products = $this->productModel->getProducts("`categoryID` = \"$category\"");
            if (count($products) === 1) {
                header('Location: /shop/product?id=' . $products[0]["productID"]);
            }
        } else
            $products = $this->productModel->getProducts(null, ['categoryID' => 'ASC']);

        return $this->render('index', ['products' => $products], ['namePage' => 'Shop Grovemade&reg;']);
    }

    /**
     * Display the product page
     */
    public function actionProduct()
    {
        $id = $_GET['id'];
        $product = $this->productModel->getProductById($id);
        $title = $product['productShortName'] . ' | Grovemade&reg;';

        if (isset($_GET['action']) && $_GET['action'] == 'add') {

            if (!$this->userModel->isUserAuthenticated())
                header('Location: /account/login');

            $cartProduct = $this->productModel->getCartProductById($id);

            if (!empty($cartProduct))
                $result = $this->productModel->UpdateCartProduct($id, $cartProduct['quantity'] + 1);
            else
                $result = $this->productModel->AddToCart($id);

            if ($result === true)
                header('Location: /shop/product?id=' . $id);
            else {
                $message = 'Oops... Something went wrong...';
                $params = [
                    'messageText' => $message,
                    'messageClass' => 'error',
                    'model' => $product
                ];
                return $this->render('product', $params, ['namePage' => $title]);
            }
        } else if (isset($_GET['action']) && $_GET['action'] == 'remove') {

            $cartProduct = $this->productModel->getCartProductById($id);

            if (!empty($cartProduct)) {
                $result = $this->productModel->RemoveFromCart($id);
                header('Location: ' . $_SERVER['HTTP_REFERER']);
            } else
                header('Location: ' . $_SERVER['HTTP_REFERER']);
        } else if (isset($_GET['action']) && $_GET['action'] == 'update') {

            $cartProduct = $this->productModel->getCartProductById($id);

            if (!empty($cartProduct)) {
                $result = $this->productModel->UpdateCartProduct($id, $_POST['quantity']);
                header('Location: ' . $_SERVER['HTTP_REFERER']);
            } else
                header('Location: ' . $_SERVER['HTTP_REFERER']);
        } else {
            if ($product == null)
                header('Location: ' . '/shop');

            return $this->render('product', ['model' => $product], ['namePage' => $title]);
        }
    }

    /**
     * Display adding new products page
     */
    public function actionAdd()
    {
        if (empty($this->user)) {
            $forbidden = '403 Forbidden';
            return $this->render('forbidden', null, ['namePage' => $forbidden]);
        }
        if ($this->isMethodPost()) {
            if (isset($_POST['live_preview']) && $_POST['live_preview'] === 'true') {
                $path = $this->addImage(0, $_FILES['image'], false);

                if (is_string($path))
                    $product['imgPath'] = $path;

                $_POST['productName'] = str_replace(['<br>', '<br data-cke-filler="true">', '<p>', '</p>', '&nbsp;'], '', $_POST['productName']);
                $_POST['dimensions'] = str_replace(PHP_EOL, '<br>', $_POST['dimensions']);
                $_POST['origin'] = str_replace(PHP_EOL, '<br>', $_POST['origin']);
                $_POST['material'] = str_replace(PHP_EOL, '<br>', $_POST['material']);

                $params = [
                    'model' => $_POST,
                    'productModel' => $product,
                ];
                return $this->render('preview', $params, ['namePage' => "Live Preview | Grovemade&reg;"]);
            } else {
                $result = $this->productModel->AddProduct($_POST);

                if ($result['error'] === false) {

                    $this->addImage($result['id'], $_FILES['image']);

                    header("Location: /shop/product?id={$result['id']}");
                } else if ($result['error'] === true && $result['message'] === 'Authorisation Error') {
                    $forbidden = '403 Forbidden';
                    return $this->render('forbidden', null, ['namePage' => $forbidden]);
                } else {
                    $message = implode("<br>", $result['message']);
                    $params = [
                        'messageText' => $message,
                        'warningsCount' => count($result['message']),
                        'messageClass' => 'error'
                    ];
                    return $this->render('add', $params, ['namePage' => 'Add Product — Grovemade&reg;']);
                }
            }
        } else
            return $this->render('add', null, ['namePage' => 'Add Product — Grovemade&reg;']);
    }

    /**
     * Display editing products page
     */
    public function actionEdit()
    {
        $id = $_GET['id'];
        $product = $this->productModel->getProductById($id);
        $title = "Editing - {$product['productShortName']} | Grovemade&reg;";
        if (empty($this->user) && $this->userModel->getUserAccessLevel() != '3' && $product['sellerID'] != $this->userModel->getCurrentUser()['UserID']) {
            $forbidden = '403 Forbidden';
            return $this->render('forbidden', null, ['namePage' => $forbidden]);
        } else if ($this->isMethodPost()) {
            if (isset($_POST['live_preview']) && $_POST['live_preview'] === 'true') {
                $path = $this->addImage($id, $_FILES['image'], false);

                if (is_string($path))
                    $product['imgPath'] = $path;

                $_POST['productName'] = str_replace(['<br>', '<br data-cke-filler="true">', '<p>', '</p>', '&nbsp;'], '', $_POST['productName']);
                $_POST['descriptionText'] = str_replace(PHP_EOL, '<br>', $_POST['descriptionText']);
                $_POST['dimensions'] = str_replace(PHP_EOL, '<br>', $_POST['dimensions']);
                $_POST['origin'] = str_replace(PHP_EOL, '<br>', $_POST['origin']);
                $_POST['material'] = str_replace(PHP_EOL, '<br>', $_POST['material']);

                $params = [
                    'model' => $_POST,
                    'productModel' => $product,
                ];
                return $this->render('preview', $params, ['namePage' => "Live Preview | Grovemade&reg;"]);
            } else {
                $result = $this->productModel->UpdateProduct($_POST, $id);
                if ($result === true) {

                    $this->addImage($id, $_FILES['image']);

                    header("Location: /shop/product?id={$id}");
                } else {
                    $message = implode("<br>", $result);
                    $params = [
                        'messageText' => $message,
                        'warningsCount' => count($result),
                        'messageClass' => 'error',
                        'model' => $product
                    ];
                    return $this->render('edit', $params, ['namePage' => $title]);
                }
            }
        } else
            return $this->render('edit', ['model' => $product], ['namePage' => $title]);
    }

    /**
     * Removing the product
     */
    public function actionDelete()
    {
        $id = $_GET['id'];
        $product = $this->productModel->getProductById($id);

        if (empty($this->user) && $this->userModel->getUserAccessLevel() != '3' && $product['sellerID'] != $this->userModel->getCurrentUser()['UserID']) {
            $forbidden = '403 Forbidden';
            return $this->render('forbidden', null, ['namePage' => $forbidden]);
        }

        if (isset($_GET['confirm']) && $_GET['confirm'] == 'true') {
            $this->productModel->DeleteProduct($id);
        }
        
        header('Location: ' . $_SERVER['HTTP_REFERER']);
    }
}