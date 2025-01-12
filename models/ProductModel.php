<?php

namespace models;

use core\Configuration;
use core\Model;
use core\Core;
use core\Logger;
use core\Utils;
use Imagick;

class ProductModel extends Model
{
    public function createTmpImage($file)
    {
        $folderPath = Configuration::get('paths', 'Paths')['TempDir'];
        $file_path = pathinfo($folderPath . $file);

        $relativePath = substr($folderPath, strlen($_SERVER['DOCUMENT_ROOT']));

        $fileName_preview = $file_path['filename'] . '_preview';

        $im = new Imagick();

        $im->readImage($folderPath . $file);
        $im->setimageformat('png');
        $im->thumbnailImage(795, 795, true, true);
        // $im->transparentPaintImage('rgb(255,255,255)', 0.0, Imagick::getQuantum() * 0.05, false);
        $im->despeckleimage();
        $im->writeImage($folderPath . $fileName_preview . '.png');

        unlink($folderPath . $file);

        Logger::log("Created preview file: " . $relativePath . $fileName_preview . '.png');

        return $relativePath . $fileName_preview . '.png';
    }

    public function changeMainImage($product_id, $file)
    {
        $folder = Configuration::get('paths', 'Paths')['ProductImagesDir'];
        $file_path = pathinfo($folder . $file);

        $file_xl = $file_path['filename'] . '_xl'; // 795x795 (product) xl
        $file_l = $file_path['filename'] . '_l'; // 370xAuto (shop) l
        $file_m = $file_path['filename'] . '_m'; // 200x150 (cart) m
        $file_s = $file_path['filename'] . '_s'; // 65x65 (checkout) s

        $product = $this->getProductById($product_id);

        if (is_file($folder . $product['image'] . '_xl.png') && is_file($folder . $file))
            unlink($folder . $product['image'] . '_xl.png');
        if (is_file($folder . $product['image'] . '_l.png') && is_file($folder . $file))
            unlink($folder . $product['image'] . '_l.png');
        if (is_file($folder . $product['image'] . '_m.png') && is_file($folder . $file))
            unlink($folder . $product['image'] . '_m.png');
        if (is_file($folder . $product['image'] . '_s.png') && is_file($folder . $file))
            unlink($folder . $product['image'] . '_s.png');

        $product['image'] = $file_path['filename'];

        $im_xl = new Imagick();

        $im_xl->readImage($folder . $file);
        $im_xl->setimageformat('png');
        $im_xl->thumbnailImage(795, 795, true, true);
        // $im_xl->transparentPaintImage('rgb(255,255,255)', 0.0, Imagick::getQuantum() * 0.05, false);
        $im_xl->despeckleimage();
        $im_xl->writeImage($folder . $file_xl . '.png');

        $im_l = new Imagick();

        $im_l->readImage($folder . $file);
        $im_l->setimageformat('png');
        $im_l->thumbnailImage(420, 420, true, true);
        // $im_l->transparentPaintImage('rgb(255,255,255)', 0.0, Imagick::getQuantum() * 0.05, false);
        $im_l->despeckleimage();
        $im_l->writeImage($folder . $file_l . '.png');

        $im_m = new Imagick();

        $im_m->readImage($folder . $file);
        $im_m->setimageformat('png');
        $im_m->thumbnailImage(200, 200, true, true);
        // $im_m->transparentPaintImage('rgb(255,255,255)', 0.0, Imagick::getQuantum() * 0.05, false);
        $im_m->despeckleimage();
        $im_m->writeImage($folder . $file_m . '.png');

        $im_s = new Imagick();

        $im_s->readImage($folder . $file);
        $im_s->setimageformat('png');
        $im_s->thumbnailImage(65, 65, true, true);
        // $im_s->transparentPaintImage('rgb(255,255,255)', 0.0, Imagick::getQuantum() * 0.05, false);
        $im_s->despeckleimage();
        $im_s->writeImage($folder . $file_s . '.png');

        unlink($folder . $file);

        Logger::log("Created product image for pruduct $product_id");

        $this->UpdateProduct($product, $product_id);
    }

