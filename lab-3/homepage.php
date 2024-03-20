<?php 
session_start();
include "db_conn.php";

if(!isset($_SESSION['status'])){
    header("Location: loginform.php");
}
?>

<!DOCTYPE html>
<html>
<head>    
    <title>Contact Form</title>
    <link rel="stylesheet" href="Stylesheet.css">
</head>
<body>
    <div class="container">
        <form action="" method="POST">
        <h2>Login Successfully!</h2>
            <button  value="button" name="submit">Logout</button>           
        </form>
    </div>
</body>
</html>
<?php 
if(isset($_POST["submit"])) {
    session_start();
    session_destroy();
    header("Location: loginform.php");
}
?>
