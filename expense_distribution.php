<!-- preincludes-->
<?php include 'includes/connection.php'?>
<?php include 'includes/checklogin.php'?>

<?php
// redirect ot index page if not looged in
if (!$loggedin) {
    header('location: ../ctrlbudget/');
}

// redirect to home if no plan id is set
if (!isset($_GET['plan_id'])) {
    header('location: home');
}
$user_id = $_SESSION['user_id'];
$plan_id = $_GET['plan_id'];

//retrieve plan details with plan id
$query = "SELECT * FROM plans WHERE user_id = '$user_id' AND plan_id = '$plan_id'";
$plans = mysqli_query($con, $query) or die(mysqli_error($con));

//retrieve person details with plan id
$query = "SELECT * FROM persons WHERE plan_id = '$plan_id'";
$persons = mysqli_query($con, $query) or die(mysqli_error($con));

// retrive expenses corresponding to the plan with plan id
$query = "SELECT * FROM expenses WHERE plan_id = '$plan_id'";
$expenses = mysqli_query($con, $query) or die(mysqli_error($con));

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
    
    <!-- Expense Distribution Details -->
    <div class="mx-auto container my-5 py-5">
        <div class="col-md-8 col-lg-6 mx-auto">
            <?php if (mysqli_num_rows($plans) > 0) {
            $plan = mysqli_fetch_array($plans) ?>
            <div class="mt-3">
                <div class="card px-0">

                    <!-- Plan title -->
                    <div class="lead text-center card-header bg-success text-white">
                        <?=$plan['title']?>
                        <span class="float-right">
                            <i class="fa fa-lg fa-users mr-1"></i><?=$plan['no_of_people'];?>
                        </span>
                    </div>

                    <div class="card-body">

                        <!-- plan budget -->
                        <p class="card-text">
                            <span class="font-weight-bold">Budget:</span> 
                            <span class="float-right"><?=$plan['initial_budget']?></span>
                        </p>

                        <!-- all the persons of the plan and the amount they spent -->
                        <?php 
                            $total_spent=0; 
                            $person_names=[];
                            if (mysqli_num_rows($persons) > 0) {
                                while ($person = mysqli_fetch_array($persons)) {?>
                        <p class="card-text">
                            <span class="font-weight-bold"><?=$person['name']?> Spent:</span>
                            <span class="float-right"><?=$person['spent']?></span>
                        </p>
                            <?php $total_spent=$total_spent+$person['spent']; 
                                $person_names[]=["name"=>$person['name'], "spent"=>$person['spent']]; 
                                }
                            }
                        ?>

                        <!-- total amount spent -->
                        <p class="card-text">
                            <span class="font-weight-bold">Total Amount Spent:</span> 
                            <span class='float-right'><?=$total_spent?></span>
                        </p>

                        <!--remaining amount of the plan -->
                        <p class="card-text"><span class="font-weight-bold">Remaining Amount:</span> 
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

                        <!--Individual shares of the persons -->
                        <p class="card-text">
                            <span class="font-weight-bold">Individual shares:</span> 
                            <span class='float-right'><?=floor(($total_spent/count($person_names)))?></span>
                        </p>

                        <!-- all the persons with the amount they need to get or give -->
                        <?php for($i=0;$i<count($person_names);$i++) { ?>
                        <p class="card-text">
                            <span class="font-weight-bold"><?=$person_names[$i]['name']?>:</span> 
                        <?php
                            $balance=floor($person_names[$i]['spent']-($total_spent/count($person_names)));
                            if($balance > 0) {
                                echo "<span class='float-right text-success'>Gets back $balance</span>"; 
                            }
                            else if($balance < 0){
                                $balance=$balance*(-1);
                                echo "<span class='float-right text-danger'>Owes $balance</span>"; 
                            } 
                            else {
                                echo "<span class='float-right'>$balance</span>";
                            }
                        } ?>
                        </p>

                        <div class="text-center">
                            <a href="view_plan?plan_id=<?=$plan_id?>" class="px-4 btn btn-outline-success mx-auto"><i class="fa fa-lg fa-long-arrow-left"></i> Go Back</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?php }?>
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


