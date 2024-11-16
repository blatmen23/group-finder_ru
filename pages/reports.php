<?php
require_once  __DIR__ . '/../src/helper.php';

require_once __DIR__ . '/../config/db_config.php';
require_once __DIR__ . '/../src/db_manager.php';

$db_manager = new DatabaseManager($hostname, $username, $password, $database);
$db_manager->connect_db();
?>

<!doctype html>
<html lang="ru">
<?php
$title = "GF: Движение студентов КНИТУ-КАИ";
require_once __DIR__ . "/../components/head.php";
?>

<body>
    <div class="wrapper">
        <?php
        require_once __DIR__ . "/../components/header.php";
        ?>
        <div class="work-space" id="movement-space">
            <main id="moving-parent_1">
                <div class="block-space">
                    <div class="manual__main">
                        <p class="title-block__main"><b>О странице</b></p>
                        <p>На этой странице размещены ежедневные отчёты о движении студентов КНИТУ-КАИ. Каждый отчёт
                            содержит изменения, произошедшие за последние сутки.
                        </p>
                        <p>Записи ведутся с <?= $db_manager->get_report_table_create_date("d.m.Y") ?> года, и на данный
                            момент в архиве <?= $db_manager->get_quantity_report_records() ?> записей.</p>
                    </div>

                    <p class="validation-message__main"><?= getValidationErrorMessage() ?></p>
                    <form class="search__main" name="search-request" id="search-request"
                        action="/src/actions/reports_handler.php" method="post">
                        <div class="search-button__form">
                            <button type="submit" class="search-button">Получить отчёты</button>
                        </div>
                    </form>
                </div>

                <?php require_once __DIR__ . "/../components/about_project.php"; ?>
            </main>
            <aside id="moving-parent_2">
                <div class="block-space">
                    <div class="filters-box__form">
                        <p class="title-block__main"><b>Фильтры поиска</b></p>
                        <div class="filters">
                            <label class="filter" for="period_from">
                                <span>Период с:</span>
                                <input type="date" id="period_from" name="period_from"
                                    value="<?= $db_manager->get_report_table_create_date("Y-m-d"); ?>"
                                    min="<?= $db_manager->get_report_table_create_date("Y-m-d"); ?>"
                                    max="<?= date('Y-m-d', time()); ?>" form="search-request">
                            </label>
                            <label class="filter" for="period_before">
                                <span>Период до:</span>
                                <input type="date" id="period_before" name="period_before"
                                    value="<?= date('Y-m-d', time()); ?>"
                                    min="<?= $db_manager->get_report_table_create_date("Y-m-d"); ?>"
                                    max="<?= date('Y-m-d', time()); ?>" form="search-request">
                            </label>
                        </div>
                    </div>
                </div>
                <div class="block-space">
                    <div class="sorting-box__form">
                        <p class="title-block__main"><b>Параметры сортировки</b></p>
                        <div class="sorting">
                            <label class="sort" for="alph">
                                <span>Сортировать </span>
                                <select id="type-of-sort" name="type-of-sort" form="search-request">
                                    <option value="report_date">по времени</option>
                                </select>
                            </label>
                            <label class="sort" for="alph">
                                <span>Выбрать </span>
                                <select id="choose-from" name="choose-from" form="search-request">
                                    <option value="DESC">сконца</option>
                                    <option value="ASC">сначала</option>
                                </select>
                            </label>
                        </div>
                    </div>
                </div>
            </aside>
        </div>
    </div>
    <?php
    require_once __DIR__ . "/../components/footer.php";
    ?>
    <script src="/js/adaptive_from_device.js"></script>
    <script src="/js/date_period_picker.js"></script>
</body>

</html>

<?php
session_destroy();
?>