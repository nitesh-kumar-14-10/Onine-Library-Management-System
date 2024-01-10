<?php
$title="Librarian Register";
include "navbar.php";
if(!$_SESSION['login_admin']) {
    header("Location: admin-login.php");
}
?>
<!DOCTYPE html>
<html lang="en">
    <head>

    </head>
    <body>
        <?php
        if(isset($_POST['register']))
        {
            $firsterr="";
            $lasterr="";
            $usererr="";
            $passerr="";
            $conpasserr="";
            $emailerr="";
            $phonerr="";
            $count=0;
            $sql="Select username from `admin`";
            $res=mysqli_query($db,$sql);
            while($row=mysqli_fetch_assoc($res))
            {
                if($row['username']==$_POST['username'])
                {
                    $count=$count+1;
                }
            }
            if(strlen($_POST['first'])<3 || strlen($_POST['first'])>20)
            {
                $firsterr="firstname must be atleast 3 and no more than 20 character long";
            }
            else if(strlen($_POST['last'])<3 || strlen($_POST['last'])>20)
            {
                $lasterr="firstname must be atleast 3 and no more than 20 character long";
            }
            else if(strlen($_POST['username'])<3 || strlen($_POST['username'])>20)
            {
                $usererr="username must be atleast 3 and no more than 20 character long";
            }
            else if($count>0)
            {
                $usererr="Choose different username";
            }
            else if(strlen($_POST['password'])<3 )
            {
                $passerr="password must be atleast 3 character long";
            }
            else if($_POST['password'] != $_POST['confirmpass'])
            {
                $conpasserr="Confirm password must match with the password";
            }
            else if (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
                $emailerr = "Invalid email address";
            }
            //else if(!preg_match('/^[0-9]{3}-[0-9]{3}-[0-9]{4}$/', $_POST['phone']))
            else if(!preg_match('/^[0-9]{11}$/', $_POST['contact']))
            {
                $phonerr = 'Invalid phone number';
            }
            else
            {
                try
                {
                    $password= password_hash($_POST['password'],PASSWORD_DEFAULT);
                    mysqli_query($db,"insert into `admin` values('','$_POST[first]','$_POST[last]','$_POST[username]','$password','$_POST[email]','$_POST[contact]');");

                    $_SESSION['msg']= 'Registration is successfully';
                }
                catch(Exception $e)
                {
                    die($e->getMessage());
                }
            }

        }
        ?>
        <div class="wrapper" id="main">

            <div class="box">
                <div class="box-content box-form">
                    <h1>Library Management System</h1>
                    <h2>Registration Form</h2>
                    <br>
                    <?php
                    if(isset($_SESSION['msg'])) {
                        echo "<span class='error success'>";echo $_SESSION['msg'];echo"</span>";
                        unset($_SESSION['msg']);
                    }
                    ?>
                    <div class="form-wrapper">
                        <form action="" name="Registration" method="post">
                            <input class="form-control" type="text" name="first" placeholder="Enter First Name" required>
                            <?php
                            if(!empty($firsterr))
                            {
                                echo "<br>";
                                echo "<span class='error'>"; echo $firsterr; echo "</span>";
                            }?>
                            <br>
                            <input class="form-control" type="text" name="last" placeholder="Enter Last Name" required>
                            <?php
                            if(!empty($lasterr))
                            {
                                echo "<br>";
                                echo "<span class='error'>"; echo $lasterr; echo "</span>";
                            }?>
                            <br>
                            <input class="form-control" type="text" name="username" placeholder="Enter Username" required>
                            <?php
                            if(!empty($usererr))
                            {
                                echo "<br>";
                                echo "<span class='error'>"; echo $usererr; echo "</span>";
                            }?>
                            <br>
                            <input class="form-control" type="password" name="password" placeholder="Enter Password" required>
                            <?php
                            if(!empty($passerr))
                            {

                                echo "<br>";
                                echo "<span class='error'>"; echo $passerr; echo "</span>";

                            }?>
                            <br>
                            <input class="form-control" type="password" name="confirmpass" placeholder="Enter Confirm Password" required>
                            <?php
                            if(!empty($conpasserr))
                            {

                                echo "<br>";
                                echo "<span class='error'>"; echo $conpasserr; echo "</span>";

                            }?>
                            <br>
                            <input class="form-control" type="text" name="email" placeholder="Enter Email Address" required>
                            <?php
                            if(!empty($emailerr))
                            {

                                echo "<br>";
                                echo "<span class='error'>"; echo $emailerr; echo "</span>";

                            }?>
                            <br>
                            <input class="form-control" type="text" name="contact" placeholder="Enter Phone number" required>
                            <?php
                            if(!empty($phonerr))
                            {

                                echo "<br>";
                                echo "<span class='error'>"; echo $phonerr; echo "</span>";

                            }?>
                            <br>
                            <button class="btn btn-primary" name="register">Register</button>
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