<?php

namespace controller;

use core\Controller;
use Locale;
use models\AccountModel;
use models\ProductModel;

/**
 * Контролер для модуля Account
 * @package controller
 */
class AccountController extends Controller
{
    protected $usersModel;
    protected $productModel;
    function __construct()
    {
        $this->usersModel = new AccountModel;
        $this->productModel = new ProductModel;
    }
    /**
     * Відображення персональної сторінки користувача
     */
    public function actionIndex()
    {
        if (!empty($this->usersModel->getCurrentUser())) {
            if ($this->isMethodGet()) {
                if (isset($_GET['id']) && $_GET['action'] === 'cancel-order') {
                    $id = $_GET['id'];
                    $order = $this->productModel->getOrderById($id);

                    $order['status'] = 'Canceled';

                    $result = $this->productModel->UpdateOrder($order, $id);
                    header("Location: /account");
                }
            }
            if ($this->isMethodPost()) {
                if ($_POST['save'] === 'user-info') {
                    $result = $this->usersModel->UpdatePersonalInfo($_POST);
                    if ($result === true) {
                        header("Location: /account");
                    } else {
                        $message = implode("<br>", $result);
                        $params = [
                            'messageText' => $message,
                            'warningsCount' => count($result),
                            'messageClass' => 'error'
                        ];
                        return $this->render('index', $params, ['namePage' => 'Grovemade&reg; — Personal Account']);
                    }
                } else if ($_POST['save'] === 'user-address') {
                    $result = $this->usersModel->UpdateUserAddress($_POST);
                    if ($result === true) {
                        header("Location: /account");
                    } else {
                        return $this->render('index', null, ['namePage' => 'Grovemade&reg; — Personal Account']);
                    }
                } else
                    header("Location: /account");
            } else {
                return $this->render('index', null, ['namePage' => 'Grovemade&reg; — Personal Account']);
            }
        } else
            header("Location: /account/login");
    }
    /**
     * User Log out function
     */
    public function actionLogout()
    {
        unset($_SESSION['user']);
        header("Location: /");
    }

    public function actionLogin()
    {
        if ($this->isMethodPost()) {
            $user = $this->usersModel->AuthUser($_POST['email'], $_POST['password']);
            if (!empty($user)) {
                $_SESSION['user'] = $user;
                header("Location: /");
            } else {
                $params = [
                    'messageText' => '<i class="fas fa-times"></i> Incorrect login or password',
                    'messageClass' => 'error'
                ];
                return $this->render('login', $params, ['namePage' => 'Grovemade&reg; — Sign In']);
            }
        } else
            return $this->render('login', null, ['namePage' => 'Grovemade&reg; — Sign In']);
    }
    /**
     * User sign up function
     */
    public function actionRegistration()
    {
        if ($this->isMethodPost()) {
            $result = $this->usersModel->AddUser($_POST);

            if ($result === true) {
                $user = $this->usersModel->AuthUser($_POST['email'], $_POST['password']);
                $_SESSION['user'] = $user;
                header("Location: /");
            } else {
                $message = implode("<br>", $result);
                $params = [
                    'messageText' => $message,
                    'messageClass' => 'error'
                ];
                return $this->render('registration', $params, ['namePage' => 'Grovemade&reg; — Registration']);
            }
        }
        return $this->render('registration', null, ['namePage' => 'Grovemade&reg; — Registration']);
    }
    
    /**
     * User delete function
     */
    public function actionDelete()
    {
        $id = $_GET['id'];
        $user = $this->usersModel->getUserById($id);
        $currentUser = $this->usersModel->getCurrentUser();
        $title = 'Grovemade&reg; — Personal Account';

        if (isset($_GET['confirm']) && $_GET['confirm'] == 'true') {
            $result = $this->usersModel->DeleteUser($id);
            if ($result === true) {
                if ($currentUser['UserID'] == $user['UserID'])
                    unset($_SESSION['user']);
                header('Location: /');
            } else {
                $message = 'Oops... Something went wrong...';
                $params = [
                    'messageText' => $message,
                    'messageClass' => 'error',
                    'model' => $user
                ];

                return $this->render('index', $params, ['namePage' => $title]);
            }
        }
    }
}
