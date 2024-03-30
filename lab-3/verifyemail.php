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
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>OTP Verify</title>
    <!-- Add Bootstrap CSS link -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
    body {
      height: 100vh;
      display: flex;
      justify-content: center;
      align-items: center;
      background-color: #f8f9fa;
    }
    .container {
        width: 30%;
      background-color: #fff;
      padding: 15px;
      border-radius: 5px;
      box-shadow: 0px 0px 10px 0px rgba(0, 0, 0, 0.5);
    }
    h2 {
      margin-bottom: 20px;
    }
    input[type="text"] {
      width: 40%;
      padding: 10px;
      margin-bottom: 20px;
      border: 1px solid #ced4da;
      border-radius: 5px;
      box-sizing: border-box;
    }
    button[type="submit"] {
      padding: 10px 20px;
      background-color: #228B22;
      color: #fff;
      border: none;
      border-radius: 5px;
      cursor: pointer;
    }
    button[type="submit"]:hover {
      background-color: #0056b3;
    }
  </style>
</head>
<body>
  <div class="container text-center justify-content-center">
    <form action="" method="post">
      <h2>Verifying your account</h2>
      <input type="text" name="otp" placeholder="Enter OTP">
      <div class="pt-2"></div>
      <button type="submit" name="verify">Verify</button>
    </form>
  </div>
</body>
</html>
