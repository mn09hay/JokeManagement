<?php
include_once $_SERVER['DOCUMENT_ROOT'] . 
        'letsjoke1/includes/magicquotes.inc.php';

require_once $_SERVER['DOCUMENT_ROOT'] . 'letsjoke1/includes/access.inc.php';

if (!userIsLoggedIn())
{
    include './login.html.php';
    exit();
}

