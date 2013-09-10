<?php
	session_start();
	if (isset($_POST["login"])) {
		require "./include.php";
		if (($connection = mysql_connect(HOST, USER, PASS)) === FALSE)
            die("Could not connect to database");
        if (mysql_select_db(DB, $connection) === FALSE)
            die("Could not select database");
        $username = mysql_real_escape_string($_POST["username"]);
		$password = mysql_real_escape_string($_POST["password"]);
		$sql = "SELECT * FROM users WHERE username='$username' AND password=AES_ENCRYPT('$password', '$password')";
		$result = mysql_query($sql);
		if ($result === FALSE) {
			die("Could not Query Database");
		}
		elseif (mysql_num_rows($result) === 1) {
			$row = mysql_fetch_array($result);
			$_SESSION["authenticated"] = TRUE;
			$_SESSION["username"] = $username;
			$_SESSION["user"] = ("$row[first_name] $row[last_name]");
			$_SESSION["privileges"] = $row["user_type"];
			header("Location: ./home.php");
		}
	}
?>
<!doctype html>
<html>
<head>
	<meta charset="UTF-8">
	<link rel="stylesheet" type="text/css" href="./css/style.css">
	<title>HDF - Login</title>
	<script type="text/javascript" src="./js/jquery-1.8.3.js"></script>
	<script type="text/javascript" src="./js/jquery.validate.min.js"></script>
	<script type="text/javascript">
		$(function(){
			$("#login_form").validate({
				rules:{
					username:{
						required: true
					},
					password:{
						required: true
					}
				}
			});
		});
	</script>
</head>
<body OnLoad="document.login.username.focus();">
	<div id="login_container">
		<div id="wrapper">
			<div id="login_wrapper">
				<div>
					<h2>Hoopa Development Fund</h2>
				</div>
				<div id="login-content">
					<form id="login_form" action="" method="post">
						<p>
							<label for="username">Username:<br></label>
							<input type="text" name="username">
						</p>
						<p>
							<label for="password">Password:<br></label>
							<input type="password" name="password">
						</p>

						<input id="button" type="submit" name="login" value="Login">
						<br id="clear">
					</form>
				</div>
			</div>
		</div>
	</div>
</body>
</html>