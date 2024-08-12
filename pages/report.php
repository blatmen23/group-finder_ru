<?php
require_once  __DIR__ . '/../src/helper.php';

if (!isset($_SESSION['results'])) {
    redirect("/reports");
}

// echo "<br><br><br>";
// echo "<pre>";
// var_dump($_POST);
// echo "<br><br><br>";
?>

<!doctype html>
<html lang="ru">
<?php
$title = "GroupFinder: Просмотр отчёта";
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
                require_once __DIR__ . "/../config/config.php";

                $report_file_name = $_POST['file_report_name'];
                $report_text = file_get_contents(__DIR__ . $reports_path . "/" . $report_file_name);
                ?>
                <pre><?= $report_text ?></pre>
            </div>
        </div>
    </div>
    <?php
    require_once __DIR__ . "/../components/footer.php";
    ?>
</body>

</html>