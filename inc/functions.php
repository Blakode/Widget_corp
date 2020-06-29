<?php
function redirect_to($new_location)
{
    header("Location: ". $new_location);
    exit;
}

function mysql_prep($string)

{
    global $connection;

    $escaped_string = mysqli_real_escape_string($connection, $string);
    return $escaped_string;
}

function confirm_query($results)
{
if(!$results)
{die("Database query failed");}
// checks result to after query to confirm status  
}


// to print errors gotten from the validations
function form_errors($errors = array()){
    $output = "";
    if (!empty($errors)){
    $output .= "<div class=\"error\">";
    $output .= "please fix the following errors";
    $output .= "<ul>";
    foreach($errors as $key => $error){
    $output .= "<li>";
    $output .= htmlentities($error);
    $output .= "</li>";
    }
    $output .= "</ul> ";
    $output .= "</div>";
    }
    return $output;
}


function find_subject($public = true)
{   
global $connection;
$query = "SELECT * ";
$query .= "FROM subjects ";
if($public){
$query .= " WHERE visible = 1 ";
}
$query .= "ORDER by position ASC";
$subject_set = mysqli_query($connection, $query);
confirm_query($subject_set);

return $subject_set;
// this queries the db for the fields of data in subjects 
}



function find_page_perSubject($subject_id, $public = true)
{
    // get page field linked to a subject from a query

global $connection;
$safe_subID = mysqli_real_escape_string($connection, $subject_id);

$query = "SELECT * ";
$query .= " FROM pages ";
$query .= " WHERE subject_id = {$safe_subID} ";
if($public){
    $query .= " AND visible = 1 ";
    }
$query .= "ORDER by position ASC";
$page_set = mysqli_query($connection, $query);
confirm_query($page_set);

return $page_set;
}

function find_default_page_for_subject($subject_id)
{
    $page_set = find_page_perSubject($subject_id);

        if($first_page = mysqli_fetch_assoc($page_set)){
            return $first_page;
        } else{
            return false;
        }
}

function find_selected_page($public = false)
{

    global $current_subject;
    global $current_page;

    if(isset($_GET["subject"]))
    {
        $current_subject = find_subject_by_id($_GET["subject"], $public);
        if ($current_subject && $public){
        $current_page = find_default_page_for_subject($current_subject["id"]);
          } else
     { $current_page = null; }

         }elseif (isset($_GET["page"]))
    {
        $current_subject = null;
        $current_page = find_page_by_id($_GET["page"], $public);
    } else
    {
        $current_subject= null;
        $current_page = null;
    }

}


function navigation($subject_array, $page_array)
{
    // navigation takes two argument
    // the current subject array or null 
    // the current page or null

   $output ="<ul class=\"subjects\">";
   $subject_set= find_subject(false);
   while ( $subject = mysqli_fetch_assoc($subject_set)){ 
        // use result form query if any  
        //output data from each row
   $output .="<li ";
       if ($subject_array && $subject["id"] == $subject_array["id"])
       {
    $output .="class=\"selected\" ";
       }
    $output .="> ";
    $output .="<a href=\"manage_content.php?subject=";
    $output .= urlencode($subject["id"]);
    $output .="\"> ";
    $output .= htmlentities($subject["menu_name"]);
    $output .= "<br/>";
    $output .=" </a>";
    
    $page_set =find_page_perSubject($subject["id"], false);
           
    $output .= "<ul class=\"pages\">";
    while ( $page = mysqli_fetch_assoc($page_set)){ 
    //output data from each row
    $output .= "<li ";
    if ($page_array && $page["id"] == $page_array["id"])
    {
    $output .= "class=\"selected\" ";
    }
    $output .="> ";
    $output .="<a href=\"manage_content.php?page=";
    $output .= urlencode($page["id"]); 
    $output .="\"> ";
    $output .= htmlentities($page["menu_name"]);
    $output .="<br/>"; 
    $output .="</a> </li>"; 
                }  
    $output .="</ul> </li>";
          }  
    $output .="</ul>";
    return $output;
}



