<?php
//include "connection.php";
$title="Registration";
include "navbar.php";
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
            $enrolerr="";
            $emailerr="";
            $phonerr="";
            $count=0;
            $sql="Select username,enrollmentNo from students";
            $res=mysqli_query($db,$sql);
            while($row=mysqli_fetch_assoc($res))
            {
                if($row['username']==$_POST['username'])
                {
                    $count=1;
                }
                else if ($row['enrollmentNo']==$_POST['roll'])
                {
                    $count=2;
                }
            }
            if(strlen($_POST['firstname'])<3 || strlen($_POST['firstname'])>20)
            {
                $firsterr="firstname must be atleast 3 and no more than 20 character long";
            }
            else if(strlen($_POST['lastname'])<3 || strlen($_POST['lastname'])>20)
            {
                $lasterr="firstname must be atleast 3 and no more than 20 character long";
            }
            else if(strlen($_POST['username'])<3 || strlen($_POST['username'])>20)
            {
                $usererr="username must be atleast 3 and no more than 20 character long";
            }
            else if($count==1)
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
            else if($count==2)
            {
                $enrolerr="Enrollment number is already registered";
            }
            else if (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
                $emailerr = "Invalid email address";
            }
            //else if(!preg_match('/^[0-9]{3}-[0-9]{3}-[0-9]{4}$/', $_POST['phone']))
            else if(!preg_match('/^[0-9]{11}$/', $_POST['phone']))
            {
                $phonerr = 'Invalid phone number';
            }
            else
            {
                try
                {
                    $password= password_hash($_POST['password'],PASSWORD_DEFAULT);
                    mysqli_query($db,"insert into `students` values('','$_POST[username]','$password','$_POST[roll]','$_POST[firstname]','$_POST[lastname]','$_POST[email]','$_POST[phone]');");
                    $_SESSION['msg']= 'Registration is successfull';
                    header("Location: student-login.php");
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
                    <div class="form-wrapper">

                        <!--<div class="box-content">-->
                        <form action="" name="Registration" method="post">
                            <input class="form-control" type="text" name="firstname" placeholder="Enter First Name" required>
                            <?php
                            if(!empty($firsterr))
                            {
                            ?>
                            <br>
                            <span class="error"><?php echo $firsterr; ?></span>
                            <?php }?>
                            <br>
                            <input class="form-control" type="text" name="lastname" placeholder="Enter Last Name" required>
                            <?php
                            if(!empty($lasterr))
                            {
                            ?>
                            <br>
                            <span class="error"><?php echo $lasterr; ?></span>

                            <?php }?>
                            <br>
                            <input class="form-control" type="text" name="username" placeholder="Enter Username" required>
                            <?php
                            if(!empty($usererr))
                            {
                            ?>
                            <br>
                            <span class="error"><?php echo $usererr; ?></span>

                            <?php }?>
                            <br>
                            <input class="form-control" type="password" name="password" placeholder="Enter Password" required>
                            <?php
                            if(!empty($passerr))
                            {
                            ?>
                            <br>
                            <span class="error"><?php echo $passerr; ?></span>

                            <?php }?>
                            <br>
                            <input class="form-control" type="password" name="confirmpass" placeholder="Enter Confirm Password" required>
                            <?php
                            if(!empty($conpasserr))
                            {
                            ?>
                            <br>
                            <span class="error"><?php echo $conpasserr; ?></span>

                            <?php }?>
                            <br>
                            <input class="form-control" type="text" name="roll" placeholder="Enter Enrollment No." required>
                            <?php
                            if(!empty($enrolerr))
                            {
                            ?>
                            <br>
                            <span class="error"><?php echo $enrolerr; ?></span>

                            <?php }?>
                            <br>
                            <input class="form-control" type="text" name="email" placeholder="Enter Email Address" required>
                            <?php
                            if(!empty($emailerr))
                            {
                            ?>
                            <br>
                            <span class="error"><?php echo $emailerr; ?></span>

                            <?php }?>
                            <br>
                            <input class="form-control" type="number" name="phone" placeholder="Enter Phone number" required>
                            <?php
                            if(!empty($phonerr))
                            {
                            ?>
                            <br>
                            <span class="error"><?php echo $phonerr; ?></span>

                            <?php }?>
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