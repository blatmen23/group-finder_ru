<?php
require_once  __DIR__ . '/../src/helper.php';

if (!isset($_SESSION['results'])) {
    redirect("/");
}
?>

<!doctype html>
<html lang="ru">
<?php
$title = "GroupFinder: Результаты поиска в архиве";
require_once __DIR__ . "/../components/head.php";
?>

<body>
    <div class="wrapper">
        <?php
        require_once __DIR__ . "/../components/header.php";
        ?>
        <div class="work-space">
            <div class="block-space">
                <?php
                $results = $_SESSION['results'];
                if ($results == "NOT FOUND") {
                    require_once "components/not_found_message.php";
                } else {
                    foreach ($results as $result) {
                        require __DIR__ . "/../components/result row/archive-row.php";
                    }
                }
                ?>
            </div>
        </div>
    </div>
    <?php
    require_once __DIR__ . "/../components/footer.php";
    ?>
</body>

</html>