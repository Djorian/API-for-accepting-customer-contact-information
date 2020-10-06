<?php

if (empty($_POST['search-for-clients-by-phone']) || $_POST['search-for-clients-by-phone'] == '') {
    $array[] = 'error-empty-fields';
    echo json_encode($array, JSON_UNESCAPED_UNICODE);
    exit;
} else {

    function __autoload($class) {
        include "../Classes/$class.php";
    }

    $search = (string) trim(strip_tags(htmlspecialchars($_POST['search-for-clients-by-phone'])));

    $string = str_replace("+7", "", $search);

    // Удалить +7 из строки
    if ($string) {
        $search = str_replace("+7", "", $search);
    }

    $mysql = new Database();

    $result = $mysql->select('name, phone, email', 'clients', '', "phone LIKE '%$search%'", '', '');

    if ($result) {
        echo json_encode($result, JSON_UNESCAPED_UNICODE);
    } else {
        $array[] = 'nothing-found';
        echo json_encode($array, JSON_UNESCAPED_UNICODE);
    }

}

?>