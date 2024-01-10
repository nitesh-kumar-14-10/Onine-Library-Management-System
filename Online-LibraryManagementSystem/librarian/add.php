<?php
ob_start();
session_start();
if(isset($_POST['book']) || isset($_SESSION['book'])) {
    $title="Edit Book";
}
else {
    $title="Add Book";
}
include "navbar.php";
if(!isset($_SESSION['admin']))
{
    header("Location: admin-login.php");
}
?>

<!DOCTYPE html>
<html>
    <head>

    </head>
    <body>
        <?php
        if(isset($_POST['book']))
        {
            $_SESSION['book']=$_POST['book'];
            $sql = "SELECT * FROM books WHERE bookID='$_POST[book]'";
            $result = mysqli_query($db,$sql) or die (mysql_error());

            while ($row = mysqli_fetch_assoc($result)) 
            {
                $name=$row['name'];
                $author=$row['authors'];
                $edition=$row['edition'];
                $price=$row['price'];
                $quantity=$row['quantity'];
                $department=$row['department'];
                $date=$row['purchaseDate'];
                $publisher=$row['publisher'];
            }
        }


        if(isset($_POST['saveBtn']))
        {
            $namErr="";
            $authErr="";
            $edErr="";
            $pricErr="";
            $quanErr="";
            $departErr="";
            $datErr="";
            $publisErr="";

            if(strlen($_POST['name'])<3 ) {
                $namErr="Book name must be atleast 3 characters long";
            }
            else if(strlen($_POST['authors'])<3) {
                $authErr="Author name must be atleast 3 characters long";
            }
            else if(strlen($_POST['edition'])<3) {
                $authErr="edition name must be atleast 3 characters long";
            }
            else if(strlen($_POST['publisher'])<3) {
                $publisErr="publisher name must be atleast 3 characters long";
            }
            else if(!preg_match('/^[0-9]+(\\.[0-9]+)?$/', $_POST['price'])) {
                $pricErr="Invalid Price";
            }
            else if(!filter_var($_POST['quantity'], FILTER_VALIDATE_INT)) {
                $quanErr="Invalid quantity";
            }
            else if(strlen($_POST['department'])<3) {
                $departErr="Department must be atleast 3 characters long";
            }
            else if($_POST['date'] > date("Y-d-m")) {
                $datErr="Date must be todays date or past date";
            }
            else {

                try {
                    if(!isset($_SESSION['book'])) {
                        //$date=date('Y-m-d', strtotime($_POST['date']));
                        mysqli_query($db,"INSERT INTO books VALUES ('','$_POST[name]', '$_POST[authors]', '$_POST[edition]', '$_POST[publisher]', '$_POST[price]', '$_POST[quantity]', '$_POST[department]', '$_POST[date]') ;");
                        $_SESSION['msg']= 'Book added successfully';
                        header("Location: books.php");
                    }
                    else {
                        $sql= "UPDATE books SET name='$_POST[name]', authors='$_POST[authors]', edition='$_POST[edition]', price='$_POST[price]', quantity='$_POST[quantity]', department='$_POST[department]', publisher='$_POST[publisher]', purchaseDate='$_POST[date]' WHERE bookID='".$_SESSION['book']."';";
                        if(mysqli_query($db,$sql))
                        {
                            $_SESSION['msg']= 'book details changed successfully';
                            unset($_SESSION['book']);
                            header("Location: books.php");
                        }
                    }
                }
                catch(Exception $e) {
                    die($e->getMessage());
                }
            }
        }
        if(isset($_POST['cancleBtn'])) {
            unset($_SESSION['book']);
            header("Location: books.php");
        }
        ob_end_flush();
        ?>
        <div class="wrapper" id="main">
            <div class="box">
                <div class="box-content box-form">
                    <div class="container">
                        <?php
                        if(isset($_SESSION['book'])) {
                            echo "<h1 class='text-center'>Edit Book</h1>";
                        }
                        else {
                            echo "<h1 class='text-center'>Add Book</h1>";
                        }
                        ?>
                        <div class="form-wrapper">

                            <form class="book" action="" method="post">

                                <label><h4><b>Book Name: </b></h4></label>
                                <input type="text" name="name" class="form-control" placeholder="Book Name" value="<?php if(isset($_POST['book'])){echo $name;}else{echo isset($_POST['name']) ? $_POST['name'] : '';} ?>" required="">
                                <?php
                                if(!empty($namErr))
                                {
                                    echo "<br>";
                                    echo "<span class='error'>"; echo $namErr; echo "</span>";
                                }?>
                                <br>
                                <label><h4><b>Authors Name: </b></h4></label>
                                <input type="text" name="authors" class="form-control" placeholder="Authors Name" value="<?php if(isset($_POST['book'])){echo $author;}else{echo isset($_POST["authors"]) ? $_POST["authors"]:'';} ?>" required="">
                                <?php
                                if(!empty($authErr))
                                {
                                    echo "<br>";
                                    echo "<span class='error'>"; echo $authErr; echo "</span>";
                                }?>
                                <br>
                                <label><h4><b>Edition: </b></h4></label>
                                <input type="text" name="edition" class="form-control" placeholder="Edition" value="<?php if(isset($_POST['book'])){echo $edition;}else{echo isset($_POST["edition"]) ? $_POST["edition"]: '';} ?>" required="">
                                <?php
                                if(!empty($edErr))
                                {
                                    echo "<br>";
                                    echo "<span class='error'>"; echo $edErr; echo "</span>";
                                }?>
                                <br>
                                <label><h4><b>publisher: </b></h4></label>
                                <input type="text" name="publisher" class="form-control" placeholder="publisher" value="<?php if(isset($_POST['book'])){echo $publisher;}else{echo isset($_POST["publisher"]) ? $_POST["publisher"]: '';} ?>" required="">
                                <?php
                                if(!empty($publisErr))
                                {
                                    echo "<br>";
                                    echo "<span class='error'>"; echo $publisErr; echo "</span>";
                                }?>
                                <br>
                                <label><h4><b>price: </b></h4></label>
                                <input type="text" name="price" class="form-control" placeholder="price" value="<?php if(isset($_POST['book'])){echo $price;}else{echo isset($_POST["price"]) ? $_POST["price"]: '';} ?>" required="">
                                <?php
                                if(!empty($pricErr))
                                {
                                    echo "<br>";
                                    echo "<span class='error'>"; echo $pricErr; echo "</span>";
                                }?>
                                <br>
                                <label><h4><b>Quantity: </b></h4></label>
                                <input type="text" name="quantity" class="form-control" placeholder="Quantity" value="<?php if(isset($_POST['book'])){echo $quantity;}else{echo isset($_POST["quantity"]) ? $_POST["quantity"]: '';} ?>" required="">
                                <?php
                                if(!empty($quanErr))
                                {
                                    echo "<br>";
                                    echo "<span class='error'>"; echo $quanErr; echo "</span>";
                                }?>
                                <br>
                                <label><h4><b>Department: </b></h4></label>
                                <input type="text" name="department" class="form-control" placeholder="Department" value="<?php if(isset($_POST['book'])){echo $department;}else{echo isset($_POST["department"]) ? $_POST["department"]: '';} ?>" required="">
                                <?php
                                if(!empty($departErr))
                                {
                                    echo "<br>";
                                    echo "<span class='error'>"; echo $departErr; echo "</span>";
                                }?>
                                <br>
                                <label><h4><b>Purchase Date: </b></h4></label>
                                <input type="text" name="date" class="form-control" placeholder="purchase date" onfocus="(this.type='date')" value="<?php if(isset($_POST['book'])){echo $date;}else{echo isset($_POST["date"]) ? $_POST["date"]: '';} ?>" required="">
                                <?php
                                if(!empty($datErr))
                                {
                                    echo "<br>";
                                    echo "<span class='error'>"; echo $datErr; echo "</span>";
                                }?>
                                <br>
                                <?php
                                if(isset($_SESSION['book']))
                                {
                                    echo "<button class='btn btn-primary' type='submit' name='saveBtn'>Save</button>&nbsp";
                                    echo "<button class='btn btn-danger' type='submit' name='cancleBtn'>Cancle</button>";
                                }
                                else {
                                    echo "<button class='btn btn-primary' type='submit' name='saveBtn'>ADD</button>";
                                }
                                ?>

                            </form>
                        </div>
                    </div>

                </div>
            </div>
        </div>
        <?php
        include "../footer.php";
        ?>

    </body>
</html>