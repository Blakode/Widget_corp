
<?php require_once("../inc/session.php"); ?>

<?php
require_once("../inc/db.php");
require_once("../inc/functions.php");
$layout_context = "public";

include("../inc/layout/header.php");
?>

<?php
find_selected_page(true);

?>

<div id="main"> 
    <div id="navigation">
    <br/>
     <?php   echo index_navigation($current_subject, $current_page); ?>
     <br/>
    </div>


    <div id="page">
    <?php echo message(); ?> <br/>

    <?php $subject_id = $current_subject['id']; ?>

        <?php 
        if($current_page)
        {
        ?>
     <h2> <?php echo htmlentities($current_page["menu_name"]); ?></h2> </br> 
       
        <div class="view-content">
       
       <?php echo nl2br(htmlentities($current_page["content"])); ?> </br> 
       </div>
       </br>

        <?php 
        } else 
        {
            echo "Welcome !!!";
        }
        ?>

    </div>
</div>

<?php include("../inc/layout/footer.php"); ?>