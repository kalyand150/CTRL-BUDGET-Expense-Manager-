<?php

//preincludes
include 'includes/connection.php';
include 'includes/checklogin.php';

//redirect to index page if not logged in
if (!$loggedin) {
    header('location: ../ctrlbudget/');
}

//display server side messages
if (isset($_GET['message'])) {
    
    //Plan was added successfully
    if ($_GET['message'] == "planadded") { ?>
        <script>alert("Your plan was added successfully!");</script>
    <?php }
}

function formdate($from, $to){
    if($from == $to) {
        return date("dS M y",strtotime($from));
    }
    if(date("Y",strtotime($from)) != date("Y",strtotime($to))){
        return date("dS M y",strtotime($from))." - ".date("dS M y",strtotime($to));
    }
    return date("dS M",strtotime($from))." - ".date("dS M y",strtotime($to));
}

$user_id=$_SESSION['user_id'];

//retrieve the plans of the user
$query="SELECT * FROM plans WHERE user_id = '$user_id'";
$plans= mysqli_query($con, $query) or die(mysqli_error($con));

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
    
    <!--display user plans -->
    <div class="my-5 py-5 px-md-5 px-3 flex-grow-1">
    
        <!-- check if user has plans or not --> 
        <?php if(mysqli_num_rows($plans) > 0) { ?>
        <h2 class="text-center text-md-left mt-5">Your plans</h2>
        <?php } else { ?>
        <h2 class="text-center text-md-left mt-5">You don't have any active plans.
        <?php } ?>
        
        <!--display user plans if there is -->
        <div class="row mt-4">

            <?php if(mysqli_num_rows($plans) > 0) { 
            while($plan=mysqli_fetch_array($plans)) {?>

            <div class="col-md-6 col-lg-4 col-xl-3 mt-3">
                <div class="card px-0">

                    <!--plan title and no of persons -->
                    <div class="lead text-center card-header bg-success text-white" >
                        <?= $plan['title'] ?>
                        <span class="float-right">
                            <i class="fa fa-lg fa-users mr-1"></i><?= $plan['no_of_people']; ?>
                        </span>
                    </div>
                    
                    <!--plan budget and date interval -->
                    <div class="card-body">
                        <p class="card-text">
                            <span class="font-weight-bold">Budget:</span> 
                            <span class="float-right"><?= $plan['initial_budget'] ?></span>
                        </p>
                        <p class="card-text">
                            <span class="font-weight-bold">From:</span>
                            <span class="float-right"><?= formdate($plan['from'], $plan['to']) ?></span>
                        </p>

                        <!-- form to send plan id to view plan page -->
                        <form action="view_plan" method="GET">
                            <input type="hidden" name="plan_id" value="<?= $plan['plan_id'] ?>">
                            <input type="submit" class="btn btn-outline-success btn-block" value="View Plan">
                        </form>
                    </div>
                </div>
            </div>
            <?php }} ?>

            <!--create plan link -->
            <div class="col-md-6 col-lg-4 col-xl-3 mt-3">
                <div class="rounded border border-success text-success px-3 h-100 flex-column d-flex justify-content-center align-items-center">
                    <p class="lead mt-5">CREATE PLAN</p>
                    <a href="new_plan" class="text-success mb-5"><i class="fa fa-4x fa-plus-circle"></i></a>
                </div>
            </div>
        </div>
    </div>
    
    <!--footer -->
    <?php include 'includes/footer.php'?>

    <!-- jQuery -->
    <script src="resources/jquery/jquery.min.js"></script>

    <!-- Popper js -->
    <script src="resources/popper/popper.min.js"></script>

    <!-- Bootstrap-->
    <script src="resources/bootstrap/bootstrap.min.js"></script>
</body>

</html>


