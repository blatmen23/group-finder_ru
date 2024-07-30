<?php
require_once  __DIR__ . '/../src/helper.php';

if (!isset($_SESSION['results'])) {
    redirect("/");
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
                if ($_SESSION['results'] != "NOT FOUND") {
                    $users_emoji = json_decode(file_get_contents(__DIR__ . "/../config/users_emoji.json"), true);
                    //                print_r($users_emoji);
                    //                echo "<br>";
                    //                print_r(array_keys($users_emoji));
                    //                echo "<br>";
                    $results = $_SESSION['results'];
                    foreach ($results as $result) {
                        //                print_r($result);
                        //                echo "<br>";
                        // student_id	student_name	student_group	leader	group_id	group_name	institute	course	institute_id	institute_name	institute_num	course_id	course_name
                        $student = $result[1];
                        $group = $result[5];

                        if (isset($users_emoji[$result[0]])) {
                            $student = $result[1] . " " . $users_emoji[$result[0]];
                        }
                        if ($result[3] == 1) {
                            $is_leader = true;
                        } else {
                            $is_leader = false;
                        }

                        require __DIR__ . "/../components/response-row.php";
                    }
                } else {
                    require_once "components/not_found_message.php";
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