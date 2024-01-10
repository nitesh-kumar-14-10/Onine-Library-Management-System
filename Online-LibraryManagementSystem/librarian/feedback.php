<?php
$title="Comments";
include "navbar.php";
if(!isset($_SESSION['admin'])) {
    header("Location: admin-login.php");
}
?>
<!DOCTYPE html>
<html lang="en">
    <head>
    </head>
    <body>

        <div class="wrapper" id="main">
            <div class="box full-box log-pad">
                <div class="box-content box-form">
                    <div class="container">
                        <h1>If you have any suggesions or questions please comment below.</h1>
                        <br>
                        <div class="form-wrapper">

                            <form style="" action="" method="post">
                                <textarea class="form-control" type="text" name="comment" placeholder="Write something..."></textarea><br>
                                <button class="btn btn-primary" name="submit">Comment</button>	
                            </form>

                            <br><br>
                        </div>
                        <div class="scroll">

                            <?php
                            if(isset($_POST['submit']))
                            {
                                //$comments=$_POST['comment'];
                                $comments = str_replace("'", "\'", $_POST['comment']);
                                $sql="INSERT INTO comments VALUES ('', '$_SESSION[login_admin]', '$comments');";
                                if(mysqli_query($db,$sql))
                                {
                                    $q="SELECT * FROM `comments` ORDER BY `comments`.`id` ASC";
                                    $res=mysqli_query($db,$q);

                                    echo "<table class='table table-bordered'>";
                                    while ($row=mysqli_fetch_assoc($res)) 
                                    {

                                        echo "<tr>";
                                        echo "<td>"; echo $row['username']; echo "</td>";
                                        echo "<td>"; echo $row['comments']; echo "</td>";
                                        echo "</tr>";
                                    }
                                    echo "</table>";
                                }

                            }

                            else
                            {
                                $q="SELECT * FROM `comments` ORDER BY `comments`.`id` ASC"; 
                                $res=mysqli_query($db,$q);

                                echo "<table class='table table-bordered'>";
                                while ($row=mysqli_fetch_assoc($res))
                                {
                                    echo "<tr>";
                                    echo "<td>"; echo $row['username']; echo "</td>";
                                    echo "<td>"; echo $row['comments']; echo "</td>";
                                    echo "</tr>";
                                }
                                echo "</table>";
                            }
                            ?>
                        </div>
                    </div>

                </div>
            </div>
        </div>
        <?php  

        include "../footer.php";
        ?>
    </body>
</html>