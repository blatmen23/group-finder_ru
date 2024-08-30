<?php
require_once  __DIR__ . '/../src/helper.php';

if (!isset($_SESSION['results'])) {
    redirect("/reports");
}
?>

<!doctype html>
<form?php $title="GroupFinder: Результаты поиска в отчётах" ; require_once __DIR__ . "/../components/head.php" ; ?>

    <html lang="ru">


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
                        <?php $report_file_name = "report_{$result['report_date']}_{$result['report_id']}.txt" ?>
                        <div><?= $report_file_name; ?></div>
                        <div class="in_row__response-row">
                            <form name="report" action="/report_viewer" method="post">
                                <input type="hidden" name="report_id" value="<?= $result['report_id'] ?>">
                                <input type="hidden" name="report_file_name" value="<?= $report_file_name ?>">
                                <button class="lable__response-row open_button__response-row"
                                    type="submit">Перейти</button>
                            </form>
                            <!-- <form name="report" action="/report_download" method="post">
                                        <input type="hidden" name="report_id" value="<?= $result['report_id'] ?>">
                                        <input type="hidden" name="report_file_name" value="<?= $report_file_name ?>">
                                        <button class="lable__response-row download_button__response-row"
                                            type="submit">Скачать</button>
                                    </form> -->
                        </div>
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