<?php require_once("../inc/session.php"); ?>
<?php require_once("../inc/db.php"); ?>
<?php require_once("../inc/functions.php"); ?>
<?php require_once("../inc/validation_function.php"); ?>

<?php
logged_out();
if(isset($_POST["submit"]))
{
// process the form
//normally form values
$menu_name = mysql_prep($_POST["menu_name"]);
$position = (int) $_POST["position"];
$visible = (int) $_POST["visible"];

//validation processes
$required_fields = array("menu_name", "position", "visible");
validate_presence($required_fields);

$fields_with_max_lenth = array("menu_name "=> 30);
validate_max_lenth($fields_with_max_lenth);

if(!empty($errors))
{
  $_SESSION["errors"] = $errors;
  redirect_to("new_subject.php");
}

// perform a query on the database 
$query = "INSERT INTO subjects (";
$query .= "menu_name, position, visible";
$query .= ")VALUES (";
$query .= " '{$menu_name}', {$position}, {$visible} " ;
$query .= ")";
$result = mysqli_query($connection, $query);


// check for query error 
if($result) 
{ 
  $_SESSION["message"] ="Subject Created ";
  redirect_to("manage_content.php") ;
    }
    else
    {
  $_SESSION["message"]="Subject creation failed";
   redirect_to("new_subject.php");
 } 
  }
  else 
  {
// was a get request
    redirect_to("new_subject.php");
}


?>
<?php
if(isset($connection))
{mysqli_close($connection);}