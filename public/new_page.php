<?php require_once("../inc/session.php"); ?>
<?php require_once("../inc/db.php"); ?>
<?php require_once("../inc/functions.php"); ?>

<?php find_selected_page(); ?>

<?php require_once("../inc/validation_function.php"); ?>


        <?php 
        logged_out();
        if (!$current_subject)
        {
        $_SESSION["message"] ="Can't Create page without parent subject";
        redirect_to("manage_content.php");
        }
        ?>
        
        
        <?php 
        
        
        if( isset($_POST["submit"]) ){

        // process the form 
        
        //validation processes
        $required_fields = array( "menu_name", "position", "visible", "content");
        validate_presence($required_fields);

        $fields_with_max_lenth = array("menu_name" => 30);
        validate_max_lenth($fields_with_max_lenth);
    
 
    
        if(empty($errors))
        {
            // $_SESSION["errors"] = $errors;
            // redirect_to("new_page.php");
            // }
               // manage type casting and escape form values

        //normally form values
        $subject_id = (int)($current_subject["id"]);
        $menu_name = mysql_prep($_POST["menu_name"]);
        $content = mysql_prep($_POST["content"]);
        $position = (int) $_POST["position"];
        $visible = (int) $_POST["visible"];
        

        $query = "INSERT INTO pages ( ";    
        $query .= " subject_id , menu_name, position, visible, content";
        $query .= ")VALUES (";
        $query .= " {$subject_id} ,'{$menu_name}', {$position}, {$visible}, '{$content}' " ;
        $query .= ")";
        $result = mysqli_query($connection, $query);

                        
        
                // check for query error 
                if($result) 
                { 
                $_SESSION["message"] ="Page Created ";
                redirect_to("manage_content.php") ;
                }
                else
                {
                    $message="Page Creation failed";
                } 
           // } // end of if(isset($_POST["submit"])
        } 
    }
            else
        {

        }

?>

        <?php
            $layout_context = "admin";
            include("../inc/layout/header.php"); 
        ?>

<div id="main">
    <div id="navigation"> 

 <?php   echo navigation($current_subject , $current_page ); ?>

</div>

<div id="page">
                            <?php 
                            if(!empty($message)){
                            echo "<div class=\"message\">.$message. </div>" ;
                            }
                            // second method escaping the php 
                            ?>
                            <?php echo form_errors($errors); ?>

    <h2> Create Page </h2>

    <form action="new_page.php?subject=<?php echo $current_subject["id"]; ?>" method="post" >

        <p> menu name:
            <input type="text" name="menu_name" value="">
        </p>

        <p> Position:
           <select name="position">

           <?php
            $page_set = find_page_perSubject($_GET['subject'], false); 
            $page_count = mysqli_num_rows($page_set);

        for($count=1; $count <= ($page_count + 1) ; $count++)
        { echo "<option value=\"{$count}\" >{$count} </option>" ;  }
        ?>
            </select>
        </p>

        <p> Visible:
        <input type="radio" name="visible" value="0"> no
        &nbsp;
        <input type="radio" name="visible" value="1"> yes
        </p>

        <p> Content: <br/>
        <textarea type="textarea" name="content" rows="20" cols="80" value =""></textarea>
        </p>
        <input type="submit"  name="submit" value ="Create Page" >
    </form>
<br />
    <a href="manage_content.php"> Cancel </a>


</div>
    </div>




<?php include("../inc/layout/footer.php"); ?>