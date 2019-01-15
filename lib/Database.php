<?php

require_once( 'DatabaseSettings.php' );

/**
 * Class Database
 * connection to the database and basic usage
 * Best not to touch this file
 */
class Database extends DatabaseSettings
{
    var $classQuery;
    var $link;

    var $errno = '';
    var $error = '';

    /**
     * Database constructor.
     */
    function __construct()
    {
        // Load settings from parent class
        $settings = DatabaseSettings::getSettings();

        // Get the main settings from the array we just loaded
        $host = $settings['dbhost'];
        $name = $settings['dbname'];
        $user = $settings['dbusername'];
        $pass = $settings['dbpassword'];

        // Connect to the database
        $this->link = new mysqli( $host , $user , $pass , $name );

        //Set the charset...
        mysqli_set_charset($this->link, 'utf8mb4');
    }

    /**
     * Database destructor
     */
    function __destruct() {
        $this->close();
    }

    // Executes a database query
    function query( $query )
    {
        $this->classQuery = $query;
        $value = $this->link->query( $query );

        return $value;
    }

    //Escape data
    function escapeString( $query )
    {
        return $this->link->escape_string( $query );
    }

    // Get the data return int result
    function numRows( $result )
    {
        return $result->num_rows;
    }

    //Get the last inserted ID
    function lastInsertedID()
    {
        return $this->link->insert_id;
    }

    // Get query using assoc method
    function fetchAssoc( $result )
    {
        return $result->fetch_assoc();
    }

    // Gets array of query results
    function fetchArray( $result , $resultType = MYSQLI_ASSOC )
    {
        return $result->fetch_array( $resultType );
    }

    // Fetches all result rows as an associative array, a numeric array, or both
    function fetchAll( $result , $resultType = MYSQLI_ASSOC )
    {
        return $result->fetch_all( $resultType );
    }

    // Get a result row as an enumerated array
    function fetchRow( $result )
    {
        return $result->fetch_row();
    }

    // Free all MySQL result memory
    function freeResult( $result )
    {
        $this->link->free_result( $result );
    }

    //Closes the database connection
    function close()
    {
        $this->link->close();
    }

    //Return the current error number and message
    function sql_error()
    {
        if( empty( $error ) )
        {
            $errno = $this->link->errno;
            $error = $this->link->error;
        }

        return $errno . ' : ' . $error;
    }
}