    public function ValidateOrder(array $order, array $validationArray)
    {
        $errors = [];
        $statusLevelFilter = [
            'Placed',
            'Processed',
            'Packing',
            'Shipping',
            'Awaiting',
            'Complete',
            'Canceled'
        ];
        $shippingMethodFilter = ['Small parcel', 'UPS International'];

        foreach ($validationArray as $name => $field) {
            if (empty($order[$name]))
                $errors[] = "<i class=\"fas fa-times\"></i>&nbsp;&nbsp;<b>$field</b> field cannot be empty";
        }

        $regex = "/[a-z]/i";
        if (preg_match($regex, $order['quantity']))
            $errors[] = '<i class="fas fa-times"></i>&nbsp;&nbsp;<b>Quantity</b> field value must be a number';
        if ($order['quantity'] < 0)
            $errors[] = '<i class="fas fa-times"></i>&nbsp;&nbsp;<b>Quantity</b> field value must be a greater than or equal to null';

        if (!in_array($order['status'], $statusLevelFilter))
            $errors[] = '<i class="fas fa-times"></i>&nbsp;&nbsp;<b>Status</b> undefined status';

        if (!in_array($order['shippingMethod'], $shippingMethodFilter))
            $errors[] = '<i class="fas fa-times"></i>&nbsp;&nbsp;<b>Shipping Method</b> undefined method';

        if (count($errors) > 0)
            return $errors;
        else
            return true;
    }

    public function ValidateProduct(array $product)
    {
        $errors = [];
        if (empty($product['productName']))
            $errors[] = '<i class="fas fa-times"></i>&nbsp;&nbsp;<b>Product Name</b> field cannot be empty';
        if (empty($product['productShortName']))
            $errors[] = '<i class="fas fa-times"></i>&nbsp;&nbsp;<b>Product Short Name</b> field cannot be empty';

        if (empty($product['descriptionTitle']))
            $errors[] = '<i class="fas fa-times"></i>&nbsp;&nbsp;<b>Description Title</b> field cannot be empty';
        if (empty($product['descriptionText']))
            $errors[] = '<i class="fas fa-times"></i>&nbsp;&nbsp;<b>Description Text</b> field cannot be empty';

        if (empty($product['price']))
            $errors[] = '<i class="fas fa-times"></i>&nbsp;&nbsp;<b>Price</b> field cannot be empty';

        if (empty($product['dimensions']))
            $errors[] = '<i class="fas fa-times"></i>&nbsp;&nbsp;<b>Dimensions</b> field cannot be empty';
        if (empty($product['origin']))
            $errors[] = '<i class="fas fa-times"></i>&nbsp;&nbsp;<b>Origin</b> field cannot be empty';
        if (empty($product['material']))
            $errors[] = '<i class="fas fa-times"></i>&nbsp;&nbsp;<b>Material</b> field cannot be empty';

        if ($product['categoryID'] === null)
            $errors[] = '<i class="fas fa-times"></i>&nbsp;&nbsp;<b>Category</b> field cannot be empty';
        if ($product['subcategoryName'] === null)
            $errors[] = '<i class="fas fa-times"></i>&nbsp;&nbsp;<b>Subcategory</b> field cannot be empty';

        $regex = "/[a-z]/i";
        if (preg_match($regex, $product['price']))
            $errors[] = '<i class="fas fa-times"></i>&nbsp;&nbsp;<b>Price</b> field value must be a number';
        if ($product['price'] < 0)
            $errors[] = '<i class="fas fa-times"></i>&nbsp;&nbsp;<b>Price</b> field value must be a greater than or equal to null';

        if (preg_match($regex, $product['quantity']))
            $errors[] = '<i class="fas fa-times"></i>&nbsp;&nbsp;<b>Count</b> field value must be a number';
        if ($product['quantity'] < 0)
            $errors[] = '<i class="fas fa-times"></i>&nbsp;&nbsp;<b>Count</b> field value must be a greater than or equal to null';

        if (count($errors) > 0)
            return $errors;
        else
            return true;
    }

    public function AddProduct($product)
    {
        $userModel = new AccountModel;
        $user = $userModel->getCurrentUser();

        if ($user == null) {
            return [
                'error' => true,
                'message' => 'Authorisation Error'
            ];
        }

        $validateResult = $this->ValidateProduct($product);
        if (is_array($validateResult)) {
            return [
                'error' => true,
                'message' => $validateResult,
            ];
        }
        $fields = ['productName', 'productMaterial', 'productShortName', 'descriptionTitle', 'descriptionText', 'price', 'quantity', 'categoryID', 'subcategoryName', 'dimensions', 'origin', 'material'];
        $product = Utils::ArrayFilter($product, $fields);

        $product['productName'] = str_replace(['<br>', '<br data-cke-filler="true">', '<p>', '</p>', '&nbsp;'], '', $_POST['productName']);
        $product['dimensions'] = str_replace(PHP_EOL, '<br>', $product['dimensions']);
        $product['origin'] = str_replace(PHP_EOL, '<br>', $product['origin']);
        $product['material'] = str_replace(PHP_EOL, '<br>', $product['material']);
        $product['price'] = floatval($product['price']);
        $product['quantity'] = intval($product['quantity']);
        $product['added'] = date('Y-m-d H:i:s');
        $product['categoryID'] = intval($product['categoryID']);
        $product['sellerID'] = intval($user['UserID']);
        $product['image'] = '';

        $id = Core::getInstance()->getDataBase()->insert('product', $product);

        return [
            'error' => false,
            'id' => $id
        ];
    }

