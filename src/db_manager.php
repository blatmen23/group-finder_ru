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
        $groups_response = mysqli_fetch_all($this->db->query("SELECT DISTINCT group_name FROM StudentGroups;"));

        $all_groups = [];
        foreach ($groups_response as $value) {
            array_push($all_groups, $value[0]);
        }

        return $all_groups;
    }

    public function get_group($search_query, $institutes, $courses, $choose_from)
    {
        $sql_query = "SELECT * FROM Students JOIN StudentGroups ON student_group = group_id JOIN Institutes ON institute = institute_id JOIN Courses ON course = course_id WHERE group_name LIKE '%" . $search_query . "%' AND institute_num IN " . $institutes . " AND course_name IN " .  $courses . "ORDER BY student_name " . $choose_from . ";";

        return $this->db->query($sql_query);
    }

    public function get_students($search_query, $institutes, $courses, $choose_from, $type_of_sort)
    {
        $sql_query = "SELECT * FROM Students JOIN StudentGroups ON student_group = group_id JOIN Institutes ON institute = institute_id JOIN Courses ON course = course_id WHERE student_name LIKE '%" . $search_query . "%' AND institute_num IN " . $institutes . " AND course_name IN " .  $courses . "ORDER BY " . $type_of_sort . " " . $choose_from . ";";

        return $this->db->query($sql_query);
    }

    public function get_quantity_records()
    {
        return $this->db->query("SELECT COUNT(record_time) as quantity FROM StudentArchive;")->fetch_row()[0];
    }

    public function get_archive_table_create_date($datetime_format)
    {
        $datetime = $this->db->query("SELECT CREATE_TIME FROM information_schema.TABLES WHERE TABLE_SCHEMA = 's_parser' AND TABLE_NAME = 'StudentArchive';")->fetch_row()[0];
        $timestamp = DateTimeImmutable::createFromFormat('Y-m-d H:i:s', $datetime)->getTimestamp();

        return date($datetime_format, $timestamp);
    }


    public function get_archive_students($search_query, $period_from, $period_before, $choose_from, $type_of_sort)
    {
        $sql_query = "SELECT * FROM StudentArchive WHERE student_name LIKE '%{$search_query}%' AND CAST(record_time AS DATE) BETWEEN '{$period_from}' AND '{$period_before}' ORDER BY {$type_of_sort} {$choose_from};";

        return $this->db->query($sql_query);
    }
}
