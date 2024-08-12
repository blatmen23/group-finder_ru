<?php
require_once  __DIR__ . '/../src/helper.php';

if (!isset($_SESSION['results'])) {
    redirect("/reports");
}
?>

<!doctype html>
<html lang="ru">
<input?php $title="GroupFinder: Результаты поиска в отчётах" ; require_once __DIR__ . "/../components/head.php" ; ?>

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
                        foreach ($results as $index => $result) : ?>
                            <div class="response-row">
                                <div><?= $result['file_report_name']; ?></div>
                                <?php require_once __DIR__ . "/../config/config.php"; ?>
                                <form name="report" action="/report" method="post">
                                    <input type="hidden" name="file_report_name" value="<?= $result['file_report_name'] ?>">
                                    <a class="lable__response-row download_button__response-row" href="<?= __DIR__ .  $reports_path . '/' . $result['file_report_name']; ?>" download target="_blank">Скачать</a>
                                    <button class="lable__response-row open_button__response-row" type="submit">Перейти</button>
                                </form>
                            </div>
                    <?php
                        endforeach;
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