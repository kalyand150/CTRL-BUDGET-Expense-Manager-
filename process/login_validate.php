<?php

//preincludes
include '../includes/connection.php';

//retrieve the input, trim white-spaces and apply form injection
$email = trim(mysqli_real_escape_string($con, $_POST['email']));
$password = trim(mysqli_real_escape_string($con, $_POST['password']));

//server validation
//if email is empty 
if ($email == "") {
    header("location: ../login?message=noemail");
} 

//if password is empty
else if ($password == "") {
    header("location: ../login?message=nopassword");
} 

//if email is in wrong format
else if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    header("location: ../login?message=emailwrongformat");
} 

//if validation passes
else {
	
	//encrpyt the password
    $password = md5($password);
	
	//check if user has an account
    $query = "SELECT * FROM users WHERE email = '$email'";
    $check = mysqli_query($con, $query);
	
	//if not found redirect to signup page 
    if (mysqli_num_rows($check) == 0) {
        header('location: ../signup?message=newuser');
    } 
	
	//if user found
	else {
        $user = mysqli_fetch_array($check);
		
		//check if passwords match
        if ($password == $user['password']) {
			
			//if matches initialise session variables
            $_SESSION['user_id'] = $user['user_id'];
            $_SESSION['username'] = $user['name'];
            $_SESSION['email'] = $user['email'];
            $_SESSION['phoneno'] = $user['contact'];
			
            header('location: ../home');
        } 
		
		//redirect to login page and show error if password doesn't match
		else {
            header("location: ../login?message=wrongpassword");
        }
    }
}

?>
