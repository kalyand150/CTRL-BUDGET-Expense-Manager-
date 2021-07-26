<?php

//preincludes
include '../includes/connection.php';

//unset session variables and destroy session
session_unset();
session_destroy();

//redirect to index page
header('location: ..');
?>