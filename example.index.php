<?php
/**
 * Example
 */
require_once __DIR__.'/SSO.php';

if (isset($_REQUEST['do']) && $_REQUEST['do'] == 'login') {
    // Authenticate the user
    SSO::authenticate();
}

$cookies = null;
$user = null;
$showLogout = null;
$showLogin = '<a href="?do=login">Login</a>';
if (SSO::checkAuth()) {
    $user = SSO::getUser();
    $showLogout = '<a href="?do=logout">Logout</a>';
    $showLogin = null;
    $ticket = $_COOKIE['PHPSESSID'];
    $cookies = $_COOKIE['CAS_APP_SERVER'];// config properties => cas.tgc.name=CAS_APP_SERVER
}

if (isset($_REQUEST['do']) && $_REQUEST['do'] == 'logout') {
    SSO::logout();
}

// check cookies server sso already login or not
if (isset($cookies)) {
    echo <<<HTML
        welcome <b>{$user}</b>!!
        {$showLogin}
        {$showLogout}
        <br>
        ticket: {$ticket}
HTML;
}
