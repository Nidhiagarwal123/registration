<?php
session_start();

include('includes/config.php');
include('includes/db.php');
include('includes/functions.php');


if(loggedIn()){
    header("Location:myaccount.php");
    exit();
}


require 'PHPMailer/PHPMailerAutoload.php';

$mail = new PHPMailer;

$mail->isSMTP();                                   // Set mailer to use SMTP
$mail->Host = 'smtp.gmail.com';                    // Specify main and backup SMTP servers
$mail->SMTPAuth = true;                            // Enable SMTP authentication
$mail->Username = 'nidhi.wri186@webreinvent.com';          // SMTP username
$mail->Password = 'agarwal"299'; // SMTP password
$mail->SMTPSecure = 'tls';                         // Enable TLS encryption, `ssl` also accepted
$mail->Port = 587;                                 // TCP port to connect to

$mail->setFrom('nidhi.wri186@webreinvent.com', 'Nidhi Agarwal');
$mail->addReplyTo('nidhi.wri186@webreinvent.com', 'Nidhi Agarwal');
$mail->addAddress('nidhiagarwal299@gmail.com');   // Add a recipient
//$mail->addCC('cc@example.com');
//$mail->addBCC('bcc@example.com');

$mail->isHTML(true);  // Set email format to HTML

$bodyContent = '<h1>Sending Email From LocalHost</h1>';
$bodyContent .= '<p>Finaly Now I can send mail <b>offline</b></p>';

$mail->Subject = 'Email from Localhost By Nidhi Agarwal';
$mail->Body    = $bodyContent;

if(!$mail->send()) {
    echo 'Message could not be sent.';
    echo 'Mailer Error: ' . $mail->ErrorInfo;
} else {
    echo 'Message has been sent';
	// visit our site www.studyofcs.com for more learning
}










function isUnique($email){
    $query = "select * from users where email='$email'";
    global $db;
    
    $result = $db->query($query);
    
    if($result->num_rows > 0){
        return false;
    }
    else return true;
    
}

if(isset($_POST['register'])){
    $_SESSION['name'] = $_POST['name'];
    $_SESSION['email'] = $_POST['email'];
    $_SESSION['password'] = $_POST['password'];
    $_SESSION['confirm_password'] = $_POST['confirm_password'];
    
    if(strlen($_POST['name'])<3){
        header("Location:register.php?err=" . urlencode("The name must be at least 3 characters long"));
        exit();
    }
   else if($_POST['password'] != $_POST['confirm_password']){
        header("Location:register.php?err=" . urlencode("The password and confirm password do not match"));
        exit();
   }
    else if(strlen($_POST['password']) < 5){
         header("Location:register.php?err=" . urlencode("The password should be at least 5 characters"));
        exit();
    }
  
    else if(!isUnique($_POST['email'])){
        header("Location:register.php?err=" . urlencode("Email is already in use. Please use another one"));
        exit();
    }
   
    else {
        $name = mysqli_real_escape_string($db , $_POST['name']);
        $email = mysqli_real_escape_string($db , $_POST['email']);
        $password = mysqli_real_escape_string($db , $_POST['password']);
        $token = bin2hex(openssl_random_pseudo_bytes(32));
        
        $query = "insert into users (name,email,password,token) values('$name','$email','$password','$token')";
        
        $db->query($query);
        $message = "Hi $name! Account created here is the activation link http://localhost/registration/activate.php?token=$token";
        
        mail($email , 'Activate Account' , $message , 'From: nidhiagarwal299@gmail.com');
        header("Location:index.php?success=" . urlencode("Activation Email Sent!"));
        exit();
    }
   
}
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    

    <title>Register</title>

    <!-- Bootstrap core CSS -->
    <link href="css/bootstrap.css" rel="stylesheet">
    <link href="css/style.css" rel="stylesheet">

  </head>

  <body>

    <nav class="navbar navbar-inverse navbar-fixed-top">
      <div class="container">
        <div class="navbar-header">
          <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
         
        </div>
        <div id="navbar" class="collapse navbar-collapse">
          <ul class="nav navbar-nav">
            <li><a href="index.php">Login</a></li>
            <li class="active"><a href="register.php">Register</a></li>
          </ul>
        </div><!--/.nav-collapse -->
      </div>
    </nav>

    <div class="container">
        
     <form  action="register.php" method="post" style="margin-top:35px;">
         <h2>Register Here</h2>
         
         <?php if(isset($_GET['err'])) { ?>
         
         <div class="alert alert-danger"><?php echo $_GET['err']; ?></div>
         
         <?php } ?>
         <hr>
         <div class="form-group">
    <label>Name</label>
    <input type="text" name="name" class="form-control" placeholder="Name" value="<?php echo @$_SESSION['name']; ?>" required>
  </div>
     
  <div class="form-group">
    <label for="exampleInputEmail1">Email address</label>
    <input type="email" name="email" class="form-control" placeholder="Email" value="<?php echo @$_SESSION['email']; ?>" required>
  </div>
  <div class="form-group">
    <label for="exampleInputPassword1">Password</label>
    <input type="password" name="password" class="form-control" placeholder="Password" value="<?php echo @$_SESSION['password']; ?>" required>
  </div>
 
 <div class="form-group">
    <label >Confirm Password</label>
    <input type="password" name="confirm_password" class="form-control" placeholder="Confirm Password" value="<?php echo @$_SESSION['confirm_password']; ?>" required>
  </div>
 
  <button type="submit" name="register" class="btn btn-default">Register</button>
</form>

    </div><!-- /.container -->


    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
    <script src="js/bootstrap.js"></script>
    
  </body>
</html>