    public function UpdateProduct($product, $id)
    {
        $userModel = new AccountModel;
        $user = $userModel->getCurrentUser();
        if ($user == null)
            return false;

        $fields = ['productName', 'productMaterial', 'productShortName', 'descriptionTitle', 'descriptionText', 'price', 'quantity', 'categoryID', 'subcategoryName', 'image', 'dimensions', 'origin', 'material'];
        $product = Utils::ArrayFilter($product, $fields);

        $validateResult = $this->ValidateProduct($product);
        if (is_array($validateResult))
            return $validateResult;

        $product['productName'] = str_replace(['<br>', '<br data-cke-filler="true">', '<p>', '</p>', '&nbsp;'], '', $_POST['productName']);
        $product['dimensions'] = str_replace(PHP_EOL, '<br>', $product['dimensions']);
        $product['origin'] = str_replace(PHP_EOL, '<br>', $product['origin']);
        $product['material'] = str_replace(PHP_EOL, '<br>', $product['material']);
        $product['price'] = floatval($product['price']);
        $product['quantity'] = intval($product['quantity']);
        $product['categoryID'] = intval($product['categoryID']);

        Core::getInstance()->getDataBase()->update('product', $product, ['productID' => $id]);
        return true;
    }

    public function ReduceProductCount()
    {
        $userModel = new AccountModel;
        $user = $userModel->getCurrentUser();
        $cart = $this->getCartProductsByUserId($user['UserID']);

        foreach ($cart as $cartProduct) {
            $product = $this->getProductById($cartProduct['productID']);
            $oldQuantity = $product['quantity'];
            $newQuantity = $oldQuantity - $cartProduct['quantity'];

            if ($newQuantity < 0)
                return false;
        }

        foreach ($cart as $cartProduct) {
            $product = $this->getProductById($cartProduct['productID']);
            $oldQuantity = $product['quantity'];
            $newQuantity = $oldQuantity - $cartProduct['quantity'];
            $oldSales = $product['sales'];
            $newSales = $oldSales + $cartProduct['quantity'];

            Core::getInstance()->getDataBase()->update('product', ['quantity' => $newQuantity, 'sales' => $newSales], ['productID' => $cartProduct['productID']]);
        }
        return true;
    }

    public function DeleteProduct($id)
    {
        $product = $this->getProductById($id);

        $userModel = new AccountModel;
        $user = $userModel->getCurrentUser();

        if (empty($product) || empty($user) || ($user['UserID'] != $product['sellerID'] && $user['access'] == '1'))
            return false;

        $img_size = ['_s', '_m', '_l', '_xl'];
        $imgname = $product['image'];
        $folder = Configuration::get('paths', 'Paths')['ProductImagesDir'];

        for ($i = 0; $i < count($img_size); $i++)
            if (is_file($folder . $imgname . $img_size[$i] . '.png'))
                unlink($folder . $imgname . $img_size[$i] . '.png');

        Core::getInstance()->getDataBase()->delete('cart', ['productID' => $id]);
        Core::getInstance()->getDataBase()->delete('product', ['productID' => $id]);
        return true;
    }

    public function getProducts($where = null, $orderBy = null, $limit = null)
    {
        return Core::getInstance()->getDataBase()->select('product', '*', $where, $orderBy, $limit);
    }

    public function getProductById($id)
    {
        $products = Core::getInstance()->getDataBase()->select('product', '*', ['productID' => $id]);
        if (!empty($products)) {
            return $products[0];
        } else {
            return null;
        }
    }

    public function getCategories()
    {
        return Core::getInstance()->getDataBase()->select('category', '*', null, 'categoryID');
    }

    public function getSubcategories()
    {
        return Core::getInstance()->getDataBase()->select('subcategory', '*', null, 'categoryID');
    }

    public function AddToCart($productID)
    {
        $userModel = new AccountModel;
        $user = $userModel->getCurrentUser();
        if ($user == null)
            return false;

        $productToCart['productID'] = intval($productID);
        $productToCart['userID'] = intval($user['UserID']);

        Core::getInstance()->getDataBase()->insert('cart', $productToCart);
        return true;
    }

