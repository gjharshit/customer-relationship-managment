<?php
ob_start();
session_start();
require_once '../includes/dbconnect.php';

    // it will never let you open index(login) page if session is set
    if ( isset($_SESSION['user'])!="" ) {
    // header("Location: home.php");
    // echo "<p>You have been logged out. To login again go to </p>" . "<a href=\"home.php\">home.</a>";
    header("Location: home.php");
    exit;
    }

    $error = false;

    if( isset($_POST['btn-login']) ) {

    // prevent sql injections/ clear user invalid inputs
    $email = trim($_POST['email']);
    $email = strip_tags($email);
    $email = htmlspecialchars($email);

    $pass = trim($_POST['pass']);
    $pass = strip_tags($pass);
    $pass = htmlspecialchars($pass);
    // prevent sql injections / clear user invalid inputs

    if(empty($email)){
    $error = true;
    $emailError = "Please enter your email address.";
    } else if ( !filter_var($email,FILTER_VALIDATE_EMAIL) ) {
    $error = true;
    $emailError = "Please enter valid email address.";
    }

    if(empty($pass)){
    $error = true;
    $passError = "Please enter your password.";
    }

    // if there's no error, continue to login
    if (!$error) {

    $password = hash('sha256', $pass); // password hashing using SHA256

    $res=mysql_query("SELECT userId, userName, userPass FROM users WHERE userEmail='$email'");
    $row=mysql_fetch_array($res);
    $count = mysql_num_rows($res); // if uname/pass correct it returns must be 1 row

    if( $count == 1 && $row['userPass']==$password ) {
    $_SESSION['user'] = $row['userId'];
    header("Location: admin_panel.php");
    } else {
    $errMSG = "Incorrect Credentials, Try again...";
    }
    }
    }
?>
<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Login Page</title>
<link rel="shortcut icon" href="images/favicon.ico" type="image/x-icon">
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
<link href="https://fonts.googleapis.com/css?family=Josefin+Sans:400,400i,700,700i" rel="stylesheet">
<link rel="stylesheet" href="style.css" type="text/css" />
</head>

<style type="text/css">
    html, body {
        font-family: Josefin Sans, sans-serif;
    }

    h1, h2 {
        font-weight: bold;
        text-align: center;
    }

    img {
        width: 200px;
        height: 190px;
        position: relative;
        left: 41%;
    }
</style>

<body>

<div class="container">
    <!-- Insert your logo in the below img tag if you want -->
    <!-- <img id="head_logo" src="images/xcode-logo.png" alt="xcode-logo" /> -->
    <h1>Yashasvi Information Solutions</h1>
    <h2>Order Management Platform</h2>
    <div id="login-form">
        <form method="post" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" autocomplete="off">

        <div class="col-md -12">

        <div class="form-group">
            <br><br>
            <h2 class="">Sign In.</h2>
        </div>

        <div class="form-group">
            <hr />
        </div>

<?php
   if (isset($errMSG)) {
?>

    <div class="form-group">
        <div class="alert alert-danger">
    <span class="glyphicon glyphicon-info-sign"></span> <?php echo $errMSG; ?>
        </div>
    </div>

<?php
   }
?>

    <div class="form-group">
        <div class="input-group">
            <span class="input-group-addon"><span class="glyphicon glyphicon-envelope"></span></span>
            <input type="email" name="email" class="form-control" placeholder="Enter your email id here.." value="<?php echo $email; ?>" maxlength="40" />
        </div>
            <span class="text-danger"><?php echo $emailError; ?></span>
    </div>

    <div class="form-group">
        <div class="input-group">
            <span class="input-group-addon"><span class="glyphicon glyphicon-lock"></span></span>
            <input type="password" name="pass" class="form-control" placeholder="Enter your password here.." maxlength="15" />
        </div>
            <span class="text-danger"><?php echo $passError; ?></span>
    </div>

        <div class="form-group">
            <hr />
        </div>

        <div class="form-group">
            <button type="submit" class="btn btn-block btn-primary" name="btn-login">Sign In</button>
        </div>

        <div class="form-group">
            <hr />
        </div>

        <div class="form-group">
            <a href="register.php">Click here to sign up...</a>
        </div>

    </form>
    </div>

</div>

</body>
</html>
<?php ob_end_flush(); ?>
