<?php

/**
 * Class Controller
 * Base class for all the controllers, not advisable to edit this file...
 */
class Controller
{
    var $m;
    var $viewsFolder = '../views';
    var $messages;

    /**
     * Controller constructor.
     */
    function __construct() {

        //load the session message into a message for the controllers
        $msg = null;
        if (isset($_SESSION['messages']) && is_array($_SESSION['messages']) && count($_SESSION['messages']) > 0)
            $this->messages = $_SESSION['messages'];

        //Set the session messages to null, so the next load the messages is empty
        $_SESSION['messages'] = null;

        /**
         * If a redirect back is used on a POST method, we need to reset the post data from the session post_data.
         */

        if (isset($_SESSION['post_data']))
            $_POST = $_SESSION['post_data'];

        $_SESSION['post_data'] = null;

        //Check the action/ method. If the URL doesnt specify an action, then use default index session
        if (!isset($_REQUEST['action']))
            $action = 'index';
        else
            $action = $_REQUEST['action'];

        //Check if the chosen method exists and execute it, or die the application
        if (method_exists($this, $action)) {
            $this->{$action}();
        } else {
            die('The chosen method, <strong>'.$action.'</strong> does not exist in the controller');
        }
    }

    /**
     * @param $file
     * @param array $vars
     * Show a templated, if there are any messages set a variable to be used in the phtml-file.
     */
    function showTemplate($file, $vars = []) {
        $fileLocations = explode('.', $file);
        $viewFile = $this->viewsFolder;
        foreach ($fileLocations AS $loc) {
            $viewFile .= '/'.$loc;
        }
        $viewFile .= '.phtml';

        foreach ($vars AS $key => $value)
            $$key = $value;

        $messages = $this->messages;

        if (file_exists($viewFile))
            require_once($viewFile);
        else
            die('The chosen view does not exist');
    }
}
