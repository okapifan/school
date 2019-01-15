<?php

require_once ('Model.php');

class Course extends Model
{
    static $table = 'courses';

    /**
     * Class constructor
     */
    function __construct() {
        parent::__construct(static::$table);
    }
}