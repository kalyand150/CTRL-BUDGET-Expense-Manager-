
<!--header content -->
<header class="header py-2 fixed-top bg-dark">
  <div class="container">
	<nav class="navbar navbar-expand-md navbar-dark p-0" >
	  <a style="color:#CDCDCD" class="navbar-brand" href="index">CT&#8377;L BUDGET</a>
	  <a class="navbar-toggler d-md-none" type="button" data-toggle="collapse" href="#collapsibleNavId">
		<span class="navbar-toggler-icon"></span>
	  </a>

	  <!--navbar-->
	  <div class="collapse navbar-collapse" id="collapsibleNavId">
		<ul class="navbar-nav ml-auto mt-2 mt-lg-0">
		  <li class="nav-item">
			<a class="nav-link row active" href="about">
			  <span class="fa-stack fa-lg">
			    <i class="fa fa-info-circle fa-stack-1x "></i>
			  </span>
			  <span class="ml-n1">About Us</span>
			</a>
		  </li>
		
		<!--display this menu if not logged in -->
		<?php if (!$loggedin) { ?>
		  <li class="nav-item">
			<a class="nav-link row active" href="signup">
			  <span class="fa-stack fa-lg">
			    <i class="fa fa-user-plus fa-stack-1x "></i>
			  </span>
			  <span>Sign Up</span>
			</a>
		  </li>
		  <li class="nav-item">
			<a class="nav-link active row" href="login">
			  <span class="fa-stack fa-lg"> 
			    <i class="fa fa-sign-in  fa-stack-1x"></i> 
			  </span>
			  <span>Login</span>
			</a>
		  </li>

		<!-- display this menu if logged in -->
		<?php } else {?>
		  <li class="nav-item">
			<a class="nav-link row active" href="resetpassword">
			  <span class="fa-stack fa-lg">
			    <i class="fa fa-gear fa-stack-1x "></i>
			  </span>
			  <span>Change Password</span>
			</a>
		  </li>
		  <li class="nav-item">
			<a class="nav-link active row" href="process/logout">
			  <span class="fa-stack fa-lg"> 
			    <i class="fa fa-sign-out fa-stack-1x"></i> 
			  </span>
			  <span>Logout</span>
			</a>
		  </li>
		<?php }?>

		</ul>
	  </div>
	</nav>
  </div>
</header>
