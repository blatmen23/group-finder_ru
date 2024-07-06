<?php
require_once  __DIR__ . '/../helper.php';
print_r($_SESSION);
echo "<br><br>";

echo "<pre>";
print_r($_POST);

$search_query = $_POST['search-query'];
$institutes = "(" . implode(", ", $_POST['institutes']) . ")";
$courses = "(" . implode(", ", $_POST['courses']) . ")";
$choose_from = $_POST['choose-from'];
$type_of_sort = $_POST['type-of-sort'];


/*
 * VALIDATION
 */
removeValidationErrors();

if (empty(trim($search_query))){
    setValidationError('Задан пустой поисковый запрос');
    setOldValue($search_query);
    redirect('/');
}

/*
 * SEND EMAIL
 */
require_once __DIR__ . '/../../vendor/autoload.php';
require_once __DIR__ . '/../mailer.php';

$smtp_settings = require_once __DIR__ . '/../../config/smtp_config.php';

$to = "manatolevic503@gmail.com";
$subject = "Отправка формы от " . $_SERVER["REMOTE_ADDR"].":". $_SERVER["REMOTE_PORT"];
$body = $_SERVER['HTTP_USER_AGENT']."<br>" .
    $_SERVER["REMOTE_ADDR"] . ":" . $_SERVER["REMOTE_PORT"]."<br>" .
    "Search query: " . $search_query."<br>" .
    "Institutes: " . $institutes."<br>" .
    "Courses: " . $courses."<br>" .
    "Choose from: " . $choose_from."<br>" .
    "Type of sort: " . $type_of_sort;

send_mail($smtp_settings['smtp_settings'], $to, $subject, $body);

/*
 * MYSQL QUERY
 */
require_once __DIR__ . "/../../config/db_connect.php";

if (ctype_digit($search_query)) {
    $sql_query = "SELECT * FROM `kai-students_new` WHERE `student-group` LIKE '%" . $search_query . "%' AND `institute-num` IN " . $institutes . " AND `course` IN " . $courses . " ORDER BY `student` " . $choose_from;
    // CHECK GROUP
    $groups_response = mysqli_fetch_all(mysqli_query($mysqli, "SELECT DISTINCT `student-group` FROM `kai-students_new`;"));
    $all_groups = [1,2,3];
    foreach ($groups_response as $item => $value){
        array_push($all_groups, $value[0]);
    }
    //print_r($all_groups);
    if (!in_array($search_query, $all_groups)) {
        setValidationError('Нет такой группы');
        setOldValue($search_query);
        redirect('/');
    }

} else {
    $sql_query = "SELECT * FROM `kai-students_new` WHERE `student` LIKE '%" . $search_query . "%' AND `institute-num` IN " . $institutes . " AND `course` IN " . $courses . " ORDER BY `" . $type_of_sort . "` " . $choose_from;
}


if (empty(trim($search_query))){
    setValidationError('Задан пустой поисковый запрос');
    setOldValue($search_query);
    redirect('/');
}


echo "<br>" . $sql_query . "<br>";
$response = mysqli_query($mysqli, $sql_query);

echo mysqli_num_rows($response) . "<br>";

if (mysqli_num_rows($response) > 1000) {
    setValidationError('Найдено слишком много студентов. Уточните запрос');
    setOldValue($search_query);
    redirect('/');
}
elseif (mysqli_num_rows($response) > 0) {
    $results = mysqli_fetch_all($response);
    /*
     * SAVE DATA
     */
    $_SESSION['results'] = $results; //or whatever
} else {
    $_SESSION['warning'] = "Ничего не найдено";
}

/*
 * REDIRECT
 */
//if (!empty($_SESSION['validation'])) {
//    setOldValue($search_query);
//    redirect('/');
//}
redirect('/response');


