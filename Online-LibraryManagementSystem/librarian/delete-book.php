<?php
ob_start();
$title="Delete Book";
include "navbar.php";
if(!isset($_SESSION['admin']))
{
    header("Location: admin-login.php");
}
?>
<!DOCTYPE html>
<html lang="en">
    <body>
        <?php
        if(isset($_POST['cancleBtn']))
        {
            header("Location: books.php");
        }
        if(isset($_POST['deleteBtn'])) {
            if(mysqli_query($db,"DELETE from books where bookID = '$_POST[bookID]'; ")) {
                $_SESSION['msg']= 'Book deleted successfully';
                header("Location: books.php");
            }
            else
            {
                $_SESSION['msg']="fail to delete";
                header("Location: books.php");
            }
        }
        ob_end_flush();
        ?>
        <div class="wrapper" id="main">	
            <br>
            <div class="box">
                <div class="box-content box-home">
                    <h1>Are You Sure You Want to Delete this Book?</h1><br>
                    <h2><b>Book Name: </b><?php echo $_POST['name']?></h2><br>
                    <form method="post">
                        <input type="hidden" name="bookID" value="<?php echo $_POST['bookID']?>">
                        <button class="btn btn-primary" type="submit" name="cancleBtn">Cancle</button>&nbsp;<button class="btn btn-danger" type="submit" name="deleteBtn">Delete</button>
                    </form>
                </div>
            </div>


        </div>
    <?php  

    include "../footer.php";
    ?>
    </body>
</html>