<?php
$title="Student List";
include "navbar.php";
if(!isset($_SESSION['login_admin'])) {
    header("Location: admin-login.php");
}
?>
<!DOCTYPE html>
<html>
    <head>

    </head>
    <body>

        <div class="wrapper" id="main">

            <div class="box full-box log-pad">
                <div class="box-content box-form">
                    <div class="container">

                        <h1 class="text-center">List Of Students</h1>
                        <!--search bar-->
                        <div class="search-box">

                            <form class="navbar-form" method="post" name="form1">
                                <div class="row">
                                    <div class="col-3">
                                        <input class="form-control" type="text" name="search" placeholder="Student username.." required="">
                                    </div>
                                    <div class="text-right">
                                        <button type="submit" name="srchBtn" class="btn btn-primary">
                                            <i class="fas fa-search"></i>
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <?php

                        if(isset($_POST['srchBtn']))
                        {
                            $query=mysqli_query($db,"SELECT firstname,lastname,username,enrollmentNo,email,phone FROM `students` where username like '%$_POST[search]%' ");

                            if(mysqli_num_rows($query)==0)
                            {
                                $noRowMsg= "Sorry! No Username Found.";
                            }
                        }
                        else {
                            $query=mysqli_query($db,"SELECT firstname,lastname,username,enrollmentNo,email,phone FROM `students`;");
                            if(mysqli_num_rows($query)==0)
                            {
                                $noRowMsg= "Sorry! No Data Found.";
                            }
                        }

                        echo "<table class='table table-bordered' >";
                        echo "<tr>";
                        //Table header
                        echo "<th>"; echo "First Name";	echo "</th>";
                        echo "<th>"; echo "Last Name";  echo "</th>";
                        echo "<th>"; echo "Username";  echo "</th>";
                        echo "<th>"; echo "Roll";  echo "</th>";
                        echo "<th>"; echo "Email";  echo "</th>";
                        echo "<th>"; echo "Contact";  echo "</th>";

                        echo "</tr>";	
                        if(!empty($noRowMsg))
                        {
                            echo "<td colspan=6>{$noRowMsg}</td>";
                        }
                        else
                        {
                            while($row=mysqli_fetch_assoc($query))
                            {
                                echo "<tr>";
                                echo "<td>"; echo $row['firstname']; echo "</td>";
                                echo "<td>"; echo $row['lastname']; echo "</td>";
                                echo "<td>"; echo $row['username']; echo "</td>";
                                echo "<td>"; echo $row['enrollmentNo']; echo "</td>";
                                echo "<td>"; echo $row['email']; echo "</td>";
                                echo "<td>"; echo $row['phone']; echo "</td>";

                                echo "</tr>";
                            }
                        }
                        echo "</table>";

                        ?>

                    </div>
                </div>
            </div>
        </div>
        <?php  

        include "../footer.php";
        ?>
    </body>
</html>