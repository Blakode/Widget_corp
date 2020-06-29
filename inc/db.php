<?php

define( "DBHOST", "127.0.0.1");
define( "DBUSER", "widget_admin");
define( "DBPASS", "P@SSCOPY");
define( "DBNAME", "widget_corp");

// create a connection 
$connection = mysqli_connect(DBHOST, DBUSER , DBPASS , DBNAME);


// check for error and display is available 
if (mysqli_connect_errno()){ 
        die( "Database connection failed" .
         mysqli_connect_error().    
         "(". mysqli_connect_errno() .")" 
          );
}

?>