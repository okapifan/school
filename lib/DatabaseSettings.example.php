<?php

/**
 * Class DatabaseSettings basic class to store mysql-settings.
 */
class DatabaseSettings
{
    var $settings;

    /**
     * @return array
     */
    function getSettings()
    {
        $settings = [];
        // Database variables
        // Host name
        $settings['dbhost'] = 'localhost';
        // Database name
        $settings['dbname'] = 'database-name';
        // Username
        $settings['dbusername'] = 'username';
        // Password
        $settings['dbpassword'] = 'password';

        return $settings;
    }
}