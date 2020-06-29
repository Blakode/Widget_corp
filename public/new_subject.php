<?php require_once("../inc/session.php"); ?>
<?php require_once("../inc/db.php"); ?>
<?php require_once("../inc/functions.php"); ?>
<?php $layout_context = "admin"; ?>
<?php include("../inc/layout/header.php"); ?>

<?php  find_selected_page(); ?>

<div id="main">
    <div id="navigation"> 

 <?php   echo navigation($current_subject , $current_page ); ?>

</div>

<div id="page">
     <?php echo message(); ?>
     <?php $errors = errors(); ?>
     <?php echo form_errors($errors); ?>

    <h2> Create Subject </h2>

    <form action="create_subject.php" method="post" >

        <p> menu name:
            <input type="text" name="menu_name" Value="">
        </p>

        <p> Position:
           <select name="position">
           <?php
           $subject_set = find_subject(false);
           $subject_count = mysqli_num_rows($subject_set);

        for($count =1; $count <= ($subject_count + 1) ; $count++)
        { echo "<option value=\"{$count}\" >{$count} </option>";  }
        ?>
            </select>
        </p>
        <p> Visible:
        <input type="radio" name="visible" value="0"> no
        &nbsp;
        <input type="radio" name="visible" value="1"> yes
        </p>
        <input type="submit"  name="submit" value="Create Subject" >
    </form>
<br />
    <a href="manage_content.php"> Cancel </a>


</div>
    </div>



<?php include("../inc/layout/footer.php"); ?>