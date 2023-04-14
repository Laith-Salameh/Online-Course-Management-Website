<!DOCTYPE html>
<html lang="en">
	<head>
		<title> Login and Signup</title>
		<link rel="stylesheet" href="<?php echo URL;?>public/css/login.css"> 
		<link rel="icon" type="image/png" href="<?php echo URL;?>public/img/icon.png">
      	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
      	<link href=’https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/themes/ui-lightness/jquery-ui.css’ rel=’stylesheet’>
      	<script src= "https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js" > </script>    
		<script src="//cdn.jsdelivr.net/npm/sweetalert2@10"></script>
		<link rel="stylesheet" href="fontawesome-free-5.15.2-web/css/all.css">
	</head>
	<body>
		<div class="parent">
		<div id="logo-container"> 	
            <a href="<?php echo URL;?>home" id="logo"></a>
		</div>
			<div class="container">
				<div class="buttonBox">
				
					<button Type="button" class="toggleButton" id="log"><strong> Log In</strong></button>
					<button Type="button" class="toggleButton" id="sign"><strong> Sign Up</strong></button>
				 
				</div>
				<div class="formBox">
					<form class="Forms" id="logForm" method="post" action=" <?php echo URL.'login/logedin'?> ">
						<input type="text" class="inputField" id="username" name="my_email" placeholder="Email" >
						<input type="password" class="inputField" id="pass1" name="my_password" placeholder="Password">
						<span  class="showPassword" onclick="togglePassword('pass1')"></span>

						<input type="checkbox" class="checkBox" name="remember_me" value="checked"><span id="rem">Remember me</span>
						<input type="submit" class="submitButton" name="login" value="Log In">
					</form>

					<form class="Forms" id="signForm" method="post" action=" <?php echo htmlspecialchars(URL.'login/signup')?> ">
						

						<input type="text" class="inputField" id="name"  name="first_name" placeholder="First name*" >
						<span id="first_name" class="incorrect"><?php if(isset($_SESSION['nameErr'] ) ) { echo $_SESSION['nameErr'];  unset($_SESSION['nameErr']); }?></span>
						<input type="text" class="inputField" name="last_name" placeholder="Last name (Optional)">
						<input type="text" class="inputField" id="email" name="email_address" placeholder="Email address*" >
						<span id="email_address" class="incorrect"><?php if(isset($_SESSION['emailErr'] ) ) { echo $_SESSION['emailErr'];  unset($_SESSION['emailErr']); }?></span>
						<input type="text" class="inputField" id="phone" name="phone_number" placeholder="Phone number* +XXX-XXXXXXXXX" >
						<span id="phone_number" class="incorrect"><?php if(isset($_SESSION['phoneErr'] ) ) { echo $_SESSION['phoneErr'];  unset($_SESSION['phoneErr']); }?></span>
						<input type="password" class="inputField" name="password" id="pass2" placeholder="Password*" >
						<span  class="showPassword" onclick="togglePassword('pass2')"></span>
						<span id="password_style" class="incorrect"><?php if(isset($_SESSION['passErr'] ) ) { echo $_SESSION['passErr'];  unset($_SESSION['passErr']); }?></span>
						<input type="password" class="inputField" name="password_confirm" id="confirmPassword" placeholder="Confirm Password*">
						<span id="password_confirm" class="incorrect"><?php if(isset($_SESSION['pass2Err'] ) ) { echo $_SESSION['pass2Err'];  unset($_SESSION['pass2Err']); }?></span>
						<div class="gen">
							<label for="gender">Gender:</label>
							<input type="radio"  id="male" name="gender" value="Male" checked>
							<label for="male">Male</label>
							<input type="radio" id="female" name="gender" value="Female">
							<label for="female">Female</label>

						</div>

						<label for="birthday"  id="birthdayLabel">Date of birth*:</label>
						<input type="text" name="birth_date" class="birthday" >
						<span id="birthday_span" class="incorrect"><?php if(isset($_SESSION['birthErr'] ) ) { echo $_SESSION['birthErr'];  unset($_SESSION['birthErr']); }?></span>
						<div class="role">
							<label for="stat">Sign as*:</label>
							<input type="radio"  id="teacher" name="stat" value="teacher">
							<label for="teacher">Teacher</label>
							<input type="radio" id="student" name="stat" value="student" checked>
							<label for="student">Student</label>


						</div>
						<input type="text" class="inputField" id="degree" name="degree" placeholder="Degree*" >
						<?php if(!isset($_SESSION['degreeErr'] ) ) echo '<span class="correct"> if you have more that one degree seperate your degrees with a ", " </span>'; ?>
						<span class="incorrect">  <?php if(isset($_SESSION['degreeErr'] ) ) { echo $_SESSION['degreeErr'];  unset($_SESSION['degreeErr']); }?>  </span> 
						<input type="submit" class="submitButton" name="sign_up" id="signSubmit" value="Sign Up">

						
					</form>
					<script>
      						$("#signForm").hide();
      					</script>
					
				
				</div>
			</div>

			<div class="image"> </div>
            <script src="<?php echo URL;?>public/js/login.js"></script>

			