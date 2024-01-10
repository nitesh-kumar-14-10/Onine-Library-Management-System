<?php
    //(sernver name, username, password, databasename)
    $db=mysqli_connect("localhost","root","","lmsdb");
    if(!$db)
    {
        die("connection failed:" .mysqli_connect_error());
    }
?>