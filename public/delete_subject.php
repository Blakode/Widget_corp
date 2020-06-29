<?php require_once("../inc/session.php"); ?>
<?php require_once("../inc/db.php"); ?>
<?php require_once("../inc/functions.php"); ?>

<?php
$current_subject = find_subject_by_id($_GET["subject"], false);

if (!$current_subject)
{
    // subject ID was missin or invalid  
    // subject couldn't be found in database 
    redirect_to("manage_content.php");
}

$page_set = find_page_perSubject($current_subject["id"]);
if (mysqli_num_rows($page_set) > 0)
{
    $_SESSION["message"] ="Can't delete a subject with pages";
    redirect_to("manage_content.php?subject={$current_subject["id"]}") ;
}

$id = $current_subject["id"];
$query = "DELETE FROM subjects WHERE id = {$id} LIMIT 1";


$result = mysqli_query($connection, $query);
// check for query error 

if($result && mysqli_affected_rows($connection) == 1) 
{ 
  $_SESSION["message"] ="Subject Deleted";
  redirect_to("manage_content.php") ;
    }
     else
{
    $_SESSION["message"] ="Subject Delete failed";
    redirect_to("manage_content.php?subject={$id}") ;
} 