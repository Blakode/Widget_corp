
<?php require_once("../inc/session.php"); ?>
<?php require_once("../inc/db.php"); ?>
<?php require_once("../inc/functions.php"); ?>
<?php require_once("../inc/validation_function.php"); ?>

<?php $layout_context = "admin"; ?>



<?php
$username = "";
// default


// process the form 
if( isset($_POST["submit"]) ){


    //validation processes
    $required_fields = array( "username", "password");
    validate_presence($required_fields);

    if(empty($errors))
    {

    //normally form values
    $username = $_POST["username"];
    $password = $_POST["password"];

    $found_admin = attempt_login($username, $password);

  // check for query error 
            if($found_admin) 
            { 
           // login sucess 
            $_SESSION["admin_id"] = $found_admin["id"];
            $_SESSION["username"] = $found_admin["username"];
            redirect_to("admin.php") ;
             }
            else
            {
                $message = "Username/Password not found, Login Failed ";
                
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

                    <h2> Admin  Login</h2>

<form action="login.php" method="post" >

    <p> Username:
    <input type="text" name="username" value="<?php echo htmlentities($username) ; ?> ">    
    </p>

    <p> Password:
    <input type="password" name="password" value=""> 
    </p>

    <input type="submit"  name="submit" value="Login" >
</form>
    </div>
</div>

<?php
include("../inc/layout/footer.php");