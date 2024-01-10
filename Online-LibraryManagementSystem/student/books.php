<?php
ob_start();
$title="Books";
include "navbar.php";
?>
<!DOCTYPE html>
<html>
    <head>
    </head>
    <body>
        <?php
        if(isset($_POST['requestBtn']))
        {
            $today=date("Y-m-d");
            if(mysqli_query($db,"INSERT INTO requested_book Values('','$_SESSION[user]', '$_POST[bid]', '$today');")) {
                if(mysqli_query($db,"UPDATE books SET quantity = quantity-1 where bookID='$_POST[bid]' ;")) {
                    $_SESSION['msg']="Book request sent to Librarian.";
                    header("Location: request.php");
                }

            }

        }
        ?>
        <div class="wrapper" id="main">

            <div class="box full-box log-pad">
                <div class="box-content box-form">
                    <div class="container">
                        <h1 class="text-center">List of Books</h1>

                        <!--------search bar------->

                        <div class="text-right search-box">
                            <form class="navbar-form" method="post" name="form1">
                                <div class="row">
                                    <div class="col-3">
                                        <input type="text" class="form-control" type="text" name="search" placeholder="search books..">
                                    </div>
                                    <div class="text-right">
                                        <button type="submit" name="srchBtn" class="btn btn-primary">
                                            <i class="fas fa-search"></i>
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <?php
                        if(isset($_POST['srchBtn'])) {
                            $query=mysqli_query($db,"SELECT * from books where name like '%$_POST[search]%'");
                            if(mysqli_num_rows($query) == 0)
                            {
                                $noRowMsg="No Search result.";
                            }
                        }
                        else {
                            $query=mysqli_query($db,"select * from `books`");
                            if(mysqli_num_rows($query) == 0)
                            {
                                $noRowMsg="No book added yet.";
                            }
                        }

                        echo "<table class='table table-bordered text-center'>";
                        echo "<thead>";
                        echo "<tr>";
                        echo "<th>";echo "Book Name";echo "</th>";
                        echo "<th>";echo "Author Name";echo "</th>";
                        echo "<th>";echo "Edition";echo "</th>";
                        echo "<th>";echo "Publisher";echo "</th>";
                        echo "<th>";echo "Quantity";echo "</th>";
                        echo "<th>";echo "Department";echo "</th>";

                        if(isset($_SESSION['login_user']))
                        {
                            echo "<th>";echo "Action";echo "</th>";
                        }
                        echo "</tr>";
                        echo "</thead>";
                        if(!empty($noRowMsg))
                        {
                            if(isset($_SESSION['login_user']))
                            {
                                echo "<td colspan=7>{$noRowMsg}</td>";
                            }
                            else {
                                echo "<td colspan=6>{$noRowMsg}</td>";
                            }
                        }
                        else
                        {
                            while($row=mysqli_fetch_assoc($query))
                            {
                                echo "<tr>";
                                echo "<td>";echo $row['name'];echo "</td>";
                                echo "<td>";echo $row['authors'];echo "</td>";
                                echo "<td>";echo $row['edition'];echo "</td>";
                                echo "<td>";echo $row['publisher'];echo "</td>";
                                echo "<td>";echo $row['quantity'];echo "</td>";
                                echo "<td>";echo $row['department'];echo "</td>";

                                if(isset($_SESSION['login_user']))
                                {
                                    //Return Requested Book List
                                    $reqQuery=mysqli_query($db,"SELECT b.name FROM books b inner join requested_book r ON r.bookID=b.bookID WHERE  NOT EXISTS (SELECT i.requestID FROM issued_book i WHERE  i.requestID = r.requestID) && b.bookID='$row[bookID]' && r.studentID='$_SESSION[user]'");
                                    //Return Issued Book List
                                    $issuQuery=mysqli_query($db,"SELECT b.name FROM students s inner join requested_book r ON s.studentID=r.studentID inner join books b ON r.bookID=b.bookID INNER JOIN issued_book i ON i.requestID=r.requestID WHERE  NOT EXISTS (SELECT ret.issueID FROM returned_book ret WHERE ret.issueID=i.issueID) && s.studentID='$_SESSION[user]' && b.bookID='$row[bookID]'");
                                    //Return Returned Book List
                                    $retQuery=mysqli_query($db,"SELECT b.name FROM students s inner join requested_book r ON s.studentID=r.studentID inner join books b ON r.bookID=b.bookID INNER JOIN issued_book i ON i.requestID=r.requestID INNER JOIN returned_book ret ON ret.issueID=i.issueID WHERE s.studentID='$_SESSION[user]' && b.bookID='$row[bookID]'");
                                    //Return Issued Book List but return date is over
                                    $OverQuery=mysqli_query($db,"SELECT b.name FROM students s inner join requested_book r ON s.studentID=r.studentID inner join books b ON r.bookID=b.bookID INNER JOIN issued_book i ON i.requestID=r.requestID WHERE  NOT EXISTS (SELECT ret.issueID FROM returned_book ret WHERE ret.issueID=i.issueID) && i.return_date < CURDATE() && s.studentID='$_SESSION[user]' && b.bookID='$row[bookID]'");
                                    //Return Book List Which has unpaid fine
                                    $fineQuery=mysqli_query($db,"SELECT b.name FROM fines f INNER JOIN returned_book r ON f.returnID=r.returnID INNER JOIN issued_book i ON i.issueID= r.issueID INNER JOIN requested_book req ON req.requestID=i.requestID INNER JOIN students s ON s.studentID=req.studentID INNER JOIN books b ON b.bookID=req.bookID WHERE f.status='unpaid' && s.studentID='$_SESSION[user]' && b.bookID='$row[bookID]'");
                                    if(mysqli_num_rows($reqQuery) > 0)
                                    {
                                        $status="Requested";
                                    }
                                    else if(mysqli_num_rows($issuQuery) > 0) {
                                        if(mysqli_num_rows($OverQuery)>0) {
                                            $status="Overdue";
                                        }
                                        else {
                                            $status="Borrowed";
                                        }
                                    }
                                    else if(mysqli_num_rows($retQuery)>0) {

                                        if(mysqli_num_rows($fineQuery)>0) {
                                            $status="unpaid fine";
                                        }
                                        else {
                                            $status="Returned";
                                        }

                                    }
                                    else {
                                        $status="";
                                    }

                                    echo "<td>";
                                    if(!empty($status) && $status !='Returned') {

                                        echo "$status";
                                    }
                                    else {

                                        if($row['quantity'] >0) {
                                            echo "
                                                  <form method='post' name='book-request'>
                                                  <input type='hidden' name='bid' value='{$row['bookID']}'>
                                                  <button type='submit' name='requestBtn' class='btn btn-primary'>Request</button>
                                                  </form>
                                                  ";
                                        }
                                        else {
                                            echo "Unavailable";
                                        }
                                    }  

                                    echo "</td>";
                                }
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