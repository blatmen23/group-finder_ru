<?php
require_once  __DIR__ . '/../src/helper.php';

if (!isset($_SESSION['results'])) {
    redirect("/archive");
}
?>

<!doctype html>
<html lang="ru">
<?php
$title = "GroupFinder: Результаты поиска в архиве";
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
                            <form href="#">
                                <div><?= $result["student_name"] ?></div>
                                <div>
                                    <?php
                                    $timestamp = DateTimeImmutable::createFromFormat('Y-m-d H:i:s', $result["record_time"])->getTimestamp();
                                    echo date("d.m.Y", $timestamp);
                                    ?>
                                </div>
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