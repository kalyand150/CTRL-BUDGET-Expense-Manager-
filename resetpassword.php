<!-- preincludes -->
<?php include 'includes/connection.php'?>
<?php include 'includes/checklogin.php'?>

<!-- Redirect to index page if not logged in -->
<?php
if (!$loggedin) {
    header('location: ../ctrlbudget/');
}

//server validation errors and messages
if (isset($_GET['message'])) {
	
	//some fields are unfilled
    if ($_GET['message'] == "fieldempty") { ?>
        <script>alert("Please fill in all the details!")</script>
    <?php } 
	
	//password is of wrong pattern
	else if ($_GET['message'] == "passwordwrongformat") { ?>
        <script>alert("Password must contain an uppercase, a lowercase and a digit!")</script>
    <?php } 
	
	//password is less than 6 characters
	else if ($_GET['message'] == "shortpassword") { ?>
        <script>alert("Password must be atleast 6 characters long!")</script>
    <?php } 
	
	//password changed successfully
	else if ($_GET['message'] == "success") { ?>
        <script>
            alert("Password Changed Successfully!"); 
            location.href="home";
        </script>
    <?php } 
	
	//new and confirm passwords doesn't match 
	else if ($_GET['message'] == "passwordmismatch") { ?>
        <script>alert("New password and Confirm password must be same!")</script>
    <?php } 
	
	//old password doesn't match with database
	else if ($_GET['message'] == "currentpasswordmismatch") { ?>
        <script>alert("Wrong password!, Please try again")</script>
    <?php } 
	
	//server errors
	else { ?>
        <script>alert("Something wrong with the server!, Please try again")</script>
    <?php }
}
?>


<!doctype html>
<html lang="en">

<head>
    <title>Ctrl Budget</title>
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
    
    <!-- form for Password reset -->
    <div class="mt-5 bg-light flex-grow-1 d-flex flex-column justify-content-center">
        <div class="container">
            <div class="form card col-md-8 col-lg-6 d my-5 mx-auto">
                <div class="card-body p-0">
                    <div class="pt-4">
                        <h2 class="mb-0 text-center">Change Password</h2>
                    </div>
                </div>
                <div class="card-body">
                    <form id="reset-password" action="process/reset_password_validate.php" method="POST" class="mb-4" autocomplete="off">
                        <div class="form-group">
                            <p class="lead">Old Password:</p>
                            <input spellcheck="false" type="password" name="old-password" class="form-control" placeholder="Old Password" required/>
                        </div>
                        <div class="form-group">
                            <p class="lead">New Password:</p>
                            <input spellcheck="false" type="password" name="new-password" class="form-control" placeholder="New Password (Min. 6 characters)" required/>
                        </div>
                        <div class="form-group">
                            <p class="lead">Confirm New Password:</p>
                            <input type="password" minlength="6" name="confirm-password" class="form-control" placeholder="Retype New Password" required/>
                        </div>
                        <div>
                            <input type="submit" class="btn-block btn mt-4 btn-info" value="Change" />
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


