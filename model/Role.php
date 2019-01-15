<?php

require_once ('Model.php');
require_once('User.php');

class Role extends Model
{
    static $table = 'roles';

    /**
     * Class constructor
     */
    function __construct() {
        parent::__construct(static::$table);
    }

    public function user() {
        return $this->hasMany('User', 'id', 'user_id');
    }
}