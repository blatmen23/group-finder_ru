<?php
$period_from = $_POST['period_from'];
$period_before = $_POST['period_before'];

require_once __DIR__ . "/../handler.php";

$handler = new Reports($period_from, $period_before);

$handler->validation();

$handler->send_email();

$results = $handler->get_results($period_from, $period_before);

$_SESSION['results'] = array_reverse($results);

redirect('/reports_response');
