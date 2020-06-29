<?php

$dbhost = "127.0.0.1";
$dbuser = "widget_admin";
$dbpass = "P@SSCOPY";
$dbname = "widget_corp";

// create a connection 
$connection = mysqli_connect($dbhost, $dbuser , $dbpass , $dbname);


// check for error and display is available 
if (mysqli_connect_errno()){ 
        die( "Database connection failed" .
         mysqli_connect_error().    
         "(". mysqli_connect_errno() .")" 
          );
}

//normally form values
$id = 5;
$menu_name = "Delete me";
$position = 4;
$visible = 1;

// perform a query on the database 
$query = "UPDATE subjects SET ";
$query .= "menu_name = '{$menu_name}', " ;
$query .= "position = {$position}, ";
$query .= "visible = {$visible} ";
$query .= " WHERE id = {$id} ";


$result = mysqli_query($connection, $query);


// check for query error 
if($result && mysqli_affected_rows($connection) == 1) { 
    echo "Sucess !" ;
} else {
    //Sucess : normally redirect to another page 
    die("Database query failed .". mysqli_error($connection) ) ; } 

// // use result form query if any
// while( $row = mysqli_fetch_row($result)){
//     //output data from each row
//     var_dump($row);
//     echo "<hr/>";
// }

?>



<?php


// closing the connection
mysqli_close($connection);

?>