<?php

//URL guide: /test/:id/debug/:id

$request_uri = preg_replace("/\d/", ":id", $_SERVER['REQUEST_URI']);
$request_uri = preg_replace("/\?.{0,}/","",$request_uri);

switch ($request_uri) {
    case '/':
        require 'views/home.php';
        break;
    case '/inloggen':
        require 'views/authentication/login.php';
        break;
    case '/registreren':
        require 'views/authentication/register.php';
        break;
    case '/emailregistreren':
        require 'views/authentication/registerEmail.php';
        break;
    case '/emailbevestigen':
        require 'views/authentication/emailVerification.php';
        break;
    default:
        require '../views/404.php';
        break;
}