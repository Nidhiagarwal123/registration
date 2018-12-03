<?php
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

$bodyContent .= '<p>Hi $name! Account created here is the activation link http://localhost/registration/activate.php?token=$token</p>';
        
$mail->Subject = 'Email from Localhost By Nidhi Agarwal';
$mail->Body    = $bodyContent;


if(!$mail->send()) {
    echo 'Message could not be sent.';
    echo 'Mailer Error: ' . $mail->ErrorInfo;
} else {
    echo 'Message has been sent';
	// visit our site www.studyofcs.com for more learning
}



?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    

    <title>Login</title>

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
            <li class="active"><a href="index.php">Login</a></li>
            <li><a href="register.php">Register</a></li>
          </ul>
        </div><!--/.nav-collapse -->
      </div>
    </nav>

    <div class="container">

     <form action="index.php" method="post" style="margin-top:35px;">
         <h2>Login</h2>
         
         <?php if(isset($_GET['success'])) { ?>
         
         <div class="alert alert-success"><?php echo $_GET['success']; ?></div>
         
         <?php } ?>
         
         <?php if(isset($_GET['err'])) { ?>
         
         <div class="alert alert-danger"><?php echo $_GET['err']; ?></div>
         
         <?php } ?>
         
         <hr>
  <div class="form-group">
    <label for="exampleInputEmail1">Email address</label>
    <input type="email" name="email" class="form-control" placeholder="Email">
  </div>
  <div class="form-group">
    <label for="exampleInputPassword1">Password</label>
    <input type="password" name="password" class="form-control" placeholder="Password">
  </div>
 
  <div class="checkbox">
    <label>
      <input type="checkbox" name="remember_me"> Remember Me
    </label>
  </div>
  <button type="submit" name="login" class="btn btn-default">Login</button>
  <a href="#">Forgot Password?</a>
</form>

    </div><!-- /.container -->


    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
    <script src="js/bootstrap.js"></script>
    
  </body>
</html>

