<?php
/**
 * File with helper functions to make my life easier :-D
 */

/**
 * Store a session message to be shown in a next page/ session load
 * @param $message
 */
function StoreMessage($message) {
    $key = $message[0];
    $msg = $message[1];

    $_SESSION['messages'][$key] = $msg;
}

/**
 * @param $post_var
 * @param $data
 * @return mixed
 */
function Old($post_var, $data) {
    if (isset($_POST[$post_var]))
        return $_POST[$post_var];
    else
        return $data;
}

/**
 * @param $url
 * @param bool $permanent
 */
function Redirect($url, $permanent = false)
{
    header('Location: ' . $url, true, $permanent ? 301 : 302);
    exit();
}

/**
 * Go back to the previous page, keep post-data (if method is post) store it in session
 * @param $url
 */
function Back() {
    if ($_SERVER['REQUEST_METHOD'] !== 'GET')
        $_SESSION['post_data'] = $_POST;

    $url = $_SERVER['HTTP_REFERER'];

    Redirect($url, false);
}

