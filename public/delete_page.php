<?php require_once("../inc/session.php"); ?>
<?php require_once("../inc/db.php"); ?>
<?php require_once("../inc/functions.php"); ?>

<?php
$current_page = find_page_by_id($_GET["page"], false);

if (!$current_page)
{
    // subject ID was missin or invalid  
    // subject couldn't be found in database 
    redirect_to("manage_content.php");
}


$id = $current_page["id"];
$query = "DELETE FROM pages WHERE id = {$id} LIMIT 1";

$result = mysqli_query($connection, $query);
// check for query error 

if($result && mysqli_affected_rows($connection) == 1) 
{ 
  $_SESSION["message"] ="Page Deleted";
  redirect_to("manage_content.php") ;
    }
     else
{
    $_SESSION["message"] ="Page Delete failed";
    redirect_to("manage_content.php?page={$id}") ;
} 