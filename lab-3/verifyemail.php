<?php
include 'db_conn.php';
// this will secure the program from vurnabilities
function validate($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}
function getToken($token,$conn){
    $sql = "SELECT * FROM user WHERE verify_token = '$token'";
    $result = mysqli_query($conn, $sql);
    $selectrow = mysqli_fetch_assoc($result);
    $verify_token = $selectrow['verify_token'];

    if($verify_token !== $token){
        echo '<script>alert("Youre not allowed here")</script>'; 
        header("Refresh:9; url=verify-email.php");
    }
}

$token = validate($_GET['token']);
getToken($token,$conn);
if(isset($_POST['verify'])){
    //To get the token from url and check
    if(isset($_GET['token'])){

        $activation_code = $_GET['token'];
        $otp = $_POST['otp'];

        $sql = "SELECT * FROM user WHERE verify_token = '$activation_code'";
        $result = mysqli_query($conn, $sql);

        if(mysqli_num_rows($result) > 0){
            $rowSelect = mysqli_fetch_assoc($result);

            $rowOtp = $rowSelect['verification_code'];
            $token = $rowSelect['verify_token'];

            if($rowOtp !== $otp){
                echo '<script>alert("Please provide correct OTP!")</script>';
            } else {
                $sqlUpdate = "UPDATE user SET is_verified = 'true' WHERE  verification_code= '$otp' 
                AND verify_token = '$activation_code'";

                $result = mysqli_query($conn, $sqlUpdate);
                
                if($result){
                    echo '<script>alert("Your account successfuly activated")</script>'; 
                    header("Refresh:2; url=index.php");
                }
                else{
                    echo '<script>alert("Your account is already activated")</script>'; 
                }
            }
        } else {
            echo '<script>alert("Invalid token")</script>'; 
            header("Refresh:2; url=index.php");
        }
    }
}
?>
<!DOCTYPE html>+
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>OTP Verify</title>
    <!-- Add Bootstrap CSS link -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        html, body {
            height: 100%;
        } 
        input {
            width: 100px;
            height: 40px;
            margin-bottom: 2px;
        }
    </style>
</head>
<body class="d-flex justify-content-center align-items-center">
    <div class="container text-center">
        <form action="" method="post">
            <h2>Verify Your account using the OTP</h2><br>
            <input  type="text" name="otp"><br>
            <button type="submit" name="verify" class="btn btn-primary">Verify</button>
        </form>
    </div>
</body>
</html>