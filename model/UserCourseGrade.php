<?php

require_once ('Model.php');
require_once('User.php');
require_once('Course.php');

class UserCourseGrade extends Model
{
    static $table = 'user_course_grades';

    /**
     * Class constructor
     */
    function __construct() {
        parent::__construct(static::$table);
    }

    public function user() {
        return $this->belongsTo('User', 'id', 'user_id');
    }

    public function course() {
        return $this->belongsTo('Course', 'id', 'course_id');
    }
}