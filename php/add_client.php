<?php

if (isset($_POST['contact-source-id']) && isset($_POST['contact-name']) && isset($_POST['contact-phone']) && isset($_POST['contact-email'])) {
    if( empty($_POST['contact-source-id'])   ||
        empty($_POST['contact-name'])   ||
        empty($_POST['contact-phone'])     ||
        empty($_POST['contact-email'])   ||
        !filter_var($_POST['contact-email'],FILTER_VALIDATE_EMAIL))
    {
        $array[] = 'error-empty-fields';
        echo json_encode($array, JSON_UNESCAPED_UNICODE);
        exit;
    } else {

        function __autoload($class) {
            include "../Classes/$class.php";
        }

        $sourceID = (int) trim(strip_tags(htmlspecialchars($_POST['contact-source-id'])));
        $name = (string) trim(strip_tags(htmlspecialchars($_POST['contact-name'])));
        $phone = (string) trim(strip_tags(htmlspecialchars($_POST['contact-phone'])));
        $email = (string) trim(strip_tags(htmlspecialchars($_POST['contact-email'])));

        // Получение актуальной даты на момент отправки формы
        $date = (int) (floor( time() / 86400) - 17742) * 1 + 5640;

        // Проверка имени
        if(!preg_match('/^[\p{Cyrillic}\p{Common}]{2,50}+$/u', $name)){
            $array[] = 'error-name';
        }

        // Проверка телефона
        if(!preg_match("^[+7]{2}[0-9]{10}$^", $phone)){
            $array[] = 'error-phone';
        }

        // Проверка почты
        if(!preg_match("^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$^", $email)){
            $array[] = 'error-email';
        }

        if(!empty((array)$array)){
            echo json_encode($array, JSON_UNESCAPED_UNICODE);
            exit;
        } else {

            $phone = mb_substr($phone, 2);

            $mysql = new Database;

            $maxDate = $mysql->select("MAX(date) AS date", "clients", "", "source_id = $sourceID");

            foreach ($maxDate as $row) {
                $latestDateFromDatabase = $row['date'];
            }

            // Если дата последнего добавления клиента в БД < актуальной даты
            if ($latestDateFromDatabase < $date) {
                $result = $mysql->insert('clients', array('source_id'=>$sourceID, 'name'=>$name, 'phone'=>$phone, 'email'=>$email, 'date'=>$date));

                if ($result) {
                    $array[] = 'successfully';
                } else {
                    $array[] = 'error-server-data';
                }
            }

            // Если дата последнего добавления клиента в БД == актуальной дате
            if ($latestDateFromDatabase == $date) {
                $array[] = 'error-once-a-day';
            }
            
            echo json_encode($array, JSON_UNESCAPED_UNICODE);
        }
    }
}

?>