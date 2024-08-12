<?php
require_once  __DIR__ . '/helper.php';

class Handler
{
    protected $body;
    protected $db_manager;

    function __construct()
    {
        $this->body = $_SERVER['HTTP_USER_AGENT'] . "<br>" .
            $_SERVER["REMOTE_ADDR"] . ":" . $_SERVER["REMOTE_PORT"];

        require __DIR__ . "/../config/db_config.php";
        require_once __DIR__ . "/db_manager.php";

        $this->db_manager = new DatabaseManager($hostname, $username, $password, $database);
        $this->db_manager->connect_db();
    }

    function send_email()
    {
        require_once __DIR__ . '/../vendor/autoload.php';
        require_once __DIR__ . '/mailer.php';

        $smtp_settings = require __DIR__ . '/../config/smtp_config.php';
        $subject = "Отправка формы от " . $_SERVER["REMOTE_ADDR"] . ":" . $_SERVER["REMOTE_PORT"];

        send_mail($smtp_settings['smtp_settings'], $smtp_settings['to'], $subject, $this->body);
    }

    protected function complete_result($results)
    {
        $users_emoji = json_decode(file_get_contents(__DIR__ . "/../config/users_emoji.json"), true);

        foreach ($results as &$result) {
            if (isset($users_emoji[$result["student_id"]])) {
                $result["student_name"] .= " " . $users_emoji[$result["student_id"]];
            }
        }

        // Сброс указателя после использования ссылочной переменной
        unset($result);

        // Возвращаем исходный массив $results, который теперь изменён
        return $results;
    }
}

class Response extends Handler
{
    private $search_query;
    private $institutes;
    private $courses;
    private $choose_from;
    private $type_of_sort;

    function __construct($search_query, $institutes, $courses, $choose_from, $type_of_sort)
    {
        parent::__construct();

        $this->search_query = $search_query;
        $this->institutes = $institutes;
        $this->courses = $courses;
        $this->choose_from = $choose_from;
        $this->type_of_sort = $type_of_sort;

        $this->body .= "<br>" .
            "Search query: " . $this->search_query . "<br>" .
            "Institutes: " . $this->institutes . "<br>" .
            "Courses: " . $this->courses . "<br>" .
            "Choose from: " . $this->choose_from . "<br>" .
            "Type of sort: " . $this->type_of_sort;
    }

    function validation()
    {
        removeValidationErrors();

        if (empty(trim($this->search_query))) {
            setValidationError('Задан пустой поисковый запрос');
            setOldValue($this->search_query);
            redirect('/');
        }
    }

    function get_results()
    {
        if (ctype_digit($this->search_query)) { // ищут ГРУППУ
            $all_groups = $this->db_manager->get_all_groups();

            if (!in_array($this->search_query, $all_groups)) {
                setValidationError('Нет такой группы');
                setOldValue($this->search_query);
                redirect('/');
            }

            $response = $this->db_manager->get_group($this->search_query, $this->institutes, $this->courses, $this->choose_from);
        } else { // ищут СТУДЕНТА
            $response = $this->db_manager->get_students($this->search_query, $this->institutes, $this->courses, $this->choose_from, $this->type_of_sort);

            if ($response->num_rows > 1000) {
                setValidationError('Найдено слишком много студентов. Уточните запрос');
                setOldValue($this->search_query);
                redirect('/');
            }
        }

        $results = [];
        if (mysqli_num_rows($response) > 0) {
            while ($chunk_data = $response->fetch_assoc()) {
                array_push($results, $chunk_data);
            }
            setOldValue($this->search_query);
        } elseif (mysqli_num_rows($response) == 0) {
            setOldValue($this->search_query);
            $results = "NOT FOUND";
        } else {
            setValidationError('Возникла непредвиденная ошибка');
            setOldValue($this->search_query);
            redirect('/archive');
        }

        if ($results != "NOT FOUND") {
            $results = parent::complete_result($results);
        }
        return $results;
    }
}

class Archive extends Handler
{
    private $search_query;
    private $period_from;
    private $period_before;
    private $choose_from;
    private $type_of_sort;

    function __construct($search_query, $period_from, $period_before, $choose_from, $type_of_sort)
    {
        parent::__construct();

        $this->search_query = $search_query;
        $this->period_from = $period_from;
        $this->period_before = $period_before;
        $this->choose_from = $choose_from;
        $this->type_of_sort = $type_of_sort;

        $this->body .= "<br>" .
            "Search query: " . $this->search_query . "<br>" .
            "Period from: " . $this->period_from . "<br>" .
            "Period before: " . $this->period_before . "<br>" .
            "Choose from: " . $this->choose_from . "<br>" .
            "Type of sort: " . $this->type_of_sort;
    }

    function validation()
    {
        removeValidationErrors();
    }

    function get_results()
    {
        $response = $this->db_manager->get_archive_students($this->search_query, $this->period_from, $this->period_before, $this->choose_from, $this->type_of_sort);

        if ($response->num_rows > 1000) {
            setValidationError('Найдено слишком много студентов. Уточните запрос');
            setOldValue($this->search_query);
            redirect('/archive');
        }

        $results = [];
        if (mysqli_num_rows($response) > 0) {
            while ($chunk_data = $response->fetch_assoc()) {
                array_push($results, $chunk_data);
            }
            setOldValue($this->search_query);
        } elseif (mysqli_num_rows($response) == 0) {
            setOldValue($this->search_query);
            $results = "NOT FOUND";
        } else {
            setValidationError('Возникла непредвиденная ошибка');
            setOldValue($this->search_query);
            redirect('/archive');
        }

        if ($results != "NOT FOUND") {
            $results = parent::complete_result($results);
        }
        return $results;
    }
}

class Reports extends Handler
{
    private $period_from;
    private $period_before;

    function __construct($period_from, $period_before)
    {
        parent::__construct();

        $this->period_from = $period_from;
        $this->period_before = $period_before;

        $this->body .= "<br>" .
            "Period from: " . $this->period_from . "<br>" .
            "Period before: " . $this->period_before;
    }

    function validation()
    {
        removeValidationErrors();
    }


    function get_results($period_from, $period_before)
    {
        $results = [];

        require_once __DIR__ . "/../config/config.php";

        $all_reports = array_diff(scandir(__DIR__ . $reports_path), array(".", ".."));

        // differences ВООБЩЕ НЕ НУЖНЫ!!!
        foreach ($all_reports as $index => $report) {
            $period_from_timestamp = DateTimeImmutable::createFromFormat("Y-m-d", $period_from)->getTimestamp();
            $period_before_timestamp = DateTimeImmutable::createFromFormat("Y-m-d", $period_before)->getTimestamp();

            $report_date = explode(".", explode("_", $report)[2])[0];
            $timestamp = DateTimeImmutable::createFromFormat("Y-m-d", $report_date)->getTimestamp();

            if ($period_from_timestamp <= $timestamp || $timestamp <= $period_before_timestamp) {
                $results[$index]['file_report_name'] = $report;
                $results[$index]['report_date'] = explode(".", explode("_", $report)[2])[0];
            }
        }

        // echo "<pre>";
        // var_dump($results);

        return $results;
    }
}
