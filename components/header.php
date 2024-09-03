<?php
function page_checker($page)
{
    if ($_SERVER['REQUEST_URI'] == $page) {
        return "selected-page";
    } else {
        return "";
    }
}
?>

<header>
    <div class="logo-background__header">
        <div class="container text-holder__header">
            <div class="logo-text__header">
                Group Finder
            </div>
        </div>
    </div>
    <div class="sublogo-background__header">
        <div class="container text-holder__header">
            <div class="sublogo-text__header" id="sublogo-text">
                Сайт студентов КНИТУ-КАИ
            </div>
            <div class="sublogo-nav__header">
                <a class="<?= page_checker('/') ?>" href="/">Главная</a>
                <a class="<?= page_checker('/archive') ?>" href="archive">Архив</a>
                <a class="<?= page_checker('/reports') ?>" href="reports">Отчёты</a>
            </div>
        </div>
    </div>
    <div class="wrapper__header">
        <a class="logo-img__header" href="/"><img class="logotype__header" src="../assets/images/logotype.png"
                alt="logotype"></a>
    </div>

</header>