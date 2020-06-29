<?php require_once("../inc/session.php"); ?>
<?php require_once("../inc/db.php"); ?>
<?php require_once("../inc/functions.php"); ?>

<?php
$admin = find_admin_by_id($_GET["id"]);

if (!$admin)
{
    // subject ID was missin or invalid  
    // subject couldn't be found in database 
    redirect_to("manage_content.php");
}


$id = $admin["id"];
$query = "DELETE FROM admins WHERE id = {$id} LIMIT 1 ";

$result = mysqli_query($connection, $query);
// check for query error 

if($result && mysqli_affected_rows($connection) == 1) 
{ 
  $_SESSION["message"] ="admin Deleted";
  redirect_to("manage_admins.php") ;
    }
     else
{
    $_SESSION["message"] ="Admin Delete failed";
    redirect_to("edit_admins.php?id={$id}") ;
} 