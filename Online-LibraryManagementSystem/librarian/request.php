<?php
ob_start();
$title="Book Requests";
include "navbar.php";
if(!isset($_SESSION['admin'])) {
    header("Location: admin-login.php");
}
?>
<!DOCTYPE html>
<html>

    <body>
        <?php

        if(isset($_POST['yesBtn']))
        {
            $issueDate=date("Y-m-d");
            $returnDate=date('Y-m-d', strtotime("+30 days"));
            $query="INSERT INTO issued_book VALUES ('','$_POST[requestID]','$_SESSION[admin]','$issueDate','$returnDate');";
            if(mysqli_query($db,$query)) {
                $success="Book request is successfully approved";
            }
            else {
                $error="fail to approve book request";
            }
        }
        if(isset($_POST['noBtn'])) {
            if(mysqli_query($db,"DELETE FROM requested_book WHERE requestID='$_POST[requestID]'")) {
                $success="Book request cancled successfully";
            }
            else {
                $error="fail to cancle book request";
            }
        }

        ?>
        <div class="wrapper" id="main">
            <div class="box full-box log-pad">
                <div class="box-content box-form"> 

                    <div class="container">

                        <h1 class="text-center">Book Requests</h1>

                        <?php
                        if(!empty($success)) {
                            echo "<span class='error success'>{$success}</span>";
                        }
                        if(!empty($error)) {
                            echo "<span class='error'>{$error}</span>";
                        }
                        $sql= "SELECT s.username, s.enrollmentNo, b.bookID, b.name, b.quantity,r.request_date, r.requestID FROM students s inner join requested_book r ON s.studentID=r.studentID inner join books b ON r.bookID=b.bookID WHERE  NOT EXISTS (SELECT i.requestID FROM issued_book i WHERE  i.requestID = r.requestID)";
                        $res= mysqli_query($db,$sql);

                        echo "<table class='table table-bordered' >";
                        echo "<tr>";
                        //Table header

                        echo "<th>"; echo "Username";  echo "</th>";
                        echo "<th>"; echo "Enrollment No";  echo "</th>";
                        echo "<th>"; echo "Book Name";  echo "</th>";
                        echo "<th>"; echo "Requested Date";  echo "</th>";
                        echo "<th>Left Quantity</th>";
                        echo "<th>Aprove</th>";

                        echo "</tr>";
                        if(mysqli_num_rows($res)==0)
                        {
                            echo "<td colspan=6>There isn't any pending request left</td>";
                        }
                        else
                        {


                            while($row=mysqli_fetch_assoc($res))
                            {
                                echo "<tr>";

                                echo "<td>"; echo $row['username']; echo "</td>";
                                echo "<td>"; echo $row['enrollmentNo']; echo "</td>";
                                echo "<td>"; echo $row['name']; echo "</td>";
                                echo "<td>"; echo $row['request_date']; echo "</td>";
                                echo "<td>"; echo $row['quantity']; echo "</td>";

                                echo "<td class='back-white action text-center'>
                                      <form method='post'>
                                      <input type='hidden' name='requestID' value='{$row['requestID']}'>
                                      <div class='row text-center'>
                                      <div class='col-3 text-center'>                    
                                      <button type='submit' name='yesBtn' class='link-button colr-blue'>Yes</button>&nbsp
                                      </div>
                                      <div class='col-3 text-center'>
                                      <button type='submit' name='noBtn' class='link-button colr-red'>No</button>
                                      </div>
                                      </div>
                                      </form>
                                      </td>";

                                echo "</tr>";
                            }
                        }

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