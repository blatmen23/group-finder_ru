<?php
require_once  __DIR__ . '/../src/helper.php';

if (!isset($_SESSION['results'])) {
    redirect("/reports");
}

require_once __DIR__ . '/../vendor/autoload.php';
require_once __DIR__ . '/../src/mailer.php';

$smtp_settings = require __DIR__ . '/../config/smtp_config.php';
$subject = "Отправка формы от " . $_SERVER["REMOTE_ADDR"] . ":" . $_SERVER["REMOTE_PORT"];
$body = $_SERVER['HTTP_USER_AGENT'] . "<br>" .
    $_SERVER["REMOTE_ADDR"] . ":" . $_SERVER["REMOTE_PORT"];
?>

<!doctype html>
<html lang="ru">
<?php
$title = "GF: Скачать отчёт";
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
                require __DIR__ . "/../config/db_config.php";
                require_once __DIR__ . "/../src/db_manager.php";

                $db_manager = new DatabaseManager($hostname, $username, $password, $database, $port);
                $db_manager->connect_db();

                $report_id = $_POST['report_id'];
                $report_file_name = $_POST['report_file_name'];

                send_mail(
                    $smtp_settings['smtp_settings'],
                    $smtp_settings['to'],
                    $subject,
                    $body . "<br>" .
                        "Report id: " . $report_id . "<br>" .
                        "Report file name: " . $report_file_name . "<br>" .
                        "Download button"
                );

                $report = $db_manager->get_report($report_id);

                $report_file_path = __DIR__ . "/../data/reports/txt/{$report_file_name}";
                $report_content = $report["report_content"];

                file_put_contents($report_file_path, $report_content);
                ?>

                <a class="lable__response-row download_button__response-row" href="<?= $report_file_path; ?>"
                    download="report_2024-08-30_3.txt" target="_blank" aria-label>Скачать</a>

            </div>
        </div>
    </div>
    <?php
    require_once __DIR__ . "/../components/footer.php";
    ?>
</body>

</html>