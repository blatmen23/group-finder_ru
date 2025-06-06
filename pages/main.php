<?php
require_once  __DIR__ . '/../src/helper.php';
?>

<!doctype html>
<html lang="ru">
<?php
$title = "GF: Поиск студентов КНИТУ-КАИ";
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
                        <p class="title-block__main"><b>Краткое руководство</b></p>
                        <p>1. Введите фамилию, имя или отчество студента (можно все сразу) без ошибок.</p>
                        <p>2. Если вы хотите найти студента по номеру группы, введите номер группы в поисковую строку.
                        </p>
                        <p>3. Настройте фильтры, чтобы уточнить результаты поиска.</p>
                    </div>

                    <p class="validation-message__main"><?= getValidationErrorMessage() ?></p>
                    <form class="search__main" name="search-request" id="search-request"
                        action="/src/actions/response_handler.php" method="post">
                        <div class="search-box__form">
                            <label class="search-input">
                                <input name="search-query" id="input-search-query" type="text" maxlength="70"
                                    placeholder="Введите запрос" value="<?= getOldValue() ?>" />
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
                            <label class="filter" for="institutes">
                                <span>Институт (6/6)</span>
                                <select id="institutes" name="institutes[]" form="search-request" size="7" multiple>
                                    <option value="0" selected>Выбрать всё</option>
                                    <option value="1" selected>1 ИАНТЭ + ТК</option>
                                    <option value="2" selected>2 ФМФ</option>
                                    <option value="3" selected>3 ИАЭП</option>
                                    <option value="4" selected>4 ИКТЗИ + КИТ</option>
                                    <option value="5" selected>5 ИРЭФ-ЦТ</option>
                                    <option value="6" selected>6 ИИЭиП</option>
                                </select>
                            </label>
                            <label class="filter" for="courses">
                                <span>Курс (5/5)</span>
                                <select id="courses" name="courses[]" form="search-request" size="6" multiple>
                                    <option value="0" selected>Выбрать всё</option>
                                    <option value="1" selected>1</option>
                                    <option value="2" selected>2</option>
                                    <option value="3" selected>3</option>
                                    <option value="4" selected>4</option>
                                    <option value="5" selected>5</option>
                                </select>
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
                                    <option value="group_">по группе</option>
                                    <option value="student">по имени</option>
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
    <script src="/js/selectors.js"></script>
    <script src="/js/search_bar.js"></script>
</body>

</html>

<?php
session_destroy();
?>