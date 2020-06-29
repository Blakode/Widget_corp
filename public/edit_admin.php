<?php require_once("../inc/session.php"); ?>
<?php require_once("../inc/db.php"); ?>
<?php require_once("../inc/functions.php"); ?>
<?php require_once("../inc/validation_function.php"); ?>

<?php $layout_context = "admin"; ?>

<?php 
    logged_out();
    find_selected_admin();
//find_admin();


$admin = find_admin_by_id($current_admin["id"])
?>
<?php 
if (!$current_admin)
{    redirect_to("manage_admins.php"); } 

?>



    <?php 
    // process the form 

    if(isset($_POST["submit"]))
    {
    // process the form

    //validation processes
    $required_fields = array("username", "hased_password");
    validate_presence($required_fields);

    $fields_with_max_lenth = array("username" => 15);
    validate_max_lenth($fields_with_max_lenth);


    if(empty($errors))
    {

    //normally form values
    $id = $current_admin["id"];
    $username = mysql_prep($_POST["username"]);
    $hased_password = password_encrypt($_POST["hased_password"]);


    // perform a query on the database 
    $query = " UPDATE admins SET ";
    $query .= " username = '{$username}', " ;
    $query .= " hased_password = '{$hased_password}' ";
    $query .= " WHERE id = {$id} ";
    $query .= " LIMIT 1" ;

    $result = mysqli_query($connection, $query);
    // check for query error 
    if($result && mysqli_affected_rows($connection) == 1) 
    { 
    $_SESSION["message"] = "Admin Updated ";
    redirect_to("manage_admins.php") ;
    }
    else
    {
    $message=" Adnin Update failed ";
     } 
    }
    }
    else 
    {
    // was a get request
    }

    ?>
<?php   include("../inc/layout/header.php");  ?>






<div id="main"> 
    <div id="navigation">
             &nbsp;
    </div>

     <div id="page">

<h2> Edit Admin </h2>

<form action="edit_admin.php?id=<?php echo $admin['id']; ?>" method="post" >

    <p> Username:
    <input type="text" name="username" value="<?php echo $admin["username"]; ?>"> 
    </p>
  
    <p> Password:
    <input type="password" name="hased_password" value=""> 
    </p>


    <input type="submit"  name="submit" value="Edit Admin" >
</form>

<br/>
    <a href="manage_admins.php"> Cancel </a>
    </div>
</div>

<?php
include("../inc/layout/footer.php");


