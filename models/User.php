<?php


/**
 * Class User
 */
class User
{
    /**
     * @param $name
     * @param $email
     * @param $password
     * @return bool
     */
    public static function register($name, $email, $password)
    {
        $db = Db::getConnection();
        $sql = "INSERT INTO user (name, email, password) VALUE (:name, :email, :password)";
        $result = $db->prepare($sql);
        $result->bindParam(':name', $name, PDO::PARAM_STR);
        $result->bindParam(':email', $email, PDO::PARAM_STR);
        $result->bindParam(':password', $password, PDO::PARAM_STR);

        return $result->execute();
    }

    /**
     * Редактирование данных пользователем
     *
     * @param int $id
     * @param string $name
     * @param string $password
     *
     * @return bool
     */
    public static function edit($id, $name, $password)
    {
        $db = Db::getConnection();

        $sql = "UPDATE user
                SET name = :name, password = :password
                WHERE id = :id";
        $result = $db->prepare($sql);
        $result->bindParam(':id', $id, PDO::PARAM_INT);
        $result->bindParam(':name', $name, PDO::PARAM_STR);
        $result->bindParam(':password', $password, PDO::PARAM_STR);

        return $result->execute();
    }

    /**
     * Проверяем существует ли пользователь с заданными $email и $password
     *
     * @param string $email
     * @param string $password
     *
     * @return mixed: integer user id or false
     */
    public static function checkUserData($email, $password)
    {
        $db = Db::getConnection();

        $sql = 'SELECT * FROM user WHERE email = :email AND password = :password';

        $result = $db->prepare($sql);
        $result->bindParam(':email', $email, PDO::PARAM_STR);
        $result->bindParam(':password', $password, PDO::PARAM_STR);
        $result->execute();

        $user = $result->fetch();

        if ($user) {
            return $user['id'];
        }
        return false;
    }

    /**
     * Запоминаем пользователя
     *
     * @param int $userId
     */
    public static function auth($userId)
    {
        $_SESSION['user'] = $userId;
    }

    /**
     * Проверяем авторизировался пользователь или нет
     */
    public static function checkLogged()
    {
        //Если сессия есть, вернем индетификатор пользователя
        if (isset($_SESSION['user'])) {
            return $_SESSION['user'];
        }

        header("Location: /user/login");
    }

    /**
     * Является ли пользователь гостем
     */
    public static function isGuest()
    {
        if (isset($_SESSION['user'])) {
            return false;
        }
        return true;
    }

    /**
     * Проверка имени на кол-во введенных символов
     *
     * @param $name
     *
     * @return bool
     */
    public static function checkName($name)
    {
        if (strlen($name) >= 2) {
            return true;
        }
        return false;
    }

    /**
     * Проверка password на кол-во введенных символов
     */
    public static function checkPassword($password)
    {
        if (strlen($password) >= 6) {
            return true;
        }
        return false;
    }

    /**
     * Проверка email на валидность
     */
    public static function checkEmail($email)
    {
        if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
            return true;
        }
        return false;
    }

    /**
     * Проверяем телефон на валидность
     *
     * @param int $phone
     *
     * @return bool
     */
    public static function checkPhone($phone)
    {
        $pattern = "^\+?[378]?\d{1}[-\(]?\d{3}\)?-?\d{3}-?\d{2}-?\d{2}$^";
        if (preg_match($pattern, $phone)) {
            return true;
        }
        return false;
    }

    /**
     * Проверка E-mail на наличие
     *
     * @param $email <p>E-mail пользователя</p>
     *
     * @return bool
     */
    public static function checkEmailExist($email)
    {
        $db = Db::getConnection();

        $sql = "SELECT count(*) as count FROM user WHERE email = :email";
        $result = $db->prepare($sql);
        $result->bindParam(':email', $email, PDO::PARAM_STR);
        $result->execute();

        if ($result->fetchColumn()) {
            return true;
        }
        return false;
    }

    /**
     * @param int $id
     *
     * @return mixed user by id
     */
    public static function getUserById($id)
    {
        if ($id) {
            $db = Db::getConnection();
            $sql = 'SELECT * FROM user WHERE id =:id';

            $result = $db->prepare($sql);
            $result->bindParam(':id', $id, PDO::PARAM_INT);

            //Указываем, что хотим получить данные ввиде массива
            $result->setFetchMode(PDO::FETCH_ASSOC);
            $result->execute();

            return $result->fetch();
        }
    }


    /**
     * @param $email
     * @return bool
     */
    public static function getSubscribe($email, $subscribe = 1)
    {
        if ($email) {
            $db = Db::getConnection();

            $sql = "SELECT count(*) as count FROM user WHERE email = :email";
            $result = $db->prepare($sql);
            $result->bindParam(':email', $email, PDO::PARAM_STR);
            $result->execute();

            if ($result->fetchColumn()) {
                $sql = "UPDATE user
                SET subscribe = 1
                WHERE email = :email";
                $result = $db->prepare($sql);
                $result->bindParam(':email', $email, PDO::PARAM_STR);
                $result->execute();
            } else {
                $db = Db::getConnection();
                $sql = "INSERT INTO user (email, subscribe) VALUE (:email, :subscribe)";
                $result = $db->prepare($sql);
                $result->bindParam(':email', $email, PDO::PARAM_STR);
                $result->bindParam(':subscribe', $subscribe, PDO::PARAM_STR);
                $result->execute();
            }
        }


    }

    public static function getHistory()
    {

            //Получаем индитификатор пользователя из сессии
            $userId = User::checkLogged();



    }


}