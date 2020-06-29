<?php require_once("../inc/session.php"); ?>
<?php require_once("../inc/db.php"); ?>
<?php require_once("../inc/functions.php"); ?>
<?php $layout_context = "admin"; ?>

<?php  find_selected_page(); ?>

<?php require_once("../inc/validation_function.php"); ?>

<?php 
if (!$current_subject)
{
    redirect_to("manage_content.php");
}
?>

<?php
if(isset($_POST["submit"]))
{
// process the form

//validation processes
$required_fields = array("menu_name", "position", "visible");
validate_presence($required_fields);

$fields_with_max_lenth = array("menu_name"=> 30);
validate_max_lenth($fields_with_max_lenth);

if(empty($errors))
{

//normally form values
$id = $current_subject["id"];
$menu_name = mysql_prep($_POST["menu_name"]);
$position = (int) $_POST["position"];
$visible = (int) $_POST["visible"];


// perform a query on the database 
$query = "UPDATE subjects SET ";
$query .= "menu_name = '{$menu_name}', " ;
$query .= "position = {$position}, ";
$query .= "visible = {$visible} ";
$query .= " WHERE id = {$id} ";
$query .= "LIMIT 1";

$result = mysqli_query($connection, $query);
// check for query error 
if($result && mysqli_affected_rows($connection) == 1) 
{ 
  $_SESSION["message"] ="Subject Updated";
  redirect_to("manage_content.php") ;
    }
    else
    {
    $message="Subject Update failed";
} 
  }
    }
  else 
  {
// was a get request
}

?>

<?php include("../inc/layout/header.php"); ?>



<div id="main">
    <div id="navigation"> 

 <?php   echo navigation($current_subject, $current_page ); ?>

</div>

<div id="page">

 <?php 
 if(!empty($message)){
    echo "<div class=\"message\">.$message. </div>" ;
 }
// second method escaping the php 
 ?>


     <?php echo form_errors($errors); ?>

    <h2> Edit Subject </h2>

    <form action="edit_subject.php?subject=<?php echo $current_subject["id"]; ?>" method="post" >

        <p> menu name: 
            <input type="text" name="menu_name" Value="<?php echo $current_subject["menu_name"]; ?> ">
        </p>

        <p> Position:
           <select name="position">
           <?php
           $subject_set = find_subject(false);
           $subject_count = mysqli_num_rows($subject_set);

        for($count =1; $count <= $subject_count  ; $count++)
        { echo "<option value=\"{$count}\" ";
        if ($current_subject["position"] == $count){
            echo "selected" ;
        }
                echo ">{$count} </option>";  }
        ?>
            </select>
        </p>
        <p> Visible:
        <input type="radio" name="visible" value="0" <?php if($current_subject["visible"] == 0){ echo "checked";} ?> > no
        &nbsp;
        <input type="radio" name="visible" value="1" <?php if($current_subject["visible"] == 1){ echo "checked";} ?>> yes
        </p>
        <input type="submit"  name="submit" value="Edit Subject" >
    </form>
<br />
    <a href="manage_content.php"> Cancel </a>
    &nbsp;
    &nbsp;
    <a href="delete_subject.php?subject=<?php echo $current_subject["id"]; ?> " onclick = "return confirm('are you sure ?')">- Delete Subject </a>

</div>
    </div>



<?php include("../inc/layout/footer.php"); ?>