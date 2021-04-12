<?php
    // include('db.php'); #this will include the data of the Database and queries;
    // include('userHandlerClasses.php');
    // session_start();  #this will start the session
    if($_SESSION['userRole']){
            session_destroy();
            header("Location:index.php");
    }
?>