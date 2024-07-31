<?php
$search_query = trim($_POST['search-query']);
$institutes = "(" . implode(", ", $_POST['institutes']) . ")";
$courses = "(" . implode(", ", $_POST['courses']) . ")";
$choose_from = $_POST['choose-from'];
$type_of_sort = $_POST['type-of-sort'];

require_once __DIR__ . "/../handler.php";

$handler = new Response($search_query, $institutes, $courses, $choose_from, $type_of_sort);

$handler->validation();

$handler->send_email();

$results = $handler->get_results();

$_SESSION['results'] = $results;

redirect('/response');
