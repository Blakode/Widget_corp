<?php require_once("../inc/session.php"); ?>
<?php require_once("../inc/db.php"); ?>
<?php require_once("../inc/functions.php"); ?>
<?php require_once("../inc/validation_function.php"); ?>

<?php $layout_context = "admin"; ?>

<?php  find_selected_page(); ?>

<?php $page_set = find_page_perSubject($current_page["subject_id"], false); ?>


        


<?php 
if (!$current_page)
{    redirect_to("manage_content.php"); } 
?>


        <?php
        if(isset($_POST["submit"]))
        {
        // process the form

        //validation processes
        $required_fields = array("menu_name", "position", "visible", "content");
        validate_presence($required_fields);

        $fields_with_max_lenth = array("menu_name" => 30);
        validate_max_lenth($fields_with_max_lenth);


        if(empty($errors))
        {

        //normally form values
        $id = $current_page["id"];
        $menu_name = mysql_prep($_POST["menu_name"]);
        $position = (int) $_POST["position"];
        $visible = (int) $_POST["visible"];
        $content = mysql_prep($_POST["content"]) ;


        // perform a query on the database 
        $query = " UPDATE pages SET ";
        $query .= " menu_name = '{$menu_name}', " ;
        $query .= " position = {$position}, ";
        $query .= " visible = {$visible}, ";
        $query .= " content = '{$content}' ";
        $query .= " WHERE id = {$id} ";
        $query .= " LIMIT 1";

        $result = mysqli_query($connection, $query);
        // check for query error 
        if($result && mysqli_affected_rows($connection) == 1) 
        { 
        $_SESSION["message"] ="Page Updated";
        redirect_to("manage_content.php") ;
        }
        else
        {
        $message="Page Update failed";
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

    <h2> Edit Page </h2>

    <form action="edit_page.php?page=<?php echo $current_page["id"]; ?>" method="post" >

        <p> menu name: 
            <input type="text" name="menu_name" value="<?php  echo $current_page["menu_name"]; ?> ">
        </p>    

        <p> Position:
           <select name="position">
           <?php
            //    $page_set = find_page_perSubject($_GET["page"]); 
               $page_count = mysqli_num_rows($page_set);
   
        for($count = 1 ; $count <= $page_count  ; $count++)
        { echo "<option value=\"{$count}\" ";
        if ($current_page["position"] == $count){
            echo "selected" ;
        }
                echo ">{$count} </option>";  }
        ?>
            </select>
        </p>
        <p> Visible:
        <input type="radio" name="visible" value="0" <?php if($current_page["visible"] == 0){ echo "checked";} ?> > no
        &nbsp;
        <input type="radio" name="visible" value="1" <?php if($current_page["visible"] == 1){ echo "checked";} ?>> yes
        </p>

        <p> Content: <br/>
        <textarea type="textarea" name="content" rows="20" cols="80" value = ><?php echo $current_page["content"] ?></textarea>
        </p>

        <input type="submit"  name="submit" value="Edit Page" >
    </form>
<br />
    <a href="manage_content.php"> Cancel </a>
    &nbsp;
    &nbsp;
    <a href="delete_page.php?page=<?php echo $current_page["id"]; ?> " onclick = "return confirm('are you sure ?')">- Delete Page </a>

</div>
    </div>



<?php include("../inc/layout/footer.php"); ?>