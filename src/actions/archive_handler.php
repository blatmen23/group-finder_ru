<?php
$search_query = trim($_POST['search-query']);
$period_from = $_POST['period_from'];
$period_before = $_POST['period_before'];
$choose_from = $_POST['choose-from'];
$type_of_sort = $_POST['type-of-sort'];

require_once __DIR__ . "/../handler.php";

$handler = new Archive($search_query, $period_from, $period_before, $choose_from, $type_of_sort);

$handler->validation();

$results = $handler->get_results();

$handler->send_email();

redirect('/archive_response');
