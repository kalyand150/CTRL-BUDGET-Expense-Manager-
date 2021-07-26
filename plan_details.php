<?php 
include 'includes/connection.php';
include 'includes/checklogin.php';

//Redirect to index page if not logged in
if (!$loggedin) {
    header('location: ../ctrlbudget/');
}

//if budget of number of persins not set
if(!( isset($_POST['initial_budget']) && isset($_POST['no_of_persons']) )){
    header('location: new_plan');
} 

else{

    //get input from post variables trim white-spaces and apply form injection 
    $persons=trim(mysqli_real_escape_string($con, $_POST['no_of_persons']));
    $budget=trim(mysqli_real_escape_string($con, $_POST['initial_budget']));

    //if budget or no of persons less than 0
    if($persons < 0 || $budget < 0) {
        header('location: new_plan?message=negativevalue');
    }

    //if no of persons greater than 20
    if($persons > 20) {
        header('location: new_plan?message=morepersons');
    }
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
    
    <!--form for adding new plan-->
    <div class="my-5 py-5 flex-grow-1 d-flex bg-light flex-column">
        <div class="container flex-grow-1 v-100 d-flex flex-column justify-content-center">
            <div class="my-5 form card col-md-8 col-lg-6 mx-auto px-0">
                <div class="card-body">
                   <form id="plan_details" action="process/addplan.php" method="POST" class="mb-4" autocomplete="off">
                        <div class="form-group">
                            <p class="lead">Title:</p>
                            <input spellcheck="false" type="text" name="title" placeholder="Enter Title (Ex: Trip to Goa)" class="form-control" required/>
                        </div>
                        <div class="row">
                            <div class="form-group col-md-6">
                                <p class="lead">From:</p>
                                <input spellcheck="false" type="date" name="from_date" class="form-control" required/>
                            </div>
                            <div class="form-group col-md-6">
                                <p class="lead">To:</p>
                                <input spellcheck="false" type="date" name="to_date" class="form-control" required/>
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-md-8">
                                <p class="lead">Initial Budget:</p>
                                <input spellcheck="false" type="number" name="initial_budget" class="form-control" value="<?= $budget ?>" readonly/>
                            </div>
                            <div class="form-group col-md-4">
                                <p class="lead">persons:</p>
                                <input spellcheck="false" type="number" name="no_of_persons" class="form-control" value="<?= $persons ?>" readonly/>
                            </div>
                        </div>

                        <!--display input fields to get the names of the persons -->
                        <!-- no of fields is equal to no of persons --> 
                        <?php for($i=1;$i<=$persons;$i++) { ?>
                            <div class="form-group">
                                <p class="lead">Person <?= $i ?>:</p>
                                <input spellcheck="false" type="text" name="person-<?= $i ?>" placeholder="Person <?= $i ?> Name" class="form-control" required/>
                            </div>
                        <?php } ?>

                        <div>
                            <input type="submit" class="btn-block btn-outline-success btn mt-4" value="Submit" />
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


