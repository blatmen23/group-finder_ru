<?php
require_once  __DIR__ . '/../src/helper.php';

if (!isset($_SESSION['results'])) {
    redirect("/archive");
}
?>

<!doctype html>
<html lang="ru">
<?php
$title = "GF: Результаты поиска в архиве";
require_once __DIR__ . "/../components/head.php";
?>

<body>
    <div class="wrapper">
        <?php
        require_once __DIR__ . "/../components/header.php";
        ?>
        <div class="work-space">
            <div class="block-space container">
                <?php
                $results = $_SESSION['results'];
                if ($results == "NOT FOUND") {
                    require_once "components/not_found_message.php";
                } else {
                    foreach ($results as $result) : ?>
                <div class="response-row">
                    <div><?= $result["student"] . ' ' . $result["group_"] ?>
                        <?php if ($result["leader"]) { ?> <span class="lable__response-row">Староста</span><?php } ?>
                    </div>
                    <div><?php
                                    $timestamp = DateTimeImmutable::createFromFormat('Y-m-d', $result["record_date"])->getTimestamp();
                                    echo date("d.m.Y", $timestamp);
                                    ?></div>
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