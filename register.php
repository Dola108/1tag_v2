<?php
	session_start();

	// initializing variables
	$username = $_POST['name'];
	$email    = "";
	$password = "";

	// connect to the database
	$db = mysqli_connect('localhost', 'root', '', 'register');

	// REGISTER USER
	if (isset($_POST['reg'])) {
	  // receive all input values from the form
	  $username = mysqli_real_escape_string($db, $_POST['name']);
	  $email = mysqli_real_escape_string($db, $_POST['email']);
	  $password = mysqli_real_escape_string($db, $_POST['psw']);
	}

  // first check the database to make sure 
  // a user does not already exist with the same username and/or email
  $user_check_query = "SELECT * FROM users WHERE username='$username' OR email='$email' LIMIT 1";
  $result = mysqli_query($db, $user_check_query);
  $user = mysqli_fetch_assoc($result);
  
  if ($user) { // if user exists
    if ($user['username'] === $username) {
      echo "<script>
			alert('Same username exists!');
			</script>";
    }

    if ($user['email'] === $email) {
      echo "<script>
			alert('Same user exists!');
			</script>";
    }
  }

  // Finally, register user if there are no errors in the form
  if (isset($_POST['reg'])) {
  	$password = md5($password);//encrypt the password before saving in the database

  	$query = "INSERT INTO users (username, email, password) 
  			  VALUES('$username', '$email', '$password')";
  	mysqli_query($db, $query);
  	$_SESSION['username'] = $username;
  	$_SESSION['success'] = "You are now logged in";
  	header('location: register.php');
  }

  
}

?>
<!DOCTYPE html>
<html>
<head>
	<link rel="stylesheet" type="text/css" href="theme.css">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>1Tag</title>
</head>
<body>
	<nav id="myHeader" style="margin-left: -9px; margin-right: -9px; margin-top: -8px; position: fixed; top: 8px; width: 100%;">
	    <ul class="ls">
	        <li class="ls"><a href="http://localhost/proj/dashboard.php?val=1">Dashboard</a></li>
	        <li class="ls"><a href="http://localhost/proj/tagboard.php?val=Tags">Tags</a></li>
	        <li class="ls"><a href="#">Search</a></li>
	        <li class="ls"><a href="#">Others</a></li>
	    </ul>
	<button type="button" id="logout" class="button3"  onclick="window.location.href = 'http://localhost/proj/1Tag.html'" 
													   value="check" style="															        margin-right: 5%;
		        										   padding: 6px 16px;
		        										   font-size: 14px;
		        										   margin-top: -3%;">Log out</button>
	</nav>

		<div class="profile_container">
			<img src="blankavatar.png" alt="Avatar" class="avatar">
			<?php
				echo "<h3>". $_SESSION['name']."</h3>";
			?>
			<nav>
				<ul class="ls" style="background-color: rgba(0,0,0,0.4);">
			        <li class="ls" style="width: 100%;"><a href="http://localhost/proj/dashboard.php?val=1">Write Post</a></li>
				</ul>
				<ul class="ls" style="background-color: rgba(0,0,0,0.4);">
					<li class="ls" style="width: 100%;"><a href="#">Posts</a></li>
				</ul>
				<ul class="ls" style="background-color: rgba(0,0,0,0.4);">
			        <li class="ls" style="width: 100%; padding-bottom: 146%;"><a href="#">Likes</a></li>
				</ul>
			</nav>
		</div>
			
		<div class="post_container">
			<article>
				<h2 style="color: #eaeaea; text-shadow: 4px 5px 10px black;">No posts to show.</h2>
			</article> 
		</div>

	<footer style="margin-top: -8px; margin-left: -9px; margin-right: -6.5px;">Copyright &copy; 1tag.com</footer>

</body>
</html>
