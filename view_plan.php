<!--preincludes-->
<?php include 'includes/connection.php'?>
<?php include 'includes/checklogin.php'?>

<?php
if (isset($_GET['message'])) {

    //invalid file type
    if ($_GET['message'] == "invalidfileformat") {?>
        <script>alert("Only image files can be uploaded!");</script>
    <?php }

    //expense was added
    if ($_GET['message'] == "expenseadded") {?>
        <script>alert("Your Expense was added Successfully!");</script>
    <?php }

    //server error
    if ($_GET['message'] == "servererror") {?>
        <script>alert("Seems there was an error with the server!");</script>
    <?php }

    //file size greater than 100kb
    if ($_GET['message'] == "filesizelimit") {?>
        <script>alert("Max file size is 100kb");</script>
    <?php }

    //expense amount is less than 0
    if ($_GET['message'] == "negativeamount") {?>
        <script>alert("Amount spent must be greater than 0");</script>
    <?php }
}

//redirect to index if not loggedin
if (!$loggedin) {
    header('location: ../ctrlbudget/');
}

//redirect to home if plan id is not set
if(!isset($_GET['plan_id'])){
    header('location: home');
}

//get plan id and user id 
$user_id = $_SESSION['user_id'];
$plan_id = $_GET['plan_id'];

//retrieve plan details with plan id and user id
$query = "SELECT * FROM plans WHERE user_id = '$user_id' AND plan_id = '$plan_id'";
$plans = mysqli_query($con, $query) or die(mysqli_error($con));

// retrieve persons belonging to the plan with plan id 
$query = "SELECT * FROM persons WHERE plan_id = '$plan_id'";
$persons = mysqli_query($con, $query) or die(mysqli_error($con));

//retrieve expenses belonging to the plan
$query = "SELECT * FROM expenses WHERE plan_id = '$plan_id'";
$expenses = mysqli_query($con, $query) or die(mysqli_error($con));