function index_navigation($subject_array, $page_array)
{
    // navigation takes two argument
    // the current subject array or null 
    // the current page or null

   $output ="<ul class=\"subjects\">";
   $subject_set= find_subject();
   while ( $subject = mysqli_fetch_assoc($subject_set)){ 
        // use result form query if any  
        //output data from each row
   $output .="<li ";
       if ($subject_array && $subject["id"] == $subject_array["id"])
       {
    $output .="class=\"selected\" ";
       }
    $output .="> ";
    $output .="<a href=\"index.php?subject=";
    $output .= urlencode($subject["id"]);
    $output .="\"> ";
    $output .= htmlentities($subject["menu_name"]);
    $output .= "<br/>";
    $output .=" </a>";
    
    if($subject_array ["id"]== $subject["id"] || $page_array["subject_id"] == $subject["id"]){

    $page_set =find_page_perSubject($subject["id"]);
           
    $output .= "<ul class=\"pages\">";
    while ( $page = mysqli_fetch_assoc($page_set)){ 
    //output data from each row
    $output .= "<li ";
    if ($page_array && $page["id"] == $page_array["id"])
    {
    $output .= "class=\"selected\" ";
    }
    $output .="> ";
    $output .="<a href=\"index.php?page=";
    $output .= urlencode($page["id"]); 
    $output .="\"> ";
    $output .= htmlentities($page["menu_name"]);
    $output .="<br/>"; 
    $output .="</a> </li>"; 
                }  
    $output .="</ul>";
    mysqli_free_result($page_set);
            }
    $output .="</li>";
          }  
          mysqli_free_result($subject_set);
    $output .="</ul>";
    return $output;
}


function find_subject_by_id($subject_id, $public =true)
{
global $connection;
// get page field linked to a subject from a query
$safe_subID = mysqli_real_escape_string($connection, $subject_id);
$query = "SELECT * ";
$query .= "FROM subjects ";
$query .= "WHERE id = {$safe_subID} ";
if($public){
    $query .= " AND visible = 1 ";
    } 
$query .= "LIMIT 1";
$subject_set = mysqli_query($connection, $query);
confirm_query($subject_set);

if($subject = mysqli_fetch_assoc($subject_set)){
        return $subject;
    } else{
        return false;
    }
}


function find_page_by_id($page_id, $public =true)
{
global $connection;
// get page field linked to a subject from a query
$safe_pageID = mysqli_real_escape_string($connection, $page_id);
$query = "SELECT * ";
$query .= "FROM pages ";
$query .= "WHERE id = {$safe_pageID} ";
if($public){
$query .= " AND visible = 1 ";
} 
$query .= "LIMIT 1";
$page_set = mysqli_query($connection, $query);
confirm_query($page_set);
if($page = mysqli_fetch_assoc($page_set)){
        return $page;
    } else{
        return false;
    }
}



function find_admin()
{   
global $connection;
$query = " SELECT * ";
$query .= " FROM admins ";
//$query .= " ORDER by position ASC";
$admin_set = mysqli_query($connection, $query);
confirm_query($admin_set);

return $admin_set;
// this queries the db for the fields of data in subjects 
}




function find_admin_by_id($id)
{
global $connection;
$safe_adminID = mysqli_real_escape_string($connection, $id);

$query = "SELECT * ";   
$query .= "FROM admins ";
$query .= "WHERE id = {$safe_adminID } ";
$query .= "LIMIT 1";
$admin_set = mysqli_query($connection, $query);
confirm_query($admin_set);

if($admin = mysqli_fetch_assoc($admin_set)){
        return $admin;
    } else{
        return false;
    }
}


function find_admin_by_username($username)
{
global $connection;
$safe_admin_username = mysqli_real_escape_string($connection, $username);

$query = "SELECT * ";   
$query .= "FROM admins ";
$query .= "WHERE username = '{$safe_admin_username}' ";
$query .= "LIMIT 1";

$admin_set = mysqli_query($connection, $query);
confirm_query($admin_set);

if($admin = mysqli_fetch_assoc($admin_set)){
        return $admin;

    } else{
        return null;
    }
}



function find_selected_admin()
{
    global $current_admin;

    if(isset($_GET["id"]))
    {
        $current_admin = find_admin_by_id($_GET["id"]);
    } else {
        $current_admin = null;
    }


}




function password_encrypt($password)
{

$hash_format = "$2y$10$";

$salt_lenth = 22; 

$salt = generate_salt($salt_lenth);
$hashed_format_and_salt = $hash_format . $salt ;

$hash = crypt($password, $hashed_format_and_salt);

return $hash;

}


function generate_salt($lenth)
{
    $unique_rand_str = md5(uniqid(mt_rand(), true));

    $base64_encode = base64_encode($unique_rand_str);

    $base64_modified = str_replace( '+', '.', $base64_encode);

    $salt = substr($base64_modified, 0, $lenth);

    return $salt;

}


function confirm_password($password, $hash_password)
{
$hash = crypt($password, $hash_password);

if ($hash === $hash_password){

    return true;
} 
else 
{

    return false;
    }

}

function  attempt_login($username, $password)
{
    $admin = find_admin_by_username($username);

    if ($admin){
        // admins checked confirm password
        if(  confirm_password($password, $admin["hased_password"]))
        {
            return $admin;
        } 
        else 
        {
            return false;
        }

   } else {

       return false;
   }
}

function logged_in()
{
   return isset($_SESSION["admin_id"]);
}

function logged_out()
{
    if(!logged_in()){
        redirect_to("login.php");
    }
}