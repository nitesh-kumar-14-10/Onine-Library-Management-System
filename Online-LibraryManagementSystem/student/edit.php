<?php
$title="Edit Profile";
include "navbar.php";
if(!isset($_SESSION['login_user']))
{
    header("Location: student-login.php");
}
//include "connection.php";
?>
<!DOCTYPE html>
<html>
    <head>
    </head>
    <body>
        <?php 

        if(isset($_POST['submit']))
        {
            //move_uploaded_file($_FILES['file']['tmp_name'],"Content/images/".$_FILES['file']['name']);
            $firsterr="";
            $lasterr="";
            $emailerr="";
            $phonerr="";
            $first=$_POST['first'];
            $last=$_POST['last'];
            $email=$_POST['email'];
            $contact=$_POST['contact'];
            //$pic=$_FILES['file']['name'];
            if(strlen($first)<3 || strlen($first)>20)
            {
                $firsterr="firstname must be atleast 3 and no more than 20 character long";
            }
            else if(strlen($last)<3 || strlen($last)>20)
            {
                $lasterr="firstname must be atleast 3 and no more than 20 character long";
            }
            else if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $emailerr = "Invalid email address";
            }
            //else if(!preg_match('/^[0-9]{3}-[0-9]{3}-[0-9]{4}$/', $_POST['phone']))
            else if(!preg_match('/^[0-9]{11}$/', $contact))
            {
                $phonerr = 'Invalid phone number';
            }
            else
            {
                $sql1= "UPDATE students SET firstname='$first', lastname='$last', email='$email', phone='$contact' WHERE studentID='".$_SESSION['user']."';";
                if(mysqli_query($db,$sql1))
                {
                    $_SESSION['msg']= 'profile details changed successfully';
                    header("Location: profile.php");
                }
            }
        }
        if(isset($_POST['editPass']))
        {
            header("Location: update_password.php");
        }
        ?>
        <div class="wrapper" id="main">
            <div class="box">
                <div class="box-content box-form">
                    <h1 class="text-center">Edit Information</h1>
                    <?php

                    $sql = "SELECT * FROM students WHERE studentID='$_SESSION[user]'";
                    $result = mysqli_query($db,$sql) or die (mysql_error());

                    while ($row = mysqli_fetch_assoc($result)) 
                    {
                        $first=$row['firstname'];
                        $last=$row['lastname'];
                        $username=$row['username'];
                        $email=$row['email'];
                        $contact=$row['phone'];
                    }

                    ?>

                    <div class="profile_info">
                        <h4><b>Welcome, </b><?php echo $username; ?></h4>

                    </div><br><br>
                    <div class="form-wrapper">
                        <form action="" method="post" enctype="multipart/form-data">

                            <label><h4><b>First Name: </b></h4></label>
                            <input class="form-control" type="text" name="first" value="<?php echo $first; ?>">
                            <?php
                            if(!empty($firsterr))
                            {
                            ?>
                            <br>
                            <span class="error"><?php echo $firsterr; ?></span>
                            <?php }?>

                            <label><h4><b>Last Name</b></h4></label>
                            <input class="form-control" type="text" name="last" value="<?php echo $last; ?>">
                            <?php
                            if(!empty($lasterr))
                            {
                            ?>
                            <br>
                            <span class="error"><?php echo $lasterr; ?></span>
                            <?php }?>

                            <label><h4><b>Email</b></h4></label>
                            <input class="form-control" type="text" name="email" value="<?php echo $email; ?>">
                            <?php
                            if(!empty($emailerr))
                            {
                            ?>
                            <br>
                            <span class="error"><?php echo $emailerr; ?></span>
                            <?php }?>
                            <label><h4><b>Contact No</b></h4></label>
                            <input class="form-control" type="text" name="contact" value="<?php echo $contact; ?>">
                            <?php
                            if(!empty($phonerr))
                            {
                            ?>
                            <br>
                            <span class="error"><?php echo $phonerr; ?></span>
                            <?php }?>
                            <br>
                            <button class="btn btn-primary" type="submit" name="submit">save</button>
                            <br><br>
                            <button class="btn btn-primary" name="editPass">Change Password</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <?php 
        include "../footer.php";
        ?>
    </body>
</html>