//server messages
if (isset($_GET['message'])) {
    //expense was added
    if ($_GET['message'] == "expenseadded") {?>
        <script>alert("Your expense was added successfully!");</script>
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
    
    <div class="mx-auto container my-5 py-5 px-md-5 px-sm-3 px-0 flex-grow-1 row">

        <!-- plan details -->
        <div class="col-lg-8 mr-0">
            <?php if (mysqli_num_rows($plans) > 0) {
            $plan = mysqli_fetch_array($plans) ?>
            <div class="mt-3">
                <div class="card px-0">

                    <!-- plan title and no of people-->
                    <div class="lead text-center card-header bg-success text-white">
                        <?=$plan['title']?>
                        <span class="float-right">
                            <i class="fa fa-lg fa-users mr-1"></i><?=$plan['no_of_people'];?>
                        </span>
                    </div>
                    <div class="card-body">

                        <!-- budget -->
                        <p class="card-text">
                            <span class="font-weight-bold">Budget:</span> 
                            <span class="float-right"><?=$plan['initial_budget']?></span>
                        </p>

                        <!-- remaining amount -->
                        <p class="card-text">
                            <span class="font-weight-bold">Remaining Amount:</span> 
                            <?php
                                $remain_amount=$plan['remaining_amount'];
                                if($remain_amount > 0) {
                                    echo "<span class='float-right text-success'>$remain_amount</span>"; 
                                }
                                else if($remain_amount < 0){
                                    $remain_amount=$remain_amount*(-1);
                                    echo "<span class='float-right text-danger'>Over spent by $remain_amount</span>"; 
                                } 
                                else {
                                    echo "<span class='float-right'>$remain_amount</span>";
                                }
                            ?>
                        </p>

                        <!-- Date interval -->
                        <p class="card-text">
                            <span class="font-weight-bold">Date:</span> 
                            <span class="float-right"><?=formdate($plan['from'], $plan['to'])?></span>
                        </p>

                        <!-- form to send plan id to expense distribution page -->
                        <form action="expense_distribution" class="px-2 row justify-content-md-around" method="GET">
                            <input type="hidden" name="plan_id" value="<?=$plan['plan_id']?>">
                            <input type="submit" class="col-md-5 col-lg-12 btn btn-outline-success btn-lg btn-block" value="Expense Distribution">
                            <a href="#addexpense" class="mt-md-0 mt-3 col-md-5 btn btn-outline-success btn-lg btn-block d-lg-none">Add New Expense</a>
                        </form>
                    </div>
                </div>
            </div>
            <?php }?>
    
            <!--expenses -->
            <div class="row">
                <?php if (mysqli_num_rows($expenses) > 0) {
                while ($expense = mysqli_fetch_array($expenses)) {?>
                <div class="mt-3 col-md-6">
                    <div class="card px-0">

                        <!-- expense title-->
                        <div class="lead text-center card-header bg-success text-white">
                            <?=$expense['title']?>
                        </div>

                        <div class="card-body">

                            <!-- expense amount -->
                            <p class="card-text">
                                <span class="font-weight-bold">Amount:</span> 
                                <span class="float-right"><?=$expense['amount']?></span>
                            </p>

                            <!-- person who paid the amount -->
                            <p class="card-text">
                                <span class="font-weight-bold">Paid by:</span> 
                                <span class="float-right">
                                    <?php 
                                        $pid=$expense['person_id'];
                                        $query = "SELECT name FROM persons WHERE person_id = '$pid'";
                                        $person_names = mysqli_query($con, $query) or die(mysqli_error($con));
                                        $person_name = mysqli_fetch_array($person_names);
                                        echo $person_name['name'];
                                    ?>
                                </span>
                            </p>

                            <!-- expense date -->
                            <p class="card-text">
                                <span class="font-weight-bold">Paid on:</span> 
                                <span class="float-right"><?= date("dS M y",strtotime($expense['date'])) ?></span>
                            </p>

                            <!--link to daownload bill if available-->
                            <?php if($expense['bill']){ ?>
                                <a href="bill/<?= $expense['bill'] ?>" class="btn btn-block text-primary">Show bill</a>
                            <?php } else { ?>
                                <a href="#" class="btn btn-block disabled">You don't have bill</a>
                            <?php } ?>
                        </div>
                    </div>
                </div>
                <?php }}?>
            </div>
        </div>

        <!--form to add expense -->
        <div class="col-lg-4 float-md-right my-3">
                <div id="addexpense" class="card p-0">
                <div class="card-header bg-success text-white">
                    <div class="">
                        <p class="lead mb-0 text-center">Add New Expense</p>
                    </div>
                </div>
                <div class="card-body">
                    <form id="expense" action="process/addexpense.php" method="POST" class="mb-4" autocomplete="off" enctype="multipart/form-data">
                        <div class="form-group">
                            <p class="lead">Title:</p>
                            <input spellcheck="false" type="text" name="title" class="form-control" placeholder="Expense Name" required/>
                        </div>
                        <div class="form-group">
                            <p class="lead">Date:</p>
                            <input spellcheck="false" min="<?=date("Y-m-d",strtotime($plan['from']))?>" max="<?=date("Y-m-d",strtotime($plan['to']))?>" type="date" name="date" class="form-control" required/>
                        </div>
                        <div class="form-group">
                            <p class="lead">Amount Spent:</p>
                            <input type="number" min="1" name="spent" class="form-control" placeholder="Amount Spent" required/>
                        </div>
                        <div class="form-group">
                            <p class="lead">Spent By:</p>
                            <select class="form-control" name="spent_by">

                                <!-- diplay the person names in dropdown menu -->
                                <?php if(mysqli_num_rows($persons) > 0){ 
                                while($person = mysqli_fetch_array($persons)){ ?>
                                <option value="<?= $person['person_id'] ?>">
                                    <?= $person['name'] ?>
                                </option>
                                <?php }} ?>

                            </select>
                        </div>
                        <div class="form-group">
                            <p class="lead">Upload Bill:</p>
                            <input type="file" min="0" name="bill" class="form-control form-control-file"/>
                        </div>
                        <input type="hidden" name="plan_id" value="<?= $plan_id ?>">
                        <div>
                            <input type="submit" class="btn-block btn mt-4 btn-outline-success" value="Add" />
                        </div>
                    </form>
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


