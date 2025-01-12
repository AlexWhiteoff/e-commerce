<?php

namespace models;

use core\Configuration;
use core\Model;
use core\Core;
use core\Utils;

class CheckoutModel extends Model
{
    public function ValidateInformation($order)
    {
        $errors = [];
        if (empty($order['email']))
            $errors[] = '<i class="fas fa-times"></i>&nbsp;&nbsp;<b>Email</b> field cannot be empty';
        if (empty($order['country']))
            $errors[] = '<i class="fas fa-times"></i>&nbsp;&nbsp;<b>Country</b> field cannot be empty';

        if (empty($order['firstname']))
            $errors[] = '<i class="fas fa-times"></i>&nbsp;&nbsp;<b>Firstname</b> field cannot be empty';
        if (empty($order['lastname']))
            $errors[] = '<i class="fas fa-times"></i>&nbsp;&nbsp;<b>Lastname</b> field cannot be empty';
        if (empty($order['address']))
            $errors[] = '<i class="fas fa-times"></i>&nbsp;&nbsp;<b>Address</b> field cannot be empty';
        if (empty($order['city']))
            $errors[] = '<i class="fas fa-times"></i>&nbsp;&nbsp;<b>City</b> field cannot be empty';
        if (empty($order['postalCode']))
            $errors[] = '<i class="fas fa-times"></i>&nbsp;&nbsp;<b>Postal Code</b> field cannot be empty';

        if (empty($order['phone']))
            $errors[] = '<i class="fas fa-times"></i>&nbsp;&nbsp;<b>Telephone</b> field cannot be empty';

        if (count($errors) > 0)
            return $errors;
        else
            return true;
    }
    public function ValidatePaymentInformation($payment)
    {
        $errors = [];

        if (empty($payment['card-number']))
            $errors[] = '<i class="fas fa-times"></i>&nbsp;&nbsp;<b>Card number</b> field cannot be empty';
        else {
            $visaRegEx = '/^4\\d{13,15}/';
            $mastercardRegEx = '/^5[1-5]\\d{15}/';
            $amexRegEx = '/^3[47]\\d{13}/';
            $discover = '/^(?:6011|65\\d{0,2}|64[4-9]\\d?)\\d*/';

            if (preg_match($visaRegEx, $payment['card-number'])) {
            } else if (preg_match($mastercardRegEx, $payment['card-number'])) {
            } else if (preg_match($amexRegEx, $payment['card-number'])) {
            } else if (preg_match($discover, $payment['card-number'])) {
            } else
                $errors[] = '<i class="fas fa-times"></i>&nbsp;&nbsp;<b>Card number</b> invalid card number';
        }
        if (empty($payment['card-name']))
            $errors[] = '<i class="fas fa-times"></i>&nbsp;&nbsp;<b>Name on card</b> field cannot be empty';
        if (empty($payment['card-expiry']))
            $errors[] = '<i class="fas fa-times"></i>&nbsp;&nbsp;<b>Expiration date</b> field cannot be empty';
        if (empty($payment['card-security-code']))
            $errors[] = '<i class="fas fa-times"></i>&nbsp;&nbsp;<b>Security code</b> field cannot be empty';

        if (empty($payment['billing-address']))
            $errors[] = '<i class="fas fa-times"></i>&nbsp;&nbsp;<b>Billing address</b> select billing address';
        else if ($payment['billing-address'] === 'different') {
            if (empty($payment['country']))
                $errors[] = '<i class="fas fa-times"></i>&nbsp;&nbsp;<b>Country</b> field cannot be empty';
            if (empty($payment['firstname']))
                $errors[] = '<i class="fas fa-times"></i>&nbsp;&nbsp;<b>Firstname</b> field cannot be empty';
            if (empty($payment['lastname']))
                $errors[] = '<i class="fas fa-times"></i>&nbsp;&nbsp;<b>Lastname</b> field cannot be empty';
            if (empty($payment['address']))
                $errors[] = '<i class="fas fa-times"></i>&nbsp;&nbsp;<b>Address</b> field cannot be empty';
            if (empty($payment['city']))
                $errors[] = '<i class="fas fa-times"></i>&nbsp;&nbsp;<b>City</b> field cannot be empty';
            if (empty($payment['postalCode']))
                $errors[] = '<i class="fas fa-times"></i>&nbsp;&nbsp;<b>Postal Code</b> field cannot be empty';
            if (empty($payment['phone']))
                $errors[] = '<i class="fas fa-times"></i>&nbsp;&nbsp;<b>Telephone</b> field cannot be empty';
        }

        if (count($errors) > 0)
            return $errors;
        else
            return true;
    }

    public function AddOrder()
    {
        $order = $_SESSION['userInfo'];

        $userModel = new AccountModel;
        $productModel = new ProductModel;
        $user = $userModel->getCurrentUser();
        $cart = $productModel->getCartProductsByUserId($user['UserID']);

        if ($user == null)
            return false;

        $fields = ['email', 'country', 'firstname', 'lastname', 'company', 'address', 'apartment', 'city', 'postalCode', 'phone', 'shippingMethod'];
        $order = Utils::ArrayFilter($order, $fields);

        $order['userID'] = intval($user['UserID']);

        foreach ($cart as $cartProduct) {
            $order['quantity'] = intval($cartProduct['quantity']);
            $order['productID'] = intval($cartProduct['productID']);
            $order['datetime'] = date('Y-m-d H:i:s');

            $order['price'] = floatval($_SESSION['__cart']['product' . $cartProduct['productID']]);
            Core::getInstance()->getDataBase()->insert('orders', $order);
        }
        return true;
    }

    public function PaymentCheck($paymentInfo)
    {
        $userModel = new AccountModel;
        $user = $userModel->getCurrentUser();

        if ($user == null)
            return false;

        $paymentInfo['card-number'] = str_replace(' ', '', $paymentInfo['card-number']);

        $result = $this->ValidatePaymentInformation($paymentInfo);
        if (is_array($result))
            return $result;

        return true;
    }

    public function discountCheck($discount)
    {
        $discounts = Configuration::get("promocodes", 'DiscountCode');
        $discountValue = $discounts[$discount];

        if (empty($discountValue))
            return 0;
        else
            return $discountValue;
    }
}
