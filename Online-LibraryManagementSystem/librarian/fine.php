<?php
$title="Fines";
include "navbar.php";
if(!isset($_SESSION['admin'])) {
    header("Location: admin-login.php");
}
?>
<!DOCTYPE html>
<html>
    <head>

    </head>
    <body>
        <?php
        if(isset($_POST['payBtn'])) {
            $payQuery="UPDATE fines SET status='paid' WHERE fineID='$_POST[fineID]'";
            if(mysqli_query($db,$payQuery)) {
                $success="Fine Successfully paid";
            }
            else {
                $error="Fail to pay fine";
            }
        }
        ?>
        <div class="wrapper" id="main">

            <div class="box full-box log-pad">
                <div class="box-content box-form">
                    <div class="container">
                        <h1 class="text-center">List Of Students</h1>
                        <?php
                        if(!empty($success)) {
                            echo "<span class='error success'>{$success}</span>";
                        }
                        if(!empty($error)) {
                            echo "<span class='erro'>{$error}</span>";
                        }
                        ?>
                        <div class="text-right search-box">
                            <div class="row">
                                <div class="col-6">
                                    <form class="navbar-form" method="post" name="searchForm">
                                        <div class="row">
                                            <div class="col-6">
                                                <input class="form-control" type="text" name="search" placeholder="Student username.." required="">
                                            </div>
                                            <div class="col-6">
                                                <button type="submit" name="srchBtn" class="btn btn-primary left">
                                                    <i class="fas fa-search"></i>
                                                </button>
                                            </div>

                                        </div>
                                    </form>
                                </div>
                                <div class="col-6">
                                    <form method="post">
                                        <button class="btn btn-primary" type="submit" name="unpaidBtn">Unpaid</button>
                                        <button class="btn btn-primary" type="submit" name="paidBtn">Paid</button>
                                    </form>
                                </div>
                            </div>
                        </div>

                        <?php

                        if(isset($_POST['srchBtn'])) {
                            $query=mysqli_query($db,"SELECT s.username,s.enrollmentNo,b.name,b.authors,b.edition,f.fineID,f.daysOver,f.totalFine,f.status FROM fines f INNER JOIN returned_book r ON f.returnID=r.returnID INNER JOIN issued_book i ON i.issueID= r.issueID INNER JOIN requested_book req ON req.requestID=i.requestID INNER JOIN students s ON s.studentID=req.studentID INNER JOIN books b ON b.bookID=req.bookID where s.username like '%$_POST[search]%';");
                            if(mysqli_num_rows($query) == 0)
                            {
                                $noRowMsg="No Search result.";
                            }

                        }
                        else if(isset($_POST['unpaidBtn'])) {
                            $query=mysqli_query($db,"SELECT s.username,s.enrollmentNo,b.name,b.authors,b.edition,f.fineID,f.daysOver,f.totalFine,f.status FROM fines f INNER JOIN returned_book r ON f.returnID=r.returnID INNER JOIN issued_book i ON i.issueID= r.issueID INNER JOIN requested_book req ON req.requestID=i.requestID INNER JOIN students s ON s.studentID=req.studentID INNER JOIN books b ON b.bookID=req.bookID WHERE f.status='unpaid'");
                            if(mysqli_num_rows($query) == 0)
                            {
                                $noRowMsg="No unpaid fines.";
                            }
                        }
                        else if(isset($_POST['paidBtn'])) {
                            $query=mysqli_query($db,"SELECT s.username,s.enrollmentNo,b.name,b.authors,b.edition,f.fineID,f.daysOver,f.totalFine,f.status FROM fines f INNER JOIN returned_book r ON f.returnID=r.returnID INNER JOIN issued_book i ON i.issueID= r.issueID INNER JOIN requested_book req ON req.requestID=i.requestID INNER JOIN students s ON s.studentID=req.studentID INNER JOIN books b ON b.bookID=req.bookID WHERE f.status='paid'");
                            if(mysqli_num_rows($query) == 0)
                            {
                                $noRowMsg="No Paid Fines.";
                            }
                        }
                        else {
                            $query=mysqli_query($db,"SELECT s.username,s.enrollmentNo,b.name,b.authors,b.edition,f.fineID,f.daysOver,f.totalFine,f.status FROM fines f INNER JOIN returned_book r ON f.returnID=r.returnID INNER JOIN issued_book i ON i.issueID= r.issueID INNER JOIN requested_book req ON req.requestID=i.requestID INNER JOIN students s ON s.studentID=req.studentID INNER JOIN books b ON b.bookID=req.bookID");
                            if(mysqli_num_rows($query) == 0)
                            {
                                $noRowMsg="Fine details has not been added yet.";
                            }
                        }
                        echo "<table class='table table-bordered' >";
                        echo "<tr>";
                        //Table header
                        echo "<th>"; echo " Username ";	echo "</th>";
                        echo "<th>"; echo " Enrollment";	echo "</th>";
                        echo "<th>"; echo " Book Name ";  echo "</th>";
                        echo "<th>"; echo " Authors ";  echo "</th>";
                        echo "<th>"; echo " Edition ";  echo "</th>";
                        echo "<th>"; echo " Days Over";	echo "</th>";
                        echo "<th>"; echo " Fines";  echo "</th>";
                        echo "<th>"; echo " Status ";  echo "</th>";
                        echo "<th>Action</th>";
                        echo "</tr>";
                        if(!empty($noRowMsg))
                        {
                            echo "<td colspan=9>{$noRowMsg}</td>";
                        }
                        else
                        {
                            while($row=mysqli_fetch_assoc($query))
                            {
                                echo "<tr>";

                                echo "<td>"; echo $row['username']; echo "</td>";
                                echo "<td>"; echo $row['enrollmentNo']; echo "</td>";
                                echo "<td>"; echo $row['name']; echo "</td>";
                                echo "<td>"; echo $row['authors']; echo "</td>";
                                echo "<td>"; echo $row['edition']; echo "</td>";
                                echo "<td>"; echo $row['daysOver']; echo "</td>";
                                echo "<td>{$row['totalFine']}</td>";
                                echo "<td>{$row['status']}</td>";
                                echo "<td>";
                                if($row['status']=='unpaid') {
                                    echo "<form method='post'>
                                          <input type='hidden' name='fineID' value='{$row['fineID']}'>
                                          <button class='btn btn-primary' type='submit' name='payBtn'>PAY IT</botton>
                                          </form>";
                                }
                                echo "</td>";

                                echo "</tr>";
                            }
                        }

                        echo "</table>";
                        ?>
                    </div>
                </div>
            </div>
        </div>
    </body>
</html>