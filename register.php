<?php

require_once "includes/connection.php";
 
// Define variables and initialize with empty values
$name=$email = $password = $confirm_password = "";
$name_err=$email_err = $password_err = $confirm_password_err = "";
 
// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST"){
    // Validate email
    if(empty(trim($_POST["email"]))){
        $email_err = "Please enter a email.";
    }
    
    // Validate password
    if(empty(trim($_POST["password"]))){
        $password_err = "Please enter a password.";     
    } elseif(strlen(trim($_POST["password"])) < 6){
        $password_err = "Password must have atleast 6 characters.";
    } else{
        $password = trim($_POST["password"]);
    }
    
    // Validate confirm password
    if(empty(trim($_POST["confirm_password"]))){
        $confirm_password_err = "Please confirm password.";     
    } else{
        $confirm_password = trim($_POST["confirm_password"]);
        if(empty($password_err) && ($password != $confirm_password)){
            $confirm_password_err = "Password did not match.";
        }
    }

    function password($pass) {
        return md5(sha1($pass));
    }
    
    if($confirm_password_err == "" && ($password_err == "") && ($email_err == "")){
        $email = $_POST['email'];
        $name = $_POST['name'];
        $hashed_pass = password($_POST['password']);
        $sql="SELECT * FROM users WHERE email = '$email'";
        $result = mysqli_query($conn,$sql);
        if($result->num_rows > 0){
            echo 'User Already Exist';
        }else{
            $sql3 = "INSERT INTO users (`name`, `email`, `password`) VALUES ('$name', '$email', '$hashed_pass')";
        // var_dump($sql3);die();
            if(mysqli_query($conn,$sql3)){
                session_start();
                            
                // Store data in session variables
                $_SESSION["loggedin"] = true; 
                $_SESSION["email"] = $email;  
                
                header('Location: welcome.php');
            } else{
                echo "ERROR: Could not able to execute sql";
            }
        }
    }
    die();
}
?>
 
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Sign Up</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.css">
    <style type="text/css">
        body{ font: 14px sans-serif; }
        .wrapper{ width: 350px; padding: 20px; }
    </style>
    <link href="css/style.css" rel="stylesheet" type="text/css">
</head>
<body>
<header>
<h1>HNGi6.0 TEAM GREATS</h1>
</header>
    <div class="login-reg-panel">
		<div class="register-info-box">
            <p class="sign-up">Sign Up Now!</p>
             <p>Already a member? Click the button below to Log in.</p>
            <a href= "index.php" id="label-login" for="log-login-show">Login</a>
            <input type="radio" name="active-log-panel" id="log-login-show">
        </div>
		
		<div class="white-panel" style="padding: 20px;">
			<form action="?" method="post">
					<h2 class="sign-up">Sign Up</h2>
					<p>Please fill this form to create an account.</p>
			
					<div class="form-group <?php echo (!empty($name_err)) ? 'has-error' : ''; ?>">
						<input type="text" required="" name="name" width="80%" placeholder="Full name" class="form-control" value="<?php echo $name; ?>">
						<span class="help-block"><?php echo $name_err; ?></span>
					</div>    
					<div class="form-group <?php echo (!empty($email_err)) ? 'has-error' : ''; ?>">
					<input type="text" required="" name="email" placeholder="Email address" class="form-control" value="<?php echo $email; ?>">
						<span class="help-block"><?php echo $email_err; ?></span>
					</div>    
					<div class="form-group <?php echo (!empty($password_err)) ? 'has-error' : ''; ?>">
						
						<input type="password" required="" name="password" placeholder="Password" class="form-control" value="<?php echo $password; ?>">
						<span class="help-block"><?php echo $password_err; ?></span>
					</div>
					<div class="form-group <?php echo (!empty($confirm_password_err)) ? 'has-error' : ''; ?>">
						<input type="password" required="" name="confirm_password" placeholder="Confirm Password" class="form-control" value="<?php echo $confirm_password; ?>">
						<span class="help-block"><?php echo $confirm_password_err; ?></span>
					</div>
					<div class="form-group">
						<button type="submit" class="btn btn-primary">Submit</button>
						<input type="reset" class="btn btn-default" value="Reset">
					</div>
			</form>
    </div>    
	</div>
</body>
</html>