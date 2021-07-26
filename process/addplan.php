<?php

//preincludes
include '../includes/connection.php';

//check if from date is greater than to date
$from =strtotime($_POST['from_date']);
$to=strtotime($_POST['to_date']);
if($from > $to) {
    header('location: ../new_plan?message=errordate');
	die();
}

//retrieve data from post variables, trim white-spaces and apply form injection
$user_id=$_SESSION['user_id'];
$plan_title=trim(mysqli_real_escape_string($con, $_POST['title']));
$from=trim(mysqli_real_escape_string($con, $_POST['from_date']));
$to=trim(mysqli_real_escape_string($con, $_POST['to_date']));
$budget=trim(mysqli_real_escape_string($con, $_POST['initial_budget']));
$no_of_persons=trim(mysqli_real_escape_string($con, $_POST['no_of_persons']));

//store the person names in an array
$persons=[];
for($i=1;$i<=$no_of_persons;$i++){
    $persons[]=trim(mysqli_real_escape_string($con, $_POST['person-'.$i]));
}

//insert plan details into the plans table in db 
$query="INSERT INTO `plans` (`plan_id`, `user_id`, `title`, `from`, `to`, `no_of_people`, `initial_budget`, `remaining_amount`) VALUES(NULL, '$user_id', '$plan_title', '$from', '$to', '$no_of_persons', '$budget', '$budget')";
if(mysqli_query($con,$query)){

    //if plan is added get the plan id and insert the person names into persons table in database
    $plan_id=mysqli_insert_id($con);
    for ($i = 0; $i < $no_of_persons; $i++) {
        $query="INSERT INTO persons (plan_id, name, spent) VALUES ('$plan_id', '$persons[$i]', 0)";
        if(!mysqli_query($con,$query)){
            //redirect to home and show error if plan not added
            header('location: home?message=servererror');
            die();
        }
    }

    //redirect to home if plan added
    header('location: ../home?message=planadded');
} else {
    //redirect to home and show error if plan not added
    header('location: home?message=servererror');
}
?>




