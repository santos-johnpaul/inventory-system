<?php
session_start();
session_unset();
session_destroy();
header("refresh:.1;url=../index.php"); // Redirect after .1 millisecond
exit();
?>
