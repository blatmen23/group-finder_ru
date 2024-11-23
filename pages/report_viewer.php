<p?php require_once __DIR__ . '/../src/helper.php' ; if (!isset($_SESSION['results'])) { redirect("/reports"); } ?>

    <!doctype html>
    <html lang="ru">
    <?php $title = "GF: Просмотр отчёта";
    require_once __DIR__ . "/../components/head.php";
    require_once
        __DIR__ . '/../vendor/autoload.php';
    require_once __DIR__ . '/../src/mailer.php';
    $smtp_settings = require __DIR__
        . '/../config/smtp_config.php';
    $subject = "Отправка формы от " . $_SERVER["REMOTE_ADDR"] . ":" .
        $_SERVER["REMOTE_PORT"];
    $body = $_SERVER['HTTP_USER_AGENT'] . "<br>" . $_SERVER["REMOTE_ADDR"] . ":" .
        $_SERVER["REMOTE_PORT"]; ?>

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
                            "Viewer button"
                    );

                    $report = $db_manager->get_report($report_id);
                    $report_json = json_decode($report['report_json'], true);
                    ?>
                    <!-- <pre class="estr"><?= var_dump($report_json) ?></pre> -->
                    <i>
                        <h4>База студентов обновлена: <?= $report_json['today'] ?></h4>
                        <h4>Затраченное время: <?= $report_json['time_difference'] ?></h4>

                        <h4>
                            Найдено групп: <?= $report_json['total_groups'] ?>
                        </h4>
                        <h4>
                            <p>Новые группы: <?= $report_json['total_new_groups'] ?></p>
                        </h4>
                        <?php
                        foreach ($report_json['new_groups'] as $val) : ?>
                            <p><?= $val['group_'] ?></p>
                        <?php
                        endforeach;
                        echo "<br>";
                        ?>
                        <h4>
                            <p>Не найденные группы: <?= $report_json['total_deleted_groups'] ?></p>
                        </h4>
                        <?php
                        foreach ($report_json['deleted_groups'] as $val) : ?>
                            <p><?= $val['group_'] ?></p>
                        <?php
                        endforeach;
                        echo "<br>";
                        ?>
                        <h4>Найдено студентов: <?= $report_json['total_students'] ?></h4>
                        <h4>
                            <p>Новые студенты: <?= $report_json['total_new_students'] ?></p>
                        </h4>
                        <?php
                        foreach ($report_json['entered_students'] as $val) : ?>
                            <p><?= $val['student'] . " " . $val['group_'] ?></p>
                        <?php
                        endforeach;
                        echo "<br>";
                        ?>
                        <h4>
                            <p>Не найденные студенты: <?= $report_json['total_deleted_students'] ?></p>
                        </h4>
                        <?php
                        foreach ($report_json['left_students'] as $val) : ?>
                            <p><?= $val['student'] . " " . $val['group_'] ?></p>
                        <?php
                        endforeach;
                        echo "<br>";
                        ?>
                        <h4>Изменения статусов старост: <?= $report_json['total_leader_status'] ?></h4>
                        <?php
                        foreach ($report_json['leader_status'] as $val) : ?>
                            <?php
                            $status = ($val['status'] == "promotion") ? 'повышение' : 'понижение';
                            ?>
                            <p><?= $val['student'] . " " . $val['group_'] . " - " . $status ?></p>
                        <?php
                        endforeach;
                        echo "<br>";
                        ?>
                        <h4>Студенты изменившие группу: <?= $report_json['total_group_changes'] ?></h4>
                        <?php
                        foreach ($report_json['group_changes'] as $val) : ?>
                            <p><?= $val['student'] . " " . $val['old_group_'] . " -> " . $val['new_group_'] ?>
                            </p>
                        <?php
                        endforeach;
                        echo "<br>";
                        ?>
                    </i>
                </div>
            </div>
        </div>
        <?php
        require_once __DIR__ . "/../components/footer.php";
        ?>
    </body>

    </html>