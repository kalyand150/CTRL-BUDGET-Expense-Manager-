<?php
function GetImageExtension($imagetype) {
    if(empty($imagetype)) return false;
    switch($imagetype){
        case 'image/bmp': return '.bmp';
        case 'image/gif': return '.gif';
        case 'image/jpeg': return '.jpg';
        case 'image/png': return '.png';
        default: return false;
    }
}

//preincludes
include '../includes/connection.php';

//get inputs from post variables and apply form injection 
$expense_title = trim(mysqli_real_escape_string($con, $_POST['title']));
$date = trim(mysqli_real_escape_string($con, $_POST['date']));
$amount = trim(mysqli_real_escape_string($con, $_POST['spent']));
$person_id = trim(mysqli_real_escape_string($con, $_POST['spent_by']));
$plan_id = trim(mysqli_real_escape_string($con, $_POST['plan_id']));
$user_id=$_SESSION['user_id'];

//server validation
//amount is negative
if($amount < 0) {
    header("location: ../view_plan?plan_id=$plan_id&message=negativeamount");
}

//check if file is uploaded
if(!empty($_FILES["bill"]["name"])){
    $size=$_FILES["bill"]["size"];

    //get name of user with user id
    $query="SELECT name FROM users WHERE user_id = '$user_id'";
    $users=mysqli_query($con, $query);
    $user=mysqli_fetch_array($users);
    $user_name=$user['name'];

    //get name of plan with plan id
    $query="SELECT title FROM plans WHERE plan_id = '$plan_id'";
    $plans=mysqli_query($con, $query);
    $plan=mysqli_fetch_array($plans);
    $plan_title=$plan['title'];

    //check if file size is greater than 100kb 
    if($size > 102400) {
        header("location: ../view_plan?plan_id=$plan_id&message=filesizelimit");
        die();
    }

    $file_name=$_FILES["bill"]["name"];
    $tempname=$_FILES["bill"]["tmp_name"];
    $imgtype=$_FILES["bill"]["type"];
    
    //get file extension
    $ext=GetImageExtension($imgtype);

    //check if file is of valid type
    if(!$ext){
        header("location: ../view_plan?plan_id=$plan_id&message=invalidfileformat");
        die();
    }

    //change file name
    $imagename=$user_name."_".$plan_title."_".$expense_title.$ext;
    $target_path="../bill/".$imagename;

    //move the file to desired location and add the data into expense table
    if(move_uploaded_file($tempname, $target_path)){
        $query = "INSERT INTO `expenses` (`expense_id`, `plan_id`, `title`, `date`, `amount`, `person_id`, `bill`) VALUES(NULL, '$plan_id', '$expense_title', '$date', '$amount', '$person_id', '$imagename')";
    } 
} else {

    //add data into expense table with bill as null if no file is uploaded
    $query = "INSERT INTO `expenses` (`expense_id`, `plan_id`, `title`, `date`, `amount`, `person_id`, `bill`) VALUES(NULL, '$plan_id', '$expense_title', '$date', '$amount', '$person_id', NULL)";
}

if (mysqli_query($con, $query)) {

    //reduce the remaining amount of the plan in plans table
    $query = "UPDATE plans SET remaining_amount=remaining_amount-$amount WHERE plan_id=$plan_id";
    if(mysqli_query($con, $query)) {

        //increase the spent amount of the person in persons table  
        $query="UPDATE persons SET spent=spent+$amount WHERE person_id=$person_id";
        if(mysqli_query($con, $query)) {

            //redirect to view plan and say expense added 
            header("location: ../view_plan?plan_id=$plan_id&message=expenseadded");
        } else {

            //redirect to view plan and show error
            header("location: ../view_plan?plan_id=$plan_id&message=servererror");
        }
    } else {

        //redirect to view plan and show error
        header("location: ../view_plan?plan_id=$plan_id&message=servererror");
    }
} else {
    
    //redirect to view plan and show error
    header("location: ../view_plan?plan_id=$plan_id&message=servererror");
}
