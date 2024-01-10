<?php
include "../connection.php";
session_start();
?>
<!DOCTYPE html>
<html lang="en">

    <head>
        <!-- Required meta tag -->
        <meta charset="UTF-8">
        <meta name="description" content="Library, inline Library">
        <meta name="keywords" content="HTML5, CSS3, javaScript, Bootstrap4, jQuery, Web Design, Web Development, Responsive Website, Online library management system, Library, Books, Student, Librarian">
        <meta name="author" content="Izaz Shaikh">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="veiwport" content="width=device-width, initial-scale=1.0">
        <title><?php echo $title; ?></title>
        <!-- Bootstrap minified CSS-->
        <link rel="stylesheet" href="/LibraryManagementSystem-PHP/content/css/bootstrap/bootstrap.min.css">
        <!-- Fontawesome CSS-->
        <link rel="stylesheet" href="/LibraryManagementSystem-PHP/content/css/fontawsome/css/all.min.css">
        <!-- Custome CSS for the site -->
        <link rel="stylesheet" href="/LibraryManagementSystem-PHP/content/css/lms.css">
    </head>

    <body>
        <header>
            <nav class="navbar navbar-expand-lg fixed-top navbar-dark back-black">
                <a class="navbar-brand text-center" href="index.php"><img src="/LibraryManagementSystem-PHP/content/images/WhiteLogo.png"><br>
                    <p>ONLINE LIBRARY MANAGEMENT SYSTEM</p>
                </a>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#lms-nav-content" aria-controls="lms-nav-content" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="lms-nav-content">
                    <ul class="navbar-nav mr-auto">
                        <li class="nav-item">
                            <a class="nav-link" href="../index.php">HOME</a>
                        </li>
                        <?php      
                        if(isset($_SESSION['login_admin']))
                        {

                        ?>
                        <li class="nav-item">
                            <a class="nav-link" href="feedback.php">FEEDBACK
                            </a>
                        </li>
                        <?php
                        }
                        else {
                        ?>
                        <li class="nav-item">
                            <a class="nav-link" href="books.php">BOOKS</a>
                        </li>

                        <?php
                        }
                        ?>
                    </ul>
                    <ul class="navbar-nav ml-auto">

                        <?php
                        if(isset($_SESSION['login_admin']))
                        {

                        ?>
                        <li class="nav-item">
                            <a class="nav-link">
                                <?php
                            echo "HI, ".$_SESSION['login_admin']; 
                                ?>
                            </a>
                        </li>
                        <li class="nav-item"><a class="nav-link" href="profile.php">PROFILE</a></li>
                        <li class="nav-item"><a class="nav-link" href="student.php">STUDENT-INFO</a></li>
                        <li class="nav-item">
                            <a class="nav-link" href="registration.php">REGISTRATION</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="../logout.php">LOGOUT</a>
                        </li>
                        <?php
                        }
                        else
                        {
                        ?>
                        <li class="nav-item">
                            <a class="nav-link" href="admin-login.php">LOGIN</a>
                        </li>

                        <?php
                        }
                        ?>
                    </ul>

                </div>
            </nav>
        </header>
        <!-------sidenav-------->
        <?php
        if(isset($_SESSION['login_admin']))

        {
        ?>
        <div id="mySidenav" class="sidenav back-black">
            <div class="h"> <a href="books.php">Books</a> </div> 
            <div class="h"> <a href="request.php">Book Request</a></div>
            <div class="h"> <a href="issue_info.php">Borrowed Books</a></div>
            <div class="h"><a href="fine.php">FINES</a></div>
        </div>
        <?php
        }
        ?>
        <!-- jQuery library-->
        <script src="/LibraryManagementSystem-PHP/content/js/jquery-3.5.1.min.js"></script>
        <!-- Fontawesome-->
        <script src="/LibraryManagementSystem-PHP/content/js/fontawsome/all.min.js"></script>
        <!-- Popper JS-->

        <!-- Bootstrap JavaScript-->
        <script src="/LibraryManagementSystem-PHP/content/js/bootstrap/bootstrap.min.js"></script>
        <!-- Custom JS-->
        <script type="text/javaScript" src="/LibraryManagementSystem-PHP/content/js/lms.js"></script>
    </body>

</html>