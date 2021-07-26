<!--preincludes-->
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
	
	//any of the fields empty
    if ($_GET['message'] == "fieldempty") { ?>
        <script>alert('Please fill in all the details!');</script>
    <?php }
	
	//name contains digits or special characters
	else if ($_GET['message'] == "nameinvalid") { ?>
        <script>alert('Name can contain only letters!');</script>
    <?php }

	//email is of wrong format 
	else if ($_GET['message'] == "emailwrongformat") { ?>
        <script>alert('Email is of wrong format!, Please check your email');</script>
    <?php }

	//password if of wrong pattern
	else if ($_GET['message'] == "passwordwrongformat") {?>
        <script>alert('Password must contain an uppercase, a lowercase and a digit!');</script>
    <?php }

	//password is less than 6 characters
	else if ($_GET['message'] == "shortpassword") { ?>
        <script>alert('Password must be atleast 6 characters long!');</script>
    <?php }

	//Contact no contains letters or special characters
	else if ($_GET['message'] == "contactinvalid") { ?>
        <script>alert('Contact number must contain only digits');</script>
    <?php }

	//Contact is less than 10 digits
	else if ($_GET['message'] == "shortcontact") { ?>
        <script>alert('Contact number must be atleast 10 digits long!');</script>
    <?php }

	//redirection form login page if user doesn't own an account 
	else if ($_GET['message'] == "newuser") { ?>
        <script>alert("Seems You don't have an account!, Please register your account");</script>
    <?php } 

	//server errors
	else { ?>
        <script>alert('Something wrong with the server!, Please try again');</script>
    <?php }
}
?>


<!doctype html>
<html lang="en">

<head>
    <title>Ctrl Budget | Register</title>
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
    
    <!--header-->
    <?php include 'includes/header.php'?>
    
    <!-- form for signing up -->
    <div class="mt-5 bg-light flex-grow-1 d-flex flex-column justify-content-center">
        <div class="container">
            <div class="form card col-md-8 col-lg-6 d my-5 mx-auto">
                <div class="card-body p-0">
                    <div class="pt-4">
                        <h2 class="mb-0 text-center">Sign Up</h2>
                    </div>
                </div>
                <div class="card-body">
                    <form id="signup" action="process/signup_validate.php" method="POST" class="mb-4" autocomplete="off">
                        <div class="form-group">
                            <p class="lead">Name:</p>
                            <input spellcheck="false" type="text" name="name" class="form-control" placeholder="Name" required/>
                        </div>
                        <div class="form-group">
                            <p class="lead">Email:</p>
                            <input spellcheck="false" type="email" name="email" class="form-control" placeholder="Enter Valid Email" required/>
                        </div>
                        <div class="form-group">
                            <p class="lead">Password:</p>
                            <input type="password" minlength="6" name="password" class="form-control" placeholder="Password (Min. 6 characters)" required/>
                        </div>
                        <div class="form-group">
                            <p class="lead">Phone number:</p>
                            <input type="number" name="contact" class="form-control" placeholder="Enter Valid Phone Number (Ex: 8448444853)" required/>
                        </div>
                        <div>
                            <input type="submit" class="btn-block btn mt-4 btn-info" value="Sign Up" />
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    
    <!--footer-->
    <?php include 'includes/footer.php'?>

    <!-- jQuery -->
    <script src="resources/jquery/jquery.min.js"></script>

    <!-- Popper js -->
    <script src="resources/popper/popper.min.js"></script>

    <!-- Bootstrap-->
    <script src="resources/bootstrap/bootstrap.min.js"></script>
</body>

</html>


