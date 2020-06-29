
<?php require_once("../inc/session.php"); ?>
<?php require_once("../inc/db.php"); ?>
<?php require_once("../inc/functions.php"); ?>
<?php require_once("../inc/validation_function.php"); ?>

<?php $layout_context = "admin"; ?>


<?php
logged_out();
// process the form 
if( isset($_POST["submit"]) ){


    //validation processes
    $required_fields = array( "username", "hased_password");
    validate_presence($required_fields);

    $fields_with_max_lenth = array("username" => 30);
    validate_max_lenth($fields_with_max_lenth);



    if(empty($errors))
    {
        // $_SESSION["errors"] = $errors;
        // redirect_to("new_page.php");
        // }
           // manage type casting and escape form values

    //normally form values
    $username = mysql_prep($_POST["username"]);
   // $id = (int)($_POST["id"]);
    $password = password_encrypt($_POST["hased_password"]);



    $query = " INSERT INTO admins ( ";     
    $query .= " username, hased_password ";
    $query .= " ) VALUES (";
    $query .= " '{$username}' , '{$password}' " ;
    $query .= " )";

    $result = mysqli_query($connection, $query);

                    
    
            // check for query error 
            if($result) 
            { 
            $_SESSION["message"] ="Admin Created ";
            redirect_to("manage_admins.php") ;
            }
            else
            {
                $message=" Admin Creation failed ";
            } 
       // } // end of if(isset($_POST["submit"])
    } 
}
        else
    {
    // disregard any action except sunbmit
    }

?>
     <?php   include("../inc/layout/header.php");  ?>



<div id="main"> 
    <div id="navigation">
    &nbsp;
    </div>

     <div id="page">

<?php 
        if(!empty($message)){
        echo "<div class=\"message\">.$message. </div>" ;
        }
        // second method escaping the php 
        ?>
        <?php echo form_errors($errors); ?>

                    <h2> Create Admin </h2>

<form action="new_admin.php" method="post" >

    <p> Username:
    <input type="text" name="username" value=""> 
    </p>
    <p> Password:
    <input type="password" name="hased_password" value=""> 
    </p>

    <input type="submit"  name="submit" value="Create Admin" >
</form>

<br/>
            <a href="manage_admin.php"> Cancel </a>
    </div>
</div>

<?php
include("../inc/layout/footer.php");