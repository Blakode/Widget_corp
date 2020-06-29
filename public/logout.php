<?php require_once("../inc/session.php"); ?>
<?php require_once("../inc/functions.php"); ?>

<?php

$_SESSION["admin_id"] = null;
$_SESSION["username"] = null;
redirect_to("login.php");

