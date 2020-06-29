<?php
require_once("../inc/session.php"); 
require_once("../inc/functions.php");
$layout_context = "admin";
include("../inc/layout/header.php");
logged_out()
?>

<div id="main"> 
    <div id="navigation">
    &nbsp;
    </div>

    <div id="page">
        <h2>Admin Menu</h2>
    <p>Welcome to the admin area <?php echo $_SESSION["username"];  ?></p>
        <ul>
        <li><a href="manage_content.php">Manage Website content</a></li>
        <li><a href="manage_admins.php">Manage admin user</a></li>
        <li><a href="logout.php">Logout</a></li>
        </ul>
    </div>
</div>

<?php
include("../inc/layout/footer.php");