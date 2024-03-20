<?php 
    // including all files that we need
    include 'db_conn.php';
    use PHPMailer\PHPMailer\PHPMailer;
    require 'phpmailer/src/Exception.php';
    require 'phpmailer/src/PHPMailer.php';
    require 'phpmailer/src/SMTP.php';

    //to check if submit button is set by the help of POST method
    if(isset($_POST['submit'])){
        
        //Function that sanitize user inputs from sql injection
        function validate($data) {
            $data = trim($data);
            $data = stripslashes($data);
            $data = htmlspecialchars($data);
            return $data;
        }
        //Phpmailer function that we need to send mail
        function sendemail_verify($firstname,$email, $verify_token, $otp){
            $mail = new PHPMailer(true);

            $mail-> isSMTP();
            $mail->Host = 'smtp.gmail.com';
            $mail->SMTPAuth = true;
            $mail->Username = 'julybatuto@gmail.com';
            $mail->Password = 'ajll duzr qpxo vdbb';
            $mail->SMTPSecure = 'ssl';
            $mail->Port = 465;
    
            $mail->setFrom('julybatuto@gmail.com');
            $mail->addAddress($email);
            $mail->isHTML(true);
    
            $mail->Subject ="Email Verification for logging in";
            $email_message = "
                <h2>Hi $firstname! We are happy that you signed up with us.</h2><br>
                <h3>Use this OTP to verify your account: <b>$otp</b></h3>
                <h3>
                    To verify your email address just click the link given below.
                </h3>
                <br><br>
                <h3><a href='http://localhost/lab-3/verifyemail.php?token=$verify_token'>Click Here</a></h3>                
            
            ";
            $mail->Body = $email_message;
            $mail->send();
        }

        //initializing variables and sanitizing them using validate function
        $firstname      = validate($_POST['firstname']);
        $middlename     = validate($_POST['middlename']);
        $lastname       = validate($_POST['lastname']);
        $email          = validate($_POST['email']);
        $status         = validate($_POST['status']);
        $uname          = validate($_POST['username']);
        $password       = validate($_POST['password']);
        $otp            = substr(str_shuffle("0123456789"), 0, 5);
        $verify_token   = md5(rand());

        //veryfying if the email and username input is unique
        $vfy_email = mysqli_query($conn, "SELECT Email FROM user WHERE Email = '$email'");
        $vfy_uname = mysqli_query($conn, "SELECT Username FROM user WHERE username = '$uname'");
        
        //checking the condition and trowing error 
        if(mysqli_num_rows($vfy_email) > 0) {
            header("Location: register.php?error=Email is already used!");
        } else if(mysqli_num_rows($vfy_uname) > 0) {
            header("Location: register.php?error=User name is already used!"); 
        } 
        //this else run when there is no error and inserts user inputs to database
        else {
            $sql = "INSERT INTO user (First_name, Middle_name, Lastname, Email, Status, username, password, verify_token, verification_code)
            VALUES ('$firstname', '$middlename','$lastname', '$email', '$status', '$uname', '$password', '$verify_token', '$otp')";
            $result = mysqli_query($conn, $sql);

            //if the inserting process successed it will send email and show an success message
            if($result){
                sendemail_verify("$firstname","$email","$verify_token","$otp");
                header("Location: register.php?success=You've successfully created account!". 
                " We've send email please verify your email address");
            }
        }
    }
?>
