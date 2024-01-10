<?php
$title="Borrowed Books";
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
        if(isset($_POST['returnBtn'])) {
            $today=date("Y-m-d");
            $insertQuery="INSERT INTO returned_book VALUES ('','$_POST[issueID]','$_SESSION[admin]','$today');";

            $quanQuary="UPDATE books SET quantity = quantity+1 where bookID='$_POST[bid]' ;";

            if(mysqli_query($db,$insertQuery)) {
                if(mysqli_query($db,$quanQuary)) {
                    if($_POST['days']>0){
                        $res=mysqli_query($db,"SELECT returnID FROM returned_book WHERE issueID='$_POST[issueID]'");
                        while($row=mysqli_fetch_assoc($res))
                        {
                            $returnID=$row['returnID'];

                        }
                        $fineQuary="INSERT INTO fines VALUES ('', '$returnID', '$_POST[days]', '$_POST[fine]', 'unpaid');";
                        mysqli_query($db,$fineQuary);
                    }
                    $success="Book returned successfully";
                }
                else
                {
                    $error="Error: Book Quantity not updated";
                }
            }
            else {
                $error="Failed to return book";
            }
        }
        ?>
        <div class="wrapper" id="main">

            <div class="box full-box log-pad">
                <div class="box-content box-form">
                    <div class="container">
                        <h1>Borrowed Books</h1><br>
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
                                        <button class="btn btn-primary" type="submit" name="borrowBtn">Borrowed</button>
                                        <button class="btn btn-primary" type="submit" name="expireBtn">Expired</button>
                                        <button class="btn btn-primary" type="submit" name="returnedBtn">Returned</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                        <?php
                        if(!empty($success)) {
                            echo "<span class='error success'>$success</span>";
                        }
                        if(!empty($error)) {
                            echo "<span class='error'>$error</span>";
                        }
                        if(isset($_POST['srchBtn'])) {
                            $query=mysqli_query($db,"SELECT s.username, s.enrollmentNo, b.bookID, b.name, b.authors, b.edition, i.issue_date, i.return_date, i.issueID FROM students s inner join requested_book r ON s.studentID=r.studentID inner join books b ON r.bookID=b.bookID INNER JOIN issued_book i ON i.requestID=r.requestID WHERE s.username like '%$_POST[search]%' ORDER BY i.issueID DESC");
                            if(mysqli_num_rows($query) == 0)
                            {
                                $noRowMsg="No data found.";
                            }
                        }
                        else if(isset($_POST['borrowBtn'])) {
                            $query=mysqli_query($db,"SELECT s.username, s.enrollmentNo, b.bookID, b.name, b.authors, b.edition, i.issue_date, i.return_date, i.issueID FROM students s inner join requested_book r ON s.studentID=r.studentID inner join books b ON r.bookID=b.bookID INNER JOIN issued_book i ON i.requestID=r.requestID WHERE  NOT EXISTS (SELECT ret.issueID FROM returned_book ret WHERE ret.issueID=i.issueID)");
                            if(mysqli_num_rows($query) == 0)
                            {
                                $noRowMsg="There isn't any book borrowed.";
                            }
                        }
                        else if(isset($_POST['expireBtn'])) {
                            $query=mysqli_query($db,"SELECT s.username, s.enrollmentNo, b.bookID, b.name, b.authors, b.edition, i.issue_date, i.return_date, i.issueID FROM students s inner join requested_book r ON s.studentID=r.studentID inner join books b ON r.bookID=b.bookID INNER JOIN issued_book i ON i.requestID=r.requestID WHERE  NOT EXISTS (SELECT ret.issueID FROM returned_book ret WHERE ret.issueID=i.issueID) && i.return_date < CURDATE()");
                            if(mysqli_num_rows($query) == 0)
                            {
                                $noRowMsg="There isn't any book expired.";
                            }  
                        }
                        else if(isset($_POST['returnedBtn'])) {
                            $query=mysqli_query($db,"SELECT s.username, s.enrollmentNo, b.bookID, b.name, b.authors, b.edition, i.issue_date, i.return_date, i.issueID FROM students s inner join requested_book r ON s.studentID=r.studentID inner join books b ON r.bookID=b.bookID INNER JOIN issued_book i ON i.requestID=r.requestID INNER JOIN returned_book ret ON ret.issueID=i.issueID");
                            if(mysqli_num_rows($query) == 0)
                            {
                                $noRowMsg="There isn't any book returned.";
                            }
                        }
                        else {
                            $query=mysqli_query($db,"SELECT s.username, s.enrollmentNo, b.bookID, b.name, b.authors, b.edition, i.issue_date, i.return_date, i.issueID FROM students s inner join requested_book r ON s.studentID=r.studentID inner join books b ON r.bookID=b.bookID INNER JOIN issued_book i ON i.requestID=r.requestID ORDER BY i.issueID DESC");
                            if(mysqli_num_rows($query) == 0)
                            {
                                $noRowMsg="No data found.";
                            }
                        }
                        echo "<table class='table table-bordered'>";
                        //Table header

                        echo "<tr>";
                        echo "<th>"; echo "Username";  echo "</th>";
                        echo "<th>"; echo "Enroll No";  echo "</th>";
                        echo "<th>"; echo "Book Name";  echo "</th>";
                        echo "<th>"; echo "Authors Name";  echo "</th>";
                        echo "<th>"; echo "Edition";  echo "</th>";
                        echo "<th>"; echo "Issue Date";  echo "</th>";
                        echo "<th>"; echo "Return Date";  echo "</th>";
                        echo "<th>"; echo "Day/Fine";  echo "</th>";
                        echo "<th>"; echo "Total Fine";  echo "</th>";
                        echo "<th>"; echo "Status";  echo "</th>";
                        echo "<th>"; echo "Action";  echo "</th>";

                        echo "</tr>";

                        if(!empty($noRowMsg))
                        {
                            echo "<td colspan=11>{$noRowMsg}</td>";
                        }
                        else
                        {
                            $i=0;
                            while($row=mysqli_fetch_assoc($query))
                            {
                                ${"status$i"}="";

                                $retQuery=mysqli_query($db,"SELECT returnedDate FROM returned_book WHERE issueID='$row[issueID]'");
                                if(mysqli_num_rows($retQuery) > 0)
                                {
                                    $statusMsg="Returned";
                                }
                                else {
                                    $statusMsg="Borrowed";
                                }

                                if($statusMsg =='Returned') {
                                    while($retRow=mysqli_fetch_assoc($retQuery)) {
                                        $actualDate=$retRow['returnedDate'];
                                    }
                                }
                                else {
                                    $actualDate=date("Y-m-d");
                                }
                                $today=floor(strtotime($actualDate)/(60*60*24));
                                $returnDay=floor(strtotime($row['return_date'])/(60*60*24));
                                $overDays=$today-$returnDay;
                                if($overDays > 0) {
                                    $totalFine= number_format($overDays*0.50, 2);
                                }
                                else {
                                    $totalFine=0;
                                }    
                                if($totalFine > 0 && $statusMsg=='Borrowed') {
                                    $statusMsg='Overdue';
                                }
                                ${"status$i"}=$statusMsg;
                                echo "<tr>";
                                echo "<td>"; echo $row['username']; echo "</td>";
                                echo "<td>"; echo $row['enrollmentNo']; echo "</td>";
                                echo "<td>"; echo $row['name']; echo "</td>";
                                echo "<td>"; echo $row['authors']; echo "</td>";
                                echo "<td>"; echo $row['edition']; echo "</td>";
                                echo "<td>"; echo $row['issue_date']; echo "</td>";
                                echo "<td>"; echo $row['return_date']; echo "</td>";
                                echo "<td>£0.5</td>";
                                echo "<td>£$totalFine</td>";
                                echo "<td>${"status$i"}</td>";
                                echo "<td>";
                                if(${"status$i"}=='Borrowed' || ${"status$i"}=='Overdue')
                                    echo"<form method='post'>
                                        <input type='hidden' name='issueID' value='{$row['issueID']}'>
                                        <input type='hidden' name='bid' value='{$row['bookID']}'>
                                        <input type='hidden' name='fine' value='{$totalFine}'>
                                        <input type='hidden' name='days' value='{$overDays}'>
                                        <button class='btn btn-primary' name='returnBtn'>Return</button>
                                        </form>";
                                echo "</td>";
                                echo "</tr>";
                                $i++;
                            }
                        }
                        echo "</table>";
                        ?>
                    </div>
                </div>
            </div>
        </div>
        <?php
        include "../footer.php";
        ?>
    </body>
</html>