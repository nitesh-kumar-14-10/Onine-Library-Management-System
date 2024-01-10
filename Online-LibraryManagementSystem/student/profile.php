<?php 
//include "connection.php";
$title="Profile";
include "navbar.php";
if(!isset($_SESSION['login_user']))
{
    header("Location: student-login.php");
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
                        <?php
                        $q=mysqli_query($db,"SELECT * FROM students where studentID='$_SESSION[user]' ;");
                        ?>
                        <h2 class="title">My Profile</h2>

                        <?php
                        $row=mysqli_fetch_assoc($q);

                        ?>
                        <div class="image-block"> <h4><b>Welcome, </b><?php echo $row['username']; ?> </h4> </div>
                        <?php
                        if(isset($_SESSION['msg'])) {
                            echo "<span class='error success'>";echo $_SESSION['msg'];echo"</span>";
                            unset($_SESSION['msg']);
                        }
                        ?>
                        <form action="edit.php" method="post">
                            <button class="btn btn-primary right edit-btn" name="submit1">Edit</button>
                        </form>

                        <?php

                        echo "<b>";
                        echo "<table class='table table-bordered'>";

                        echo "<tr>";
                        echo "<td>";
                        echo "<b> First Name: </b>";
                        echo "</td>";
                        echo "<td>";
                        echo $row['firstname'];
                        echo "</td>";
                        echo "</tr>";

                        echo "<tr>";
                        echo "<td>";
                        echo "<b> Last Name: </b>";
                        echo "</td>";
                        echo "<td>";
                        echo $row['lastname'];
                        echo "</td>";
                        echo "</tr>";

                        echo "<tr>";
                        echo "<td>";
                        echo "<b> Email: </b>";	
                        echo "</td>";
                        echo "<td>";
                        echo $row['email'];
                        echo "</td>";
                        echo "</tr>";

                        echo "<tr>";
                        echo "<td>";
                        echo "<b> Contact: </b>";
                        echo "</td>";
                        echo "<td>";
                        echo $row['phone'];
                        echo "</td>";
                        echo "</tr>";


                        echo "</table>";
                        echo "</b>";
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