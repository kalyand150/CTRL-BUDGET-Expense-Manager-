<?php

//check if user has logged in with session variable
if (isset($_SESSION['email'])) {
    $loggedin = true;
} else {
    $loggedin = false;
}

?>