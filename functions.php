<?php


class shortenerLinks
{



    protected $db;

    private function connectToDB()
    {
        $this->db = new mysqli('', '', '', '');// Подключаемся к БД

        if ($this->db->connect_errno) {
            printf("Ошибка подключения к базе данных: %s", $this->db->connect_error);
            exit();
        }
    }

    public function getFullUrl($link)
    {

        $this->connectToDB();

        $query = "SELECT 'fullUrl' FROM `links` WHERE 'url'='" . $link . "'"; // Готовим запрос

        if ($res = $this->db->query($query)) { // Выполяем запрос
            if ($row = $res->fetch_assoc()) { // Обрабатываем результат запроса
                return $row['fullUrl']; //Возвращаем полный URL
            } else { // ЕСли результатов нет
                return "Вы указали недействительный URL"; //Возвращаем ошибку
            }
        }
    }

    public function createURL($link)
    {
        $this->connectToDB();

        $check = $this->checkURLExist($link);

        if(!$check) { // Если URL не найден в базе созданных
            $randomAlph = ['A', 'B', 'C', 'D', 'E', 'F', 'a', 'b', 'c', 'd', 'e', 'f'];

            $time = time();

            $result = '';

            for ($i=0;$i<5;$i++) {
                $last = $time%count($randomAlph);
                $time = ($time-$last)/count($randomAlph);
                $result.=$randomAlph[$last];
            }

            $query = "INSERT INTO `links` (`url`, `fullUrl`) VALUES ('".$result."', '".$link."')";

            $this->db->query($query);

            return $this->checkURLExist($link);

        } else {
            return $check;
        }
    }

    public function checkURLExist($link)
    {
        $query = "SELECT 'url' FROM `links` WHERE 'url'='" . $link . "'"; // Готовим запрос

        if ($res = $this->db->query($query)) { // Выполяем запрос
            if ($row = $res->fetch_assoc()) { // Обрабатываем результат запроса
                return $row['url']; //Возвращаем короткий URL
            } else { // Если результатов нет
                return false; //Возвращаем ошибку
            }
        }
    }
}