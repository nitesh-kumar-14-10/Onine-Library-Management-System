<?php
$title="Update Password";
include "navbar.php";
?>
<!DOCTYPE html>
<html>
    <head>
    </head>
    <body>
        <?php

        if(isset($_POST['submit']))
        {

            $error="";
            $query=mysqli_query($db,"select username, email from admin where username='$_POST[username]' && email='$_POST[email]'");
            $count= mysqli_num_rows($query);
            if(strlen($_POST['password'])<3) {
                $error="Password must be atleast 3 characters long";
            }
            else if($_POST['password'] != $_POST['conPass'])
            {
                $error="Confirm new password must match with the new password";
            }
            else
            {
                if($count>0)
                {
                    try {
                        $password= password_hash($_POST['password'],PASSWORD_DEFAULT);
                        mysqli_query($db,"UPDATE admin SET password='$password' WHERE username='$_POST[username]' && email='$_POST[email]' ;");
                        $_SESSION['msg']= 'Password is successfully updated';
                        header("Location: admin-login.php");
                    }
                    catch(Exception $e) {
                        die($e->getMessage());
                    }
                }
                else{
                    $error="username or email is incorrect";
                }
            }
        }
        if(isset($_POST['changePass']))
        {
            $count=0;
            $error="";
            $query=mysqli_query($db,"select password from admin where id='$_SESSION[admin]';");
            $res=mysqli_fetch_assoc($query);
            $count= mysqli_num_rows($query);

            if($count>0 && password_verify($_POST['oldPass'], $res['password']))
            {
                if(strlen($_POST['newPass'])<3 )
                {
                    $error="password must be atleast 3 characters long";
                }
                else if($_POST['newPass'] != $_POST['conNewPass'])
                {
                    $error="Confirm password must match with the new password";
                }
                else
                {
                    try {
                        $password= password_hash($_POST['newPass'],PASSWORD_DEFAULT);
                        mysqli_query($db,"UPDATE admin SET password='$password' WHERE id='$_SESSION[admin]';");
                        $_SESSION['msg']= 'Password is successfully updated';
                        header("Location: profile.php");
                    }
                    catch(Exception $e) {
                        die($e->getMessage());
                    }
                }
            }
            else{
                $error="current password is incorrect";
            }

        }

        ?>
        ?>
        <div class="wrapper" id="main">
            <div class="box">
                <div class="box-content box-form">
                    <h1>Change Your Password</h1>
                    <br>
                    <div class="form-wrapper">
                        <form action="" method="post" >
                            <?php
                            if(isset($_SESSION['login_admin']))
                            {
                            ?>
                            <input type="password" name="oldPass" class="form-control" placeholder="old password" required=""><br>

                            <input type="password" name="newPass" class="form-control" placeholder="new password" required=""><br>
                            <input type="password" name="conNewPass" class="form-control" placeholder="confirm New Password" required=""><br>

                            <button class="btn btn-primary" type="submit" name="changePass" >Change Password</button>
                            <?php
                                if(!empty($error))
                                {
                            ?>      <br>
                            <span class="error"><?php echo $error; ?></span><br>
                            <?php
                                }

                            ?>

                            <?php
                            } 
                            else {
                            ?>
                            <input type="text" name="username" class="form-control" placeholder="Username" required=""><br>
                            <input type="text" name="email" class="form-control" placeholder="Email" required=""><br>
                            <input type="password" name="password" class="form-control" placeholder="New Password" required=""><br>
                            <input type="password" name="conPass" class="form-control" placeholder="Confirm New Password" required=""><br>
                            <button class="btn btn-primary" type="submit" name="submit" >Update</button>
                            <?php
                                if(!empty($error))
                                {
                            ?>
                            <br>
                            <span class="error"><?php echo $error; ?></span>
                            <?php
                                }
                            }
                            ?>
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