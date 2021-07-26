<?php 
include 'includes/connection.php';
include 'includes/checklogin.php';

//Redirect to index page if not logged in
if (!$loggedin) {
    header('location: ../ctrlbudget/');
}

if (isset($_GET['message'])) {

    //budget or the no of persons is negative
    if ($_GET['message'] == "negativevalue") {?>
        <script>alert("Enter positive numbers!");</script>
    <?php } 

    //no of persons is greater than 20
    else if ($_GET['message'] == "morepersons") {?>
        <script>alert("Number of persons must be less than or equal to 20!");</script>
    <?php }

    //from date is greater than to date
    else if ($_GET['message'] == "errordate") {?>
        <script>alert("From date must be less than to date!");</script>
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
    
    <!--form to add new plan -->
    <div class="my-5 py-5 flex-grow-1 d-flex bg-light flex-column">
        <div class="container flex-grow-1 v-100 d-flex flex-column justify-content-center">
            <div class="form card col-md-8 col-lg-6 mx-auto px-0">
                <div class="card-header bg-success text-white text-center">
                    <h2 class="mb-0">New Plan</h2>
                </div>
                <div class="card-body">
                   <form id="new_plan" action="plan_details" method="POST" class="mb-4" autocomplete="off">
                        <div class="form-group">
                            <p class="lead">Initial Budget:</p>
                            <input spellcheck="false" type="number" name="initial_budget" class="form-control" placeholder="Initial Budget (Ex: 4000)" required/>
                        </div>
                        <div class="form-group">
                            <p class="lead">How many people you want to add in your group:</p>
                            <input spellcheck="false" max="20" type="number" name="no_of_persons" class="form-control" placeholder="No. of people" required/>
                        </div>
                        <div>
                            <input type="submit" class="btn-block btn-outline-success btn mt-4" value="Next" />
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


