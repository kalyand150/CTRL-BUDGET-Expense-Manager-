<?php

//preincludes
include '../includes/connection.php';

//get the inputs from post variable trim the white-spaces and apply form injection
$email = trim(mysqli_real_escape_string($con, $_POST['email']));
$password = trim(mysqli_real_escape_string($con, $_POST['password']));
$name = trim(mysqli_real_escape_string($con, $_POST['name']));
$contact = trim(mysqli_real_escape_string($con, $_POST['contact']));

//server validation
//if one of the fields empty
if ($email == "" || $password == "" || $name == "" || $contact == "") {
    header("location: ../signup?message=fieldempty");
} 

//if email is not in correct format
else if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    header("location: ../signup?message=emailwrongformat");
} 

//if password not in correct format
else if (!preg_match("#.*^(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9]).*$#", $password)) {
    header("location: ../signup?message=passwordwrongformat");
} 

//if password is not 6 characters long
else if (strlen($password) < 6) {
    header("location: ../signup?message=shortpassword");
} 

//if name contains digits
else if (preg_match("/[0-9]/", $name)) {
    header("location: ../signup?message=nameinvalid");
} 

//if contact has any alphabet
else if (preg_match("/[a-zA-Z]/", $contact)) {
    header("location: ../signup?message=contactinvalid");
} 

//if contact is not 10 digits long
else if (strlen($contact) < 10) {
    header("location: ../signup?message=shortcontact");
} 

//if validation passess
else {
	
	//encrpyt the password
    $password = md5($password);
	
	//check if email is already present in databases
    $query = "SELECT * FROM users WHERE email = '$email'";
    $check = mysqli_query($con, $query);
	
	//if present redirect to login page
    if (mysqli_num_rows($check) > 0) {
        header('location: ../login?message=existinguser');
    } 
	
	//if not present
	else {
		
		//add the user to users database
        $query = "INSERT INTO users (name,email,password,contact) VALUES('$name','$email','$password','$contact')";
        if (mysqli_query($con, $query) == true) {
			
			//initialise session variables
            $_SESSION['user_id'] = mysqli_insert_id($con);
            $_SESSION['username'] = $name;
            $_SESSION['email'] = $email;
            $_SESSION['phoneno'] = $contact;
			
			//redirect to products page
            header('location: ../home');
        } 
		
		//if couldn't add redirect to login page and show error
		else {
            header('location: ../signup?message=servererror');
        }
    }
}

?>
