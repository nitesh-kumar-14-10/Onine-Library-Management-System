<?php
ob_start();
$title="Profile";
include "navbar.php";
if(!isset($_SESSION['login_admin']))
{
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
                        <?php

                        $q=mysqli_query($db,"SELECT * FROM admin where username='$_SESSION[login_admin]' ;");
                        ?>
                        <h2 class="title">My Profile</h2>

                        <?php
                        $row=mysqli_fetch_assoc($q);

                        ?>
                        <div class="image-block"> <h4><b>Welcome, </b><?php echo $_SESSION['login_admin']; ?> </h4> </div>
                        <?php
                        if(isset($_SESSION['msg'])) {
                            echo "<br><span class='error success'>";echo $_SESSION['msg'];echo"</span>";
                            unset($_SESSION['msg']);
                        }
                        ?>
                        <form action="" method="post">
                            <button class="btn btn-primary right edit-btn" name="editBtn" type="submit">Edit</button>
                        </form>
                        <?php

                        if(isset($_POST['editBtn']))
                        {
                            header("Location: edit.php");
                        }

                        echo "<table class='table table-bordered'>";

                        echo "<tr>";
                        echo "<td>";
                        echo "<b> First Name: </b>";
                        echo "</td>";

                        echo "<td>";
                        echo $row['first'];
                        echo "</td>";
                        echo "</tr>";

                        echo "<tr>";
                        echo "<td>";
                        echo "<b> Last Name: </b>";
                        echo "</td>";
                        echo "<td>";
                        echo $row['last'];
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
                        echo $row['contact'];
                        echo "</td>";
                        echo "</tr>";

                        echo "</table>";
                        ?>
                    </div>
                </div>
            </div>
        </div>

        <?php
        ob_end_flush();
        include "../footer.php";
        ?>
    </body>
</html>