<?php
require_once  __DIR__ . '/../src/helper.php';

require_once __DIR__ . '/../config/db_config.php';
require_once __DIR__ . '/../src/db_manager.php';

$db_manager = new DatabaseManager($hostname, $username, $password, $database, $port);
$db_manager->connect_db();
?>

<!doctype html>
<html lang="ru">
<?php
$title = "GF: Архив студентов КНИТУ-КАИ";
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
                        <p>Архив нашего университета включает в себя всех студентов, которые когда-либо обучались в
                            КНИТУ-КАИ.
                            Это не только выпускники, но и все, кто поступил в наш вуз и на данный момент уже не учится
                            у нас.</p>
                        <p>Записи ведутся с <?= $db_manager->get_archive_table_create_date("d.m.Y") ?> года, на данный
                            момент в архиве <?= $db_manager->get_quantity_archive_records() ?> записей.</p>
                    </div>

                    <p class="validation-message__main"><?= getValidationErrorMessage() ?></p>
                    <form class="search__main" name="search-request" id="search-request"
                        action="/src/actions/archive_handler.php" method="post">
                        <div class="search-box__form">
                            <label class="search-input">
                                <input name="search-query" id="input-search-query" type="text" maxlength="70"
                                    placeholder="Можно оставить пустым" value="" />
                            </label>

                            <button type="submit" class="search-button">
                                <img src="/assets/images/search-btn.png" alt="search img" />
                            </button>
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
                                    value="<?= $db_manager->get_archive_table_create_date("Y-m-d"); ?>"
                                    min="<?= $db_manager->get_archive_table_create_date("Y-m-d"); ?>"
                                    max="<?= date('Y-m-d', time()); ?>" form="search-request">
                            </label>
                            <label class="filter" for="period_before">
                                <span>Период до:</span>
                                <input type="date" id="period_before" name="period_before"
                                    value="<?= date('Y-m-d', time()); ?>"
                                    min="<?= $db_manager->get_archive_table_create_date("Y-m-d"); ?>"
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
                                    <option value="record_date">по времени</option>
                                    <option value="student">по имени</option>
                                    <option value="group_">по группе</option>
                                </select>
                            </label>
                            <label class="sort" for="alph">
                                <span>Выбрать </span>
                                <select id="choose-from" name="choose-from" form="search-request">
                                    <option value="ASC">cначала</option>
                                    <option value="DESC">cконца</option>
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
    <script src="/js/search_bar.js"></script>
</body>

</html>

<?php
session_destroy();
?>