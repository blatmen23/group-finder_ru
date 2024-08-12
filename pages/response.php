<?php
require_once  __DIR__ . '/../src/helper.php';

if (!isset($_SESSION['results'])) {
    redirect("/");
}
?>

<!doctype html>
<html lang="ru">
<?php
$title = "GroupFinder: Результаты поиска";
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
                    foreach ($results as $result) : ?>
                        <div class="response-row">
                            <div><?= $result["student_name"] ?>
                                <?php if ($result["leader"]) { ?> <span class="lable__response-row">Староста</span><?php } ?>
                            </div>
                            <div><?= $result["group_name"] ?></div>
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