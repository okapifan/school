<?php

require_once('../lib/Database.php');

/**
 * Class Model
 * Basic usage, extend this file to any database-table/ model
 */
class Model
{
    static $DB;
    static $table;

    function __construct($table) {
        $this->setTable($table);
        $this->setDB(new Database());
    }

    function setTable($table) {
        static::$table = $table;
        return;
    }

    function setDB($DB) {
        static::$DB = $DB;
        return;
    }

    static protected function getTable() {
        return static::$table;
    }

    static protected function getDB() {
        return static::$DB;
    }

    public function className() {
        return get_class($this);
    }

    public function save() {
        if (empty($this->id)) {
            $this->saveNew();
        } else {
            $id = $this->id;
            $this->saveExisting($id);
        }
    }

    public function saveExisting($id) {
        $where = " WHERE id = ".$id;
        $updateQry = "id = $id";

        $modelColumns = $this->getAllColumnInformation();
        foreach ($modelColumns AS $column) {
            $c = $column[0];
            if ($c != 'id') {
                $cols[] = $c;
                if (strpos(strtolower($column[1]), 'int') !== false) {
                    $updateQry .= ", " . $c . " = " . $this->$c;
                } else {
                    $updateQry .= ", " . $c . " = '" . $this->getDB()->escapeString($this->$c) . "'";
                }
            }
        }

        $qry = "UPDATE ".$this->getTable()." SET ".$updateQry.$where;
        $this->getDB()->query($qry);

        return true;
    }

    public function saveNew() {
        $modelColumns = $this->getAllColumnInformation();
        $cols = [];
        $values = [];
        foreach ($modelColumns AS $column) {
            $c = $column[0];
            if ($c != 'id') {
                $cols[] = $c;
                if (strpos(strtolower($column[1]), 'int') !== false) {
                    $values[] = $this->$c;
                } else {
                    $value = static::$DB->escapeString($this->$c);
                    $values[] = "'$value'";
                }
            }
        }

        $qry = "INSERT INTO ".$this->getTable()." (".implode(',', $cols).") VALUES (".implode(',', $values).");";

        static::$DB->query($qry);
        return $this->getDB()->lastInsertedID();
    }

    public static function all() {
        $model = static::childClass();
        $db = new Database();
        $allData = $db->query('SELECT id FROM '.static::$table)->fetch_all();
        $retData = [];
        foreach ($allData AS $obj)
            $retData[] = $model::find($obj[0]);

        return $retData;
    }

    public static function find($id) {
        $obj = static::childClass();
        $model = new $obj(static::getTable());

        $keys = $model->getColumns();
        $cols = [];
        foreach ($keys AS $k)
            $cols[] = $k;

        $theUser = static::$DB->query('SELECT * FROM '.static::$table.' WHERE id = '.$id)->fetch_row();

        foreach ($cols AS $key => $value)
            $model->$value = $theUser[$key];

        return $model;
    }

    public static function whereOne($array) {
        $obj = static::where($array);
        if (!empty($obj))
            return $obj[0];

        return null;
    }

    public static function where($array) {
        $model = static::childClass();
        $where = ' WHERE 1 = 1';
        foreach ($array AS $a)
            $where .= " AND $a[0] $a[1] $a[2]";

        $db = new Database();
        $qry = "SELECT id FROM ".static::$table.$where;
        $allData = $db->query($qry)->fetch_all();

        $retData = [];
        foreach ($allData AS $obj)
            $retData[] = $model::find($obj[0]);

        return $retData;
    }

    public static function getAllColumnInformation() {
        $db = new Database();
        $cols = $db->query("SHOW columns FROM ".static::$table.";")->fetch_all();
        $retData = [];
        foreach ($cols AS $c)
            $retData[] = $c;

        return $retData;
    }

    public static function getColumns() {
        $db = new Database();
        $cols = $db->query("SHOW columns FROM ".static::$table.";")->fetch_all();
        $retData = [];
        foreach ($cols AS $c)
            $retData[] = $c[0];

        return $retData;
    }

    public static function childClass() {
        return get_called_class();
    }

    public function hasOne($model, $primary_key, $foreign_key) {
        return $model::whereOne([[$foreign_key,'=', $this->$primary_key]]);
    }

    public function BelongsTo($model, $primary_key, $foreign_key) {
        return $model::whereOne([[$primary_key, '=', $this->$foreign_key]]);
    }

    public function hasMany($model, $primary_key, $foreign_key) {
        return $model::where([[$foreign_key,'=', $this->$primary_key]]);
    }
}