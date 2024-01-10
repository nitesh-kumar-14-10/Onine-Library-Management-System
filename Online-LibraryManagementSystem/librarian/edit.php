<?php
ob_start();
$title="Edit Profile";
include "navbar.php";
if(!isset($_SESSION['login_admin']))
{
    header("Location: admin-login.php");
}
?>
<!DOCTYPE html>
<html>

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
                $sql1= "UPDATE admin SET first='$first', last='$last', email='$email', contact='$contact' WHERE username='".$_SESSION['login_user']."';";
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
        ob_end_flush();
        ?>
        <div class="wrapper" id="main">
            <div class="box">
                <div class="box-content box-form">
                    <h2>Edit Information</h2>
                    <?php

                    $sql = "SELECT * FROM admin WHERE username='$_SESSION[login_admin]'";
                    $result = mysqli_query($db,$sql) or die (mysql_error());

                    while ($row = mysqli_fetch_assoc($result)) 
                    {
                        $first=$row['first'];
                        $last=$row['last'];
                        $username=$row['username'];
                        $password=$row['password'];
                        $email=$row['email'];
                        $contact=$row['contact'];
                    }

                    ?>
                    <div class="profile_info">
                        <h4><b>Welcome, </b><?php echo $_SESSION['login_admin']; ?></h4>

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