    public function RemoveFromCart($productID)
    {
        $userModel = new AccountModel;
        $user = $userModel->getCurrentUser();

        $product = $this->getCartProductById($productID);

        if (empty($product) || empty($user))
            return false;

        Core::getInstance()->getDataBase()->delete('cart', ['id' => $product['id']]);
        return true;
    }

    public function UpdateCartProduct($productID, $quantity)
    {
        $userModel = new AccountModel;
        $user = $userModel->getCurrentUser();

        $product = $this->getCartProductById($productID);

        if (empty($product) || empty($user))
            return false;

        if ($quantity <= 0)
            $quantity = 1;

        $fields = ['id', 'quantity'];
        $product = Utils::ArrayFilter($product, $fields);

        $product['quantity'] = $quantity;

        Core::getInstance()->getDataBase()->update('cart', $product, ['id' => $product['id']]);
        return true;
    }

    public function getCartProductById($productID)
    {
        $userModel = new AccountModel;
        $user = $userModel->getCurrentUser();

        $products = Core::getInstance()->getDataBase()->select('cart', '*', ['productID' => $productID, 'userID' => $user['UserID']]);

        if (!empty($products)) {
            return $products[0];
        } else {
            return null;
        }
    }

    public function getCartProductsByUserId($userID)
    {
        $userModel = new AccountModel;
        $user = $userModel->getCurrentUser();
        if ($user == null)
            return null;

        $products = Core::getInstance()->getDataBase()->select('cart', '*', ['userID' => $user['UserID']]);

        if (!empty($products)) {
            return $products;
        } else {
            return null;
        }
    }

    public function getOrderList($where = null, $orderBy = null)
    {
        $rows = Core::getInstance()->getDataBase()->select('`orders`', '*', $where, $orderBy);
        if (count($rows) > 0)
            return $rows;
        else
            return null;
    }

    public function getOrderById($id)
    {
        $rows = Core::getInstance()->getDataBase()->select('`orders`', '*', ['orderID' => $id]);
        if (count($rows) > 0)
            return $rows[0];
        else
            return null;
    }

    public function UpdateOrder($order, $id)
    {
        $userModel = new AccountModel;
        $user = $userModel->getCurrentUser();

        if ($user == null)
            return false;

        $oldOrder = $this->getOrderById($id);

        $order['datetime'] = date("Y-m-d H:i:s", strtotime($order['date'] . " " . $order['time']));

        $validationArray = [
            'email' => 'Email',
            'country' => 'Country',
            'firstname' => 'First Name',
            'lastname' => 'Last Name',
            'address' => 'Address',
            'city' => 'City',
            'postalCode' => 'Postal Code',
            'phone' => 'Phone',
            'price' => 'Price'
        ];

        $validateResult = $this->ValidateOrder($order, $validationArray);
        if (is_array($validateResult))
            return $validateResult;

        $fields = [];
        $fieldPattern = ['email', 'country', 'firstname', 'lastname', 'company', 'address', 'apartment', 'city', 'postalCode', 'phone', 'shippingMethod', 'quantity', 'price', 'datetime', 'status'];
        foreach ($fieldPattern as $row) {
            if (!empty($order[$row]) && $order[$row] != $oldOrder[$row])
                array_push($fields, $row);
        }

        $order = Utils::ArrayFilter($order, $fields);

        if (!empty($order)) {
            Core::getInstance()->getDataBase()->update('orders', $order, ['orderID' => $id]);
        }
        return true;
    }

    public function DeleteOrder($id)
    {
        $userModel = new AccountModel;
        $user = $userModel->getCurrentUser();

        if (empty($user) || $user['access'] !== '3')
            return false;

        Core::getInstance()->getDataBase()->delete('orders', "orderID = $id");
        return true;
    }

    public function UpdateUser($userInfo, $id)
    {
        $userModel = new AccountModel;
        $currentUser = $userModel->getCurrentUser();
        if ($currentUser == null || $currentUser['access'] != '3')
            return false;

        $user = $userModel->getUserById($id);

        $validateResult = $userModel->UpdateUserValidation($userInfo);
        if (is_array($validateResult))
            return $validateResult;

        $fields = [];
        $fieldPattern = ['firstname', 'lastname', 'gender', 'birthdayDate', 'telephone', 'email', 'address', 'access'];
        foreach ($fieldPattern as $row) {
            if (!empty($userInfo[$row]) && $userInfo[$row] != $user[$row])
                array_push($fields, $row);
        }

        $userInfo = Utils::ArrayFilter($userInfo, $fields);
        if (!empty($user))
            Core::getInstance()->getDataBase()->update('user', $userInfo, ['UserID' => $id]);
        return true;
    }
}
