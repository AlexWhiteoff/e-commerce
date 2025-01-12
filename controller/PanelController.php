<?php

namespace controller;

use core\Controller;
use models\AccountModel;
use models\ProductModel;

/**
 * Controller for Account model
 * @package controller
 */
class PanelController extends Controller
{
    protected $usersModel;
    protected $productModel;
    function __construct()
    {
        $this->usersModel = new AccountModel;
        $this->productModel = new ProductModel();
    }

    public function actionIndex()
    {
        if (!empty($this->usersModel->getCurrentUser())) {
            if ($this->usersModel->getUserAccessLevel() === 2)
                header("Location: /panel/seller");
            else if ($this->usersModel->getUserAccessLevel() === 3)
                header("Location: /panel/admin");
            else
                header("Location: /panel/forbidden");
        } else {
            header("Location: /panel/forbidden");
        }
    }

    public function actionAdmin()
    {
        if (!empty($this->usersModel->getCurrentUser())) {
            if ($this->usersModel->getUserAccessLevel() === 3) {
                return $this->render('admin', null, ['namePage' => 'Woodmade&reg; — Admin panel']);
            } else
                header("Location: /panel/forbidden");
        } else {
            header("Location: /panel/forbidden");
        }
    }

    public function actionSeller()
    {
        if (!empty($this->usersModel->getCurrentUser())) {
            if ($this->usersModel->getUserAccessLevel() === 2)
                return $this->render('seller', null, ['namePage' => 'Woodmade&reg; — Seller Panel']);
            else
                header("Location: /panel/forbidden");
        } else {
            header("Location: /panel/forbidden");
        }
    }

    public function actionForbidden()
    {
        return $this->render('forbidden', null, ['namePage' => 'Woodmade&reg; — Forbidden']);
    }

    public function actionDelete()
    {
        $object = $_GET['object'];
        $id = $_GET['id'];
        $user = $this->usersModel->getCurrentUser();

        if ($user['access'] === '3') {
            if (isset($_GET['confirm']) && $_GET['confirm'] == 'true') {
                if ($object === 'order')
                    $result = $this->productModel->DeleteOrder($id);
                else if ($object === 'user')
                    $result = $this->usersModel->DeleteUser($id);

                header('Location: ' . $_SERVER['HTTP_REFERER']);
            } else {
                if ($this->usersModel->getUserAccessLevel() > 1)
                    header('Location: /panel/');
                else
                    header('Location: /panel/forbidden');
            }
        } else
            header('Location: /panel/forbidden');
    }

    public function actionEdit()
    {
        $id = $_GET['id'];
        $object = $_GET['object'];
        $user = $this->usersModel->getCurrentUser();

        if ($user['access'] === '2' || $user['access'] === '3') {
            if ($object === 'user') {
                if ($user['access'] === '3') {
                    $user = $this->usersModel->getUserById($id);
                    $title = 'Woodmade&reg; — Edit User';
                    if ($this->isMethodPost()) {

                        $result = $this->productModel->UpdateUser($_POST, $id);

                        if ($result === true) {
                            header("Location: /panel/");
                        } else {
                            $message = implode("<br>", $result);
                            $params = [
                                'messageText' => $message,
                                'warningsCount' => count($result),
                                'messageClass' => 'error',
                                'model' => $user
                            ];

                            return $this->render('edit', $params, ['namePage' => $title]);
                        }
                    } else {
                        return $this->render('edit', ['model' => $user], ['namePage' => 'Woodmade&reg; — Edit']);
                    }
                } else
                    header('Location: /panel/forbidden');
            } else if ($object === 'order') {
                $order = $this->productModel->getOrderById($id);
                $title = 'Woodmade&reg; — Edit Order';
                if ($this->isMethodPost()) {
                    $result = $this->productModel->UpdateOrder($_POST, $id);

                    if ($result === true) {
                        header("Location: /panel/");
                    } else {
                        $message = implode("<br>", $result);
                        $params = [
                            'messageText' => $message,
                            'warningsCount' => count($result),
                            'messageClass' => 'error',
                            'model' => $order
                        ];

                        return $this->render('edit', $params, ['namePage' => $title]);
                    }
                } else {
                    return $this->render('edit', ['model' => $order], ['namePage' => $title]);
                }
            }
        } else {
            header('Location: /panel/forbidden');
        }
    }
}
