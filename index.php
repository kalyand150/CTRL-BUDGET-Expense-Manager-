<!--preincludes-->
<?php include 'includes/connection.php'?>
<?php include 'includes/checklogin.php' ?>

<?php 
//redirect to home if logged in
if($loggedin){
    header('location: home');
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
    <?php include 'includes/header.php' ?>

    <!--bg-image -->
    <div class="bg-image"></div>

    <!--index page -->
    <div class="container px-3  flex-grow-1 d-flex flex-column justify-content-center">
        <div class="faded-bg px-2 text-center">
            <div class="py-5">
                <p class="h3 my-3 font-italic text-white">We help you to control your budget</p>
                <a  href="login" class="my-3 px-sm-4 py-sm-2 rounded-lg btn btn-info">START TODAY</a>
            </div>
        </div>
    </div>
    
    <!--footer-->
    <?php include 'includes/footer.php' ?>

    <!-- jQuery -->
    <script src="resources/jquery/jquery.min.js"></script>

    <!-- Popper js -->
    <script src="resources/popper/popper.min.js"></script>

    <!-- Bootstrap-->
    <script src="resources/bootstrap/bootstrap.min.js"></script>
</body>

</html>