<!--pre includes -->
<?php include 'includes/connection.php'?>
<?php include 'includes/checklogin.php'?>

<!-- redirect to home page if already logged in -->
<?php
if ($loggedin) {
    header('location: home');
}
?>

<!-- server side validation messages -->
<?php
if (isset($_GET['message'])) {
	
	//Email is unfilled
    if ($_GET['message'] == "noemail") { ?>
        <script>alert("Email is required!");</script>
    <?php }

	//Password is unfilled
	else if ($_GET['message'] == "nopassword") { ?>
        <script>alert("Password is required!");</script>
    <?php }
	
	//Email is of wrong format
	else if ($_GET['message'] == "emailwrongformat") { ?>
        <script>alert("Email is of wrong format!, Please check your email");</script>
    <?php }

	//Wrong password
	else if ($_GET['message'] == "wrongpassword") { ?>
        <script>alert("Wrong password! Please try again");</script>
    <?php }

	//Redirection from sign up page if the user already owns an account
	else if ($_GET['message'] == "existinguser") { ?>
        <script>alert("Seems like you already own an account!, Login to access your account");</script>
    <?php } 
	
	//server errors
	else { ?>
        <script>alert("Something wrong with the server!, Please try again");</script>
    <?php }
}
?>


<!doctype html>
<html lang="en">

<head>
    <title>Ctrl Budget | Login</title>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- google font -->
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&family=Ubuntu:ital,wght@1,400&display=swap" rel="stylesheet">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="resources/bootstrap/bootstrap.min.css">

    <!-- Fontawesome -->
    <link rel="stylesheet" href="resources/fontawesome/css/font-awesome.min.css">

    <!-- stylesheet -->
    <link rel="stylesheet" href="stylesheet/style.css">

</head>

<body>
    
    <!-- header-->
    <?php include 'includes/header.php'?>
    
    <!-- form for Logging in -->
    <div class="mt-5 bg-light flex-grow-1 d-flex flex-column justify-content-center">
        <div class="container">
            <div class="form card col-md-8 col-lg-6 d my-5 mx-auto">
                <div class="card-body p-0">
                    <div class="pt-4">
                        <h2 class="mb-0 text-center">Login</h2>
                    </div>
                </div>
                <div class="card-body">
                    <form id="login" action="process/login_validate.php" method="POST" class="mb-4" autocomplete="off">
                        <div class="form-group">
                            <p class="lead">Email:</p>
                            <input spellcheck="false" type="email" name="email" class="form-control" placeholder="Email" required/>
                        </div>
                        <div class="form-group">
                            <p class="lead">Password:</p>
                            <input type="password" minlength="6" name="password" class="form-control" placeholder="Password" required/>
                        </div>
                        <div>
                            <input  type="submit" class="btn-block btn mt-4 btn-info" value="Login" />
                        </div>
                    </form>
                </div>
                <div class="border-top border-dark text-center card-body">
                    Don't&nbsp;have&nbsp;an&nbsp;account? <a href="signup">Click&nbsp;here&nbsp;to&nbsp;Sign&nbsp;Up</a> 
                </div>
            </div>
        </div>
    </div>

    <!-- footer -->
    <?php include 'includes/footer.php'?>

    <!-- jQuery -->
    <script src="resources/jquery/jquery.min.js"></script>

    <!-- Popper js -->
    <script src="resources/popper/popper.min.js"></script>

    <!-- Bootstrap-->
    <script src="resources/bootstrap/bootstrap.min.js"></script>
</body>

</html>


