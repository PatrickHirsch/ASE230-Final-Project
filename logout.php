<?php
//This page handles log out. May not be needed any more as a function was created to handle the logout button.
session_start();
session_destroy();
header("Location: index.php");
?>