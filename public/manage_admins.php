<?php 
require_once("../inc/session.php"); 
require_once("../inc/db.php"); 
require_once("../inc/functions.php");
 require_once("../inc/validation_function.php"); 
$layout_context = "admin";


$admin_set = find_admin();
logged_out();
?>




<?php include("../inc/layout/header.php"); ?>
<div id="main"> 
    <div id="navigation">
    <br/>
    <a href="admin.php">&laquo; Main Menu</a>
    &nbsp;
    </div>

    <div id="page">
    <?php echo message(); ?> <br/>


    <h2> Manage Admins </h2>
    <p> Welcome to the admin area, <?php if ($_SESSION["username"] != ""){ echo $_SESSION["username"]; } ?> </p>
 <br/>
    <ul class= "subjects">
         <pre>USERNAME            ACTION </pre>
        <pre><?php while($admin = mysqli_fetch_assoc($admin_set)){  ?>  <?php echo"<li>".htmlentities($admin["username"]);?> </pre>            <pre>  <a href="edit_admin.php?id=<?php echo urlencode($admin["id"]); ?> ">Edit</a> <a href="delete_admin.php?id=<?php echo urlencode($admin["id"]); ?> " onclick = "return confirm('are you sure ?')">Delete</a></li> </pre>
        </ul>

<?php } ?>
</ul>
  
  
         
  

<br/><hr/>
<a href="new_admin.php?id="> +Add New Admin </a>

    </div>
</div>

<?php
include("../inc/layout/footer.php");