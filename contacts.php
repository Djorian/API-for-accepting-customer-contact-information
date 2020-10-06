<!doctype html>
<html lang="ru">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta name="description" content="HTML5 CSS3 Bootstrap4 JavaScript PHP MySQL
                            Font Awesome" />
    <meta name="author" content="Егоров Дмитрий" />
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css"
        integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <link rel="stylesheet" href="./css/style.css">
    <link href="https://use.fontawesome.com/releases/v5.0.13/css/all.css" rel="stylesheet">
    <title>HTML5 CSS3 Bootstrap4 JavaScript PHP MySQL
                            Font Awesome</title>
    <link rel="shortcut icon" href="favicon.png" type="image/png">
</head>

<body>
    <header id="header">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="text-center mt-5 mb-5">
                        <h2>HTML5 CSS3 Bootstrap4 JavaScript PHP MySQL
                            Font Awesome</h2>
                        <p>API для приема контактных данных клиентов</p>
                    </div>
                </div>
            </div>
        </div>
    </header>
    <main class="container">
        <div class="row">
            <div class="col-lg-12">
                <h2 class="text-center mt-3">Данные связанные с номером <?php echo trim($_GET['phone']) ?></h2>
                <div>
                    <?php

                    function __autoload($class) {
                        include "Classes/$class.php";
                    }

                    $mysql = new Database();

                    $search = (string) trim(strip_tags(htmlspecialchars($_GET['phone'])));

                    $relatedClients = $mysql->select("*, source_id as id", "clients", "", "phone LIKE '%$search%'", 'phone ASC');

                    foreach ($relatedClients as $row) {
                        $id = $row['id'];
                    }

                    $clients = $mysql->select("*", "clients", "", "source_id = $id", 'id ASC');

                    foreach ($clients as $row) {
                        echo "<li class='list-group-item mt-2 card border border-dark p-3 mt-3'>";
                        echo "<span class='float-right font-italic'><i class='far fa-envelope'></i>  <a href='mailto:{$row['email']}'>{$row['email']}</a></span>";
                        echo "<h6 class='card-title text-left'>Имя: {$row['name']}</h6>";
                        echo "<p class='text-left font-italic mt-3'><i class='fas fa-phone-volume'></i> <a href='tel:+{$row['phone']}'>+7{$row['phone']}</a></p>";
                        echo "<div class='dropdown-divider' style='border-bottom: 2px dashed rgba(0,0,0,.5) !important;'>";
                        echo "</li>";
                    }
                    ?>
                </div>
            </div>
        </div>
    </main>
    <footer id=" footer">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="footer-copyright text-center mt-4 pb-3">&copy; 2020 Автор проекта: Егоров Дмитрий
                        <a href="https://www.djorian.com" target="_blank">djorian.com</a>
                    </div>
                </div>
            </div>
        </div>
    </footer>
    <script src="./js/jquery/jquery-3.4.1.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"
        integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q"
        crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"
        integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl"
        crossorigin="anonymous"></script>
</body>

</html>