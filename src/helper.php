<?php

if (isset($_COOKIE['PHPSESSID'])) {
    session_id($_COOKIE['PHPSESSID']);
    session_start();
//    echo "old session" . "<br>";
} else {
    session_id(uniqid());
    session_start();
//    echo "new session" . "<br>";
}

//echo "PHPSESSID ->" . $_COOKIE["PHPSESSID"] . "<br>";
//var_dump(session_id());
//echo "<pre>";
//print_r($_SESSION);
//echo "</pre>";
//echo "<br>"."^END HELPERS FILE^";
//echo "<br><br>";

function redirect($path)
{
    header("Location: $path");
    die();
}

function removeValidationErrors()
{
    unset($_SESSION['validation']);
}

function setValidationError($message)
{
    $_SESSION['validation'] = $message;
}

function getValidationErrorMessage()
{
    return $_SESSION['validation'];
}

function setOldValue($value)
{
    $_SESSION['old'] = $value;
}

function getOldValue()
{
    $value = $_SESSION['old'];
    unset($_SESSION['old']);
    return $value;
}