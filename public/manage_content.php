
<?php require_once("../inc/session.php"); ?>
<?php
require_once("../inc/db.php");
require_once("../inc/functions.php");
$layout_context = "admin";
include("../inc/layout/header.php");
?>

<?php
find_selected_page();

?>

<div id="main"> 
    <div id="navigation">
    <br/>
    <a href="admin.php">&laquo; Admin page</a>
     <?php   echo navigation($current_subject, $current_page); ?>
     <br/>
     <a href="new_subject.php">+ Add a subject</a>
    </div>


    <div id="page">
    <?php echo message(); ?> <br/>

    <?php $subject_id = $current_subject['id']; ?>

        <?php 
        if ($current_subject)
        {
        ?>
        <h2>Manage Subject</h2>
            Menu Name: <?php echo htmlentities($current_subject["menu_name"]); ?> </br> 
            Position: <?php echo $current_subject["position"]; ?> </br> 
            Visible: <?php echo $current_subject["visible"]  == 1 ? 'yes' : 'no'; ?> </br> 
        </br>
       <a href="edit_subject.php?subject= <?php echo urlencode($current_subject["id"]); ?> "> - Edit Subject </a>

<hr/>
<h2>Pages per subject</h2>
    <?php $pages_set= find_page_perSubject($current_subject["id"], false); ?>
<ul class="subjects">
   
        <?php while($page = mysqli_fetch_assoc($pages_set)){  ?> 
        <a href="manage_content.php?page=<?php echo $page["id"]; ?>"> <?php echo  "<li>".$page["menu_name"]. "</li>"; ?> </a>

    <?php } ?>
</ul>

<a href="new_page.php?subject=<?php echo $current_subject['id']; ?>"> +Add a New Page to this subject</a>

        <?php  
        }elseif($current_page)
        {
        ?>
        <h2>Manage Page</h2>
        Menu Name: <?php echo htmlentities($current_page["menu_name"]); ?> </br>
        Position: <?php echo $current_page["position"]; ?> </br> 
        Visible: <?php echo $current_page["visible"]  == 1 ? 'yes' : 'no'; ?> </br> 

        Content: <br/>
        <div class="view-content">
       <?php echo htmlentities($current_page["content"]); ?> </br> 
       </div>
        
       </br>
       <a href="edit_page.php?page=<?php echo urlencode($current_page["id"]); ?> "> - Edit Page </a> <br/>

        <?php 
        } else 
        {
            echo "Please select a subject or a page";
        }
        ?>


        </li>
    </div>
</div>

<?php include("../inc/layout/footer.php"); ?>