<?php
ob_start();
$title="Books";
include "navbar.php";
?>
<!DOCTYPE html>
<html>

    <body>
        <?php
        if(isset($_POST['addBtn'])) {
            unset($_SESSION['book']);
            header("Location: add.php");
        }
        ?>
        <div class="wrapper" id="main">
            <div class="box full-box log-pad">
                <div class="box-content box-form">
                    <div class="container">
                        <h1 class="text-center">List of Books</h1>
                        <?php
                        if(isset($_SESSION['msg'])) {
                            echo "<br><span class='error success'>";echo $_SESSION['msg'];echo"</span>";
                            unset($_SESSION['msg']);
                        }
                        ?>
                        <!--search bar-->
                        <div class="text-right search-box">
                            <form class="navbar-form" method="post" name="form1">
                                <div class="row">
                                    <div class="col-3">
                                        <input type="text" class="form-control" type="text" name="search" placeholder="search books..">
                                    </div>
                                    <div class="col-3">
                                        <button type="submit" name="srchBtn" class="btn btn-primary left">
                                            <i class="fas fa-search"></i>
                                        </button>
                                    </div>
                                    <?php
                                    if(isset($_SESSION['login_admin'])) {
                                    ?>
                                    <div class="col-6">
                                        <button type="submit" name="addBtn" class="btn btn-primary right">Add Book</button>
                                    </div>
                                    <?php
                                    }
                                    ?>
                                </div>
                            </form>
                        </div>
                        <?php
                        if(isset($_POST['srchBtn']))
                        {
                            $query=mysqli_query($db,"SELECT * from books where name like '%$_POST[search]%' ");

                            if(mysqli_num_rows($query)==0)
                            {
                                $noRowMsg="Sorry! No book found.";
                            }
                        }
                        else {
                            $query=mysqli_query($db,"select * from `books`");

                            if(mysqli_num_rows($query)==0)
                            {
                                $noRowMsg="No book added yet.";
                            }
                        }
                        echo "<table class='table table-bordered text-center'>";
                        echo "<thead>";
                        echo "<tr>";
                        echo "<th>";echo "Book Name";echo "</th>";
                        echo "<th>";echo "Authors";echo "</th>";
                        echo "<th>";echo "Edition";echo "</th>";
                        echo "<th>";echo "publisher";echo "</th>";
                        echo "<th>";echo "price";echo "</th>";
                        echo "<th>";echo "Quantity";echo "</th>";
                        echo "<th>";echo "Department";echo "</th>";
                        if(isset($_SESSION['login_admin']))
                        {
                            echo "<th>";echo "PurchaseDate";echo "</th>";

                            echo "<th>";echo "Action";echo "</th>";
                        }
                        echo "</tr>";
                        echo "</thead>";
                        if(!empty($noRowMsg))
                        {
                            if(isset($_SESSION['login_admin']))
                            {
                                echo "<td colspan=9>{$noRowMsg}</td>";
                            }
                            else {
                                echo "<td colspan=7>{$noRowMsg}</td>";
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
                                echo "<td>";echo "£{$row['price']}";echo "</td>";
                                echo "<td>";echo $row['quantity'];echo "</td>";
                                echo "<td>";echo $row['department'];echo "</td>";
                                if(isset($_SESSION['login_admin']))

                                {
                                    echo "<td>";echo $row['purchaseDate'];echo "</td>";    
                                    echo "<td class='back-white action'>"; 
                                    echo "<div class='row'>";
                                    echo "
                                          <div class='col-3'>
                                          <form method='post' name='edit-book' action='add.php'>
                                          <input type='hidden' name='book' value='{$row['bookID']}'>
                                          <button type='submit' name='edit' class='link-button colr-blue'>Edit</button>&nbsp
                                          </form>
                                          </div>
                                          ";
                                    echo "
                                          <div class='col-3'>
                                          <form method='post' name='delete-book' action='delete-book.php'>
                                          <input type='hidden' name='bookID' value='{$row['bookID']}'>
                                          <input type='hidden' name='name' value='{$row['name']}'>
                                          <button type='submit' name='delete' class='link-button colr-red'>Delete</button>
                                          </form>
                                          </div>
                                          ";
                                    echo "</div>";
                                    echo "</td>";
                                }

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