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

// perform a query on the database 
$query = "SELECT * ";
$query .= "FROM subjects ";
$query .= "WHERE visible=1 ";
$query .= "ORDER by position ASC";

$result = mysqli_query($connection, $query);


// check for query error 
if(!$result) { die("Database query failed"); } 

// // use result form query if any
// while( $row = mysqli_fetch_row($result)){
//     //output data from each row
//     var_dump($row);
//     echo "<hr/>";
// }

?>


<ul>

    <?php 
    while ( $subject = mysqli_fetch_assoc($result)){ 
      // use result form query if any  
    ?>

    <!-- //output data from each row -->
   <li> <?php echo $subject["menu_name"] .  " (" .$subject['id']. ")" ."<br/>"; ?> </li>
   <?php   }  ?>
</ul>


<?php

// release the result
mysqli_free_result($result);

// closing the connection
mysqli_close($connection);

?>