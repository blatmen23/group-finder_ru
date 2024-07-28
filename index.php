<?php
require "./src/router.php";
$url = $_SERVER['REQUEST_URI']; // включает /
//$url = "/" . key($_GET);

$router = new Router(); //  /pages/
$router->addRoute("/", "main.php"); // добавили главную страницу
$router->addRoute("/response", "response.php");

$router->route($url);
?>

<!doctype html>
<html lang="ru">
<?php
$title = "GroupFinder: Index";
require_once __DIR__ . "/components/head.php";
?>

<body>

</body>

</html>