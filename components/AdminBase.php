<?php


    /**
     *Абстрактный класс AdminBase содержит общую логику для контроллеров, которые используються в панели администратора
     */
    abstract class AdminBase
    {
        /**
         * Метод проверки пользователя на то, являеться ли он администратором
         * @return bool
         */
        public static function checkAdmin()
        {
            //Проверяем пользователя на авторизацию
            $userId = User::checkLogged();

            //Получаем информацию о текущем пользователе
            $user = User::getUserById($userId);

            //Если роль пользователя 'admin'. пускаем его в админпанель
            if ($user['role'] == 'admin') {
                return true;
            }
            //иначе завершаем работу с сообщением о закрытом доступе
            die('Access denied');
        }
    }