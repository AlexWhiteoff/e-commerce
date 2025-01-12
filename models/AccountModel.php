<?php

namespace models;

use core\Model;
use core\Core;
use core\Logger;
use core\Utils;
use Exception;

class AccountModel extends Model
{
    public function Validate($user)
    {
        $errors = [];
        if (empty($user['email']))
            $errors[] = '<i class="fas fa-times"></i> Email field cannot be empty';
        if (!filter_var($user['email'], FILTER_VALIDATE_EMAIL))
            $errors[] = '<i class="fas fa-times"></i> Invalid email format';

        $isAlreadyExist = $this->getUserByEmail($user['email']);
        if (!empty($isAlreadyExist))
            $errors[] = '<i class="fas fa-times"></i> Email address already in use';

        if (empty($user['password']))
            $errors[] = '<i class="fas fa-times"></i> Password field cannot be empty';
        if ($user["password"] != $user["repeat-password"])
            $errors[] = '<i class="fas fa-times"></i> Passwords must match';
        if (strlen($user['password']) < 6 or strlen($user['password']) > 16)
            $errors[] = '<i class="fas fa-times"></i> Password must be between 6 and 16 digits';

        if (count($errors) > 0)
            return $errors;
        else
            return true;
    }

    public function isUserAuthenticated()
    {
        return isset($_SESSION['user']);
    }

    public function getUserAccessLevel()
    {
        if (isset($_SESSION['user'])) {
            $user = $this->getUserByEmail($_SESSION['user']['email']);
            unset($_SESSION['user']);
            $_SESSION['user'] = $user;

            $access = intval($_SESSION['user']['access']);

            return $access;
        }
    }

    public function getCurrentUser()
    {
        if ($this->isUserAuthenticated())
            return $_SESSION['user'];
        else
            return null;
    }

    public function getUsers($where)
    {
        if ($where !== null)
            $rows = Core::getInstance()->getDataBase()->select('user', '*', $where);
        else
            $rows = Core::getInstance()->getDataBase()->select('user', '*');
        if (count($rows) > 0)
            return $rows;
        else
            return [];
    }

    public function AddUser($user)
    {
        $validateResult = $this->Validate($user);
        if (is_array($validateResult))
            return $validateResult;

        $fields = ['email', 'password'];
        $user = Utils::ArrayFilter($user, $fields);

        $user['password'] = password_hash($user['password'], PASSWORD_BCRYPT);

        Core::getInstance()->getDataBase()->insert('user', $user);
        return true;
    }

    public function AuthUser($email, $password)
    {
        try {
            $users = Core::getInstance()->getDataBase()->select(
                'user',
                '*',
                ['email' => $email]
            );
    
            if (!empty($users)) {
                $user = $users[0];
                if (password_verify($password, $user['password']))
                    return $user;
            }

            return false;
        } catch (Exception $e) {
            Logger::log('User authentication error: ' . $e->getMessage(), "ERROR");
            return false;
        }
    }

    public function getUserByEmail($email)
    {
        $rows = Core::getInstance()->getDataBase()->select('user', '*', ['email' => $email]);
        if (count($rows) > 0)
            return $rows[0];
        else
            return null;
    }

    public function getUserById($id)
    {
        $rows = Core::getInstance()->getDataBase()->select('user', '*', ['UserID' => $id]);
        if (count($rows) > 0)
            return $rows[0];
        else
            return null;
    }

    public function DeleteUser($id)
    {
        $user = $this->getUserById($id);
        $currentUser = $this->getCurrentUser();

        if (empty($user) || empty($currentUser) || ($user['UserID'] != $currentUser['UserID'] && $currentUser['access'] != '3'))
            return false;

        Core::getInstance()->getDataBase()->delete('user', ['UserID' => $id]);
        return true;
    }

    public function UpdateUserValidation($user)
    {
        $errors = [];
        if (!empty($user['firstname']))
            if (preg_match('/^(a-z)/i', $user['firstname']))
                $errors[] = '<i class="fas fa-times"></i> Firstname field must contain only letters';
        if (!empty($user['lastname']))
            if (preg_match('/^(a-z)/i', $user['lastname']))
                $errors[] = '<i class="fas fa-times"></i> Lastname field must contain only letters';

        if (!empty($user['telephone'])) {
            $phoneRegex = '/\+?([0-9]{1,3})(-|\(| )?([0-9]{3})(-|\)| )?([0-9]{3})(-| )?([0-9]{4})/';
            if (!preg_match($phoneRegex, $user['telephone']))
                $errors[] = '<i class="fas fa-times"></i> Phone number must be in the format like +1 123-456-7890 ';
        }
        if (!empty($user['email']))
            if (!filter_var($user['email'], FILTER_VALIDATE_EMAIL))
                $errors[] = '<i class="fas fa-times"></i> Enter correct email address';

        if (count($errors) > 0)
            return $errors;
        else
            return true;
    }

    public function UpdatePersonalInfo($user)
    {
        $currentUser = $this->getCurrentUser();

        if (empty($currentUser))
            return false;

        $validateResult = $this->UpdateUserValidation($user);
        if (is_array($validateResult))
            return $validateResult;


        $fields = [];
        $fieldPattern = ['firstname', 'lastname', 'gender', 'birthdayDate', 'telephone', 'email'];
        foreach ($fieldPattern as $row)
            if (!empty($user[$row]) && $user[$row] != $currentUser[$row])
                array_push($fields, $row);

        $user = Utils::ArrayFilter($user, $fields);
        if (!empty($user))
            Core::getInstance()->getDataBase()->update('user', $user, ['UserID' => $currentUser['UserID']]);
        return true;
    }

    public function UpdateUserAddress($userData)
    {
        $currentUserData = $this->getCurrentUser();

        if (empty($currentUserData))
            return false;

        $fields = [];
        $fieldPattern = ['address', 'apartment', 'city', 'postalCode', 'country'];

        foreach ($fieldPattern as $row)
            if ($userData[$row] != $currentUserData[$row])
                array_push($fields, $row);

        $userData = Utils::ArrayFilter($userData, $fields);

        if (!empty($userData))
            Core::getInstance()->getDataBase()->update('user', $userData, ['UserID' => $currentUserData['UserID']]);
        return true;
    }
}
