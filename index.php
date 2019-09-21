<?php

session_start();
 

if(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true){
    header("location: welcome.php");
    exit;
}
 

require_once "includes/connection.php";
 
// Define variables and initialize with empty values
$email = $password = ""; $errorMsg = false;

function password($pass) {
    return md5(sha1($pass));
}

// function clean($field) {
//     return mysql_real_escape_string(trim($field));
// }
 
// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST"){
    $email = $_POST['email'];
    $hashed_pass = password($_POST['password']);
    $sql="SELECT * FROM users WHERE `email` = '$email' && `password` = '$hashed_pass'";
    $result = mysqli_query($conn,$sql);
    if($result->num_rows > 0){
        $user = mysqli_fetch_array($result,MYSQLI_ASSOC);
        session_start();
                            
        // Store data in session variables
        $_SESSION["loggedin"] = true;
        $_SESSION["user"] = $user;   
        $_SESSION["email"] = $email;                       
        
        // Redirect user to welcome page
        header("location: welcome.php");;
    }else{
        $errorMsg = true;
    };
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Login</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="css/style.css" rel="stylesheet" type="text/css">
    <script
  src="https://code.jquery.com/jquery-3.3.1.js"
   ></script>
</head>
<body>
    <div class="login-reg-panel">
        <div class="login-info-box">
            <p class="sign-in">Sign In</p>
            <p>Already a member? Click the button below to Log in.</p>
            <label id="label-register" for="log-reg-show">Login</label>
            <input type="radio" name="active-log-panel" id="log-reg-show"  checked="checked">
        </div>
        <div class="register-info-box">
            <p class="sign-up">Sign Up Now!</p>
            <p>Want to join us? You can sign up by clicking the button below</p></p>
            <a href= "register.php" id="label-login" for="log-login-show">Register</a>
            <input type="radio" name="active-log-panel" id="log-login-show">
        </div>


        <div class="white-panel">
            <form action="?" method="post">
            <div class="login-show">
                <p class="sign-in">Sign In</p>
                <?php if($errorMsg) { ?><span class="help-block" style="color:red;">Invalid User Credentails, Check Email and Password</span> <?php } ?>
                <p>Kindly input your details to access your account</p>
                <div class="form-group <?php echo (!empty($err)) ? 'has-error' : ''; ?>">
                <input type="text"name="email" placeholder="Email" required="" class="form-control" value="<?php echo $email; ?>">
                </div>
                <div class="form-group <?php echo (!empty($err)) ? 'has-error' : ''; ?>">
                <input type="password" name="password" placeholder="Password"  required="" class="form-control">
                </div>
                <button type="submit">Login</button><br/>
                <a href="#">Forgot password?</a>
            </div>
            </form>
        </div>
    </div>
  <script src="js/javascript.js"></script>
</body>
</html>
