<?php
ob_start();
$title="Book Requests";
include "navbar.php";
if(!isset($_SESSION['login_user'])) {
    header("Location: student-login.php");
}
?>
<!DOCTYPE html>
<html>

    <body>
        <?php
        if(isset($_POST['cancleBtn'])) {
            if(mysqli_query($db,"DELETE FROM requested_book WHERE requestID='$_POST[requestID]'")) {
                $_SESSION['msg']="Request Cancled Successfully.";
            }
            else {
                $error="Request cancellation is unsuccessfull.";
            }
        } 
        ?>
        <div id="main" class="wrapper">

            <div class="box full-box log-pad">
                <div class="box-content box-form">
                    <div class="container">
                        <h1>Book Request Status</h1>
                        <?php
                        if(isset($_SESSION['msg'])) {
                            echo "<br><span class='error success'>{$_SESSION['msg']}</span><br>";
                            unset($_SESSION['msg']);
                        }
                        if(!empty($error)) {
                            echo "<br><span class='error'>{$error}</span><br>";               
                        }
                        $q=mysqli_query($db,"SELECT b.name, r.request_date, r.requestID FROM books b inner join requested_book r ON r.bookID=b.bookID WHERE  NOT EXISTS (SELECT i.requestID FROM issued_book i WHERE  i.requestID = r.requestID) && r.studentID='$_SESSION[user]'");
                        echo "<table class='table table-bordered' >";
                        echo "<tr>";

                        echo "<th>"; echo "Book Name";  echo "</th>";
                        echo "<th>"; echo "Request Date";  echo "</th>";
                        echo "<th>"; echo "Approve Status";  echo "</th>";
                        echo "<th>Action</th>";

                        echo "</tr>";
                        if(mysqli_num_rows($q)==0)
                        {
                            echo "<td colspan=4>There's no pending request</td>";
                        }
                        else
                        {


                            while($row=mysqli_fetch_assoc($q))
                            {
                                echo "<tr>";
                                echo "<td>"; echo $row['name']; echo "</td>";

                                echo "<td>"; echo $row['request_date']; echo "</td>";
                                echo "<td>"; echo "Pending"; echo "</td>";
                                echo "<td>
                        <form method='post'>
                        <input type='hidden' name='requestID' value='{$row['requestID']}'>
                        <button class='btn btn-danger' name='cancleBtn'>Cancle</button>
                        </form>
                    </td>";
                                echo "</tr>";
                            }
                            echo "</table>";
                        }
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