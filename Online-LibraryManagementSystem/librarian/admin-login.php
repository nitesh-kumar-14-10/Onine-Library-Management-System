<?php
$title="Librarian Login";
include "navbar.php";
if(isset($_SESSION['user'])) {
    header("Location: ../logout.php");
}
if(isset($_SESSION['admin'])) {
    header("Location: books.php");
}
?>
<!DOCTYPE html>
<html lang="en">
    <head>
    </head>
    <body>
        <?php
        if(isset($_POST['login']))
        {
            $count=0;
            $res=mysqli_query($db,"Select id, username, password from `admin` where username='$_POST[username]';");
            $row=mysqli_fetch_assoc($res);
            $count=mysqli_num_rows($res);
            if($count > 0 && password_verify($_POST['password'], $row['password']))
            {
                $_SESSION['login_admin'] = $_POST['username'];
                $_SESSION['admin']= $row['id'];
                header("Location: books.php");

            }
            else
            {                    
                $error="username or password incorrect";
            }
        }
        ?>
        <div class="wrapper" id="main">

            <br>
            <div class="box">
                <div class="box-content box-form">
                    <h1>Library Management System</h1>
                    <h2>Login Form</h2>
                    <?php
                    if(isset($_SESSION['msg'])) {
                        echo "<span class='error success'>";echo $_SESSION['msg'];echo"</span>";
                        unset($_SESSION['msg']);
                    }
                    ?>
                    <div class="form-wrapper">
                        <form action="" name="loginForm" method="post">
                            <br><br><input class="form-control" type="text" name="username" placeholder="Enter Username" required><br><br>
                            <input class="form-control" type="password" name="password" placeholder="Enter Password" required><br><br>
                            <button class="btn btn-primary" name="login">Login</button>
                        </form>
                    </div>
                    <p>Forgot Password? <a href="update_password.php">Click here</a></p>
                    <?php
                    if(!empty($error))
                    {
                        echo "<br>";
                        echo "<span class='error'>"; echo $error; echo"</span>";
                    }
                    ?>
                </div>
            </div>
        </div>
        <?php
        include "../footer.php";
        ?>
    </body>
</html>