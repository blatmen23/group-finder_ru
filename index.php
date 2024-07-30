<?php
require "src/router.php";

$url = $_SERVER['REQUEST_URI']; // URI, который был предоставлен для доступа к этой странице. Например, '/index.html'.

$router = new Router(); //  /pages/
$router->addRoute("/", "main.php"); // добавили главную страницу
$router->addRoute("/response", "response.php");
$router->addRoute("/archive", "archive.php");
$router->addRoute("/archive_response", "archive_response.php");
$router->addRoute("/testing", "testing.php");

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