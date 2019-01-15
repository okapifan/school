<?php

require_once ('Model.php');
require_once('Education.php');

class UserEducation extends Model
{
    static $table = 'user_educations';

    /**
     * Class constructor
     */
    function __construct() {
        parent::__construct(static::$table);
    }

    function users() {
        return $this->belongsTo('User', 'id', 'user_id');
    }

    function educations() {
        return $this->belongsTo('Education', 'id', 'education_id');
    }
}