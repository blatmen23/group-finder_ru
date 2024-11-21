<?php

class DatabaseManager
{
    protected $hostname;
    protected $username;
    protected $password;
    protected $database;
    protected $db;

    public function __construct($hostname, $username, $password, $database)
    {
        $this->hostname = $hostname;
        $this->username = $username;
        $this->password = $password;
        $this->database = $database;
    }

    public function connect_db()
    {
        $this->db = new mysqli($this->hostname, $this->username, $this->password, $this->database);

        if (!$this->db) {
            die('Error connect to DataBase');
        } else {
            // echo "Successful connect to Data Base";
        }
    }

    public function get_all_groups()
    {
        $groups_response = mysqli_fetch_all($this->db->query("SELECT DISTINCT group_ FROM groups_;"));

        $all_groups = [];
        foreach ($groups_response as $value) {
            array_push($all_groups, $value[0]);
        }

        return $all_groups;
    }

    public function get_group($search_query, $institutes, $courses, $choose_from)
    {
        $sql_query = "SELECT * FROM students JOIN groups_ ON student_group = group_id JOIN institutes ON groups_.institute = institutes.institute_id WHERE group_ LIKE '%" . $search_query . "%' AND institute_num IN " . $institutes . " AND course IN " .  $courses . "ORDER BY student " . $choose_from . ";";

        return $this->db->query($sql_query);
    }

    public function get_students($search_query, $institutes, $courses, $choose_from, $type_of_sort)
    {
        $sql_query = "SELECT * FROM students JOIN groups_ ON student_group = group_id JOIN institutes ON groups_.institute = institutes.institute_id WHERE student LIKE '%" . $search_query . "%' AND institute_num IN " . $institutes . " AND course IN " .  $courses . "ORDER BY " . $type_of_sort . " " . $choose_from . ";";

        return $this->db->query($sql_query);
    }

    public function get_quantity_archive_records()
    {
        return $this->db->query("SELECT COUNT(record_date) as quantity FROM students_archive;")->fetch_row()[0];
    }

    public function get_archive_table_create_date($date_format)
    {
        $date = $this->db->query("SELECT record_date FROM students_archive ORDER BY record_date ASC LIMIT 1;")->fetch_row()[0];

        if (is_null($date)) {
            $date = $this->db->query("SELECT CAST(CREATE_TIME AS DATE) FROM information_schema.TABLES WHERE TABLE_SCHEMA = '{$this->database}' AND TABLE_NAME = 'students_archive';")->fetch_row()[0];
        }

        $timestamp = DateTimeImmutable::createFromFormat('Y-m-d', $date)->getTimestamp();

        return date($date_format, $timestamp);
    }


    public function get_archive_students($search_query, $period_from, $period_before, $choose_from, $type_of_sort)
    {
        $sql_query = "SELECT * FROM students_archive WHERE student LIKE '%{$search_query}%' AND record_date BETWEEN '{$period_from}' AND '{$period_before}' ORDER BY {$type_of_sort} {$choose_from};";

        return $this->db->query($sql_query);
    }

    public function get_quantity_report_records()
    {
        return $this->db->query("SELECT COUNT(report_date) as quantity FROM reports_archive;")->fetch_row()[0];
    }

    public function get_report_table_create_date($date_format)
    {
        $date = $this->db->query("SELECT report_date FROM reports_archive ORDER BY report_date ASC LIMIT 1;")->fetch_row()[0];

        if (is_null($date)) {
            $date = $this->db->query("SELECT CAST(CREATE_TIME AS DATE) FROM information_schema.TABLES WHERE TABLE_SCHEMA = '{$this->database}' AND TABLE_NAME = 'reports_archive';")->fetch_row()[0];
        }

        $timestamp = DateTimeImmutable::createFromFormat('Y-m-d', $date)->getTimestamp();

        return date($date_format, $timestamp);
    }

    public function get_reports($period_from, $period_before, $choose_from, $type_of_sort)
    {
        $sql_query = "SELECT * FROM reports_archive WHERE report_date BETWEEN '{$period_from}' AND '{$period_before}' ORDER BY {$type_of_sort} {$choose_from};";

        return $this->db->query($sql_query);
    }

    public function get_report($report_id)
    {
        $sql_query = "SELECT * FROM reports_archive WHERE report_id = {$report_id};";

        return $this->db->query($sql_query)->fetch_assoc();
    }
}