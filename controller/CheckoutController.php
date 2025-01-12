<?php

namespace controller;

use core\Controller;
use Locale;
use models\AccountModel;
use models\CheckoutModel;
use models\ProductModel;

/**
 * Контролер для модуля Checkout
 * @package controller
 */
class CheckoutController extends Controller
{
    protected $userModel;
    protected $productModel;
    protected $checkoutModel;

    function __construct()
    {
        $this->userModel = new AccountModel;
        $this->checkoutModel = new CheckoutModel;
        $this->productModel = new ProductModel;
    }

    /**
     * Checkout Page
     */
    public function actionIndex()
    {
        $user = $this->userModel->getCurrentUser();
        $cart = $this->productModel->getCartProductsByUserId($user['UserID']);

        if (empty($user) || empty($cart)) {
            header('Location: /');
        } else {
            if (isset($_GET['discount'])) {
                $_SESSION['__cart']['discount'] = $this->checkoutModel->discountCheck($_GET['discount']);

                $params = [
                    'moduleUser' => $user,
                    'moduleCart' => $cart,
                    'discount' => $_SESSION['__cart']['discount']
                ];
                return $this->render('index', $params, ['namePage' => 'Woodmade&reg; — Checkout']);
            } else if ($_GET['step'] === 'shipping_method') {
                if ($this->isMethodPost()) {
                    $result = $this->checkoutModel->ValidateInformation($_POST);
                    if (is_array($result)) {
                        $message = implode("<br>", $result);
                        $params = [
                            'moduleUser' => $user,
                            'moduleCart' => $cart,
                            'messageText' => $message,
                            'warningsCount' => count($result),
                            'messageClass' => 'error'
                        ];
                        return $this->render('index', $params, ['namePage' => 'Woodmade&reg; — Checkout']);
                    }
                    $_SESSION['userInfo'] = $_POST;
                }
                if (isset($_SESSION['userInfo']))
                    return $this->actionShipping();
                else
                    header('Location: /checkout/');
            } else if ($_GET['step'] === 'payment_method') {
                if ($this->isMethodPost()) {
                    $_SESSION['userInfo']['shippingMethod'] = $_POST['shippingMethod'];

                    if ($_POST['shippingMethod'] === "UPS International")
                        $_SESSION['__cart']['shippingPrice'] = 35.00;
                    else if ($_POST['shippingMethod'] === "Small parcel")
                        $_SESSION['__cart']['shippingPrice'] = 20.00;
                }

                if (isset($_SESSION['userInfo']['shippingMethod']))
                    return $this->actionPayment();
                else
                    header('Location: /checkout/');
            } else if ($_GET['successfully'] === 'true') {
                if ($this->isMethodPost()) {
                    $result = $this->checkoutModel->PaymentCheck($_POST);

                    if ($result === true) {
                        $reduseResult = $this->productModel->ReduceProductCount();
                        if ($reduseResult === true) {
                            $this->checkoutModel->AddOrder();

                            foreach ($cart as $cartProduct) {
                                $removeResult = $this->productModel->RemoveFromCart($cartProduct['productID']);
                            }

                            unset($_SESSION['userInfo']);
                            unset($_SESSION['__cart']);
                            return $this->render('success', null, ['namePage' => 'Woodmade&reg; — Checkout']);
                        } else {
                            unset($_SESSION['userInfo']);
                            unset($_SESSION['__cart']);
                            $params = [
                                'messageText' => 'Oops, Something went wrong',
                                'warningsCount' => 1,
                                'messageClass' => 'error',
                                'moduleUser' => $user,
                                'moduleCart' => $cart
                            ];
                            return $this->render('index', $params, ['namePage' => 'Woodmade&reg; — Checkout']);
                        }
                        return $this->render('success', null, ['namePage' => 'Error']);
                    } else {
                        $message = implode("<br>", $result);
                        $params = [
                            'messageText' => $message,
                            'warningsCount' => count($result),
                            'messageClass' => 'error'
                        ];
                    }
                } else
                    header('Location: /checkout/');
            } else {
                unset($_SESSION['userInfo']);
                unset($_SESSION['__cart']);
                $params = [
                    'moduleUser' => $user,
                    'moduleCart' => $cart
                ];
                return $this->render('index', $params, ['namePage' => 'Woodmade&reg; — Checkout']);
            }
        }
    }

    public function actionShipping()
    {
        $user = $this->userModel->getCurrentUser();
        $cart = $this->productModel->getCartProductsByUserId($user['UserID']);

        $params = [
            'moduleUser' => $_SESSION['userInfo'],
            'moduleCart' => $cart,
            'discount' => $_SESSION['__cart']['discount']
        ];
        return $this->render('shipping', $params, ['namePage' => 'Woodmade&reg; — Checkout']);
    }

    public function actionPayment()
    {
        $user = $this->userModel->getCurrentUser();
        $cart = $this->productModel->getCartProductsByUserId($user['UserID']);

        $params = [
            'moduleUser' => $_SESSION['userInfo'],
            'moduleCart' => $cart,
            'discount' => $_SESSION['__cart']['discount'],
            'shipping' => $_SESSION['__cart']['shippingPrice']
        ];
        return $this->render('payment', $params, ['namePage' => 'Woodmade&reg; — Checkout']);
    }
}
