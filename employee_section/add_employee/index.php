<?php
	session_start();
	
	if(isset($_SESSION["authenticated"])) {
		if(isset($_POST["adding_employee"])) {
			require "../../include.php";
			if(($connection = mysql_connect(HOST, USER, PASS)) === FALSE)
	            die("Could not connect to database");
	        if(mysql_select_db(DB, $connection) === FALSE)
	            die("Could not select database");
	       
	        $_POST["username"] = mysql_real_escape_string($_POST["username"]);
	        $_POST["password"] = mysql_real_escape_string($_POST["password"]);
	        $_POST["first_name"] = mysql_real_escape_string($_POST["first_name"]);
	        $_POST["last_name"] = mysql_real_escape_string($_POST["last_name"]);

	        $sql = "INSERT INTO users (username, password, first_name, last_name) VALUES ('$_POST[username]', AES_ENCRYPT('$_POST[password]','$_POST[password]'), '$_POST[first_name]', '$_POST[last_name]')";
			$result = mysql_query($sql);
			if ($result == FALSE) {
				die("Could Not Query Database");
			}
			else{
				$success = TRUE;
			}
		}
	}
	else
		header("Location: ../");
?>

<!DOCTYPE html>
<html>

<head>
	<meta charset="UTF-8">
	<link rel="stylesheet" type="text/css" href="../../css/style.css">
	<script type="text/javascript" href="../../js/jquery.js"></script>
	<script type="text/javascript" href="../../js/jquery.validate.js"></script>
	<title>HDF - Add Employee</title>

	<script type="text/javascript">
		$(document).ready(function(){
			alert("hI");
		});
	</script>
</head>

<body>
	<header id="banner">
		<h1>Hoopa Development Fund Management</h1>
	</header>

	<div id="container">
		<aside id="side">
			<nav>
				<ul>
					<li><a href="../../home.php">Home</a></li>
					<li><a href="../myaccount.php">My Account</a></li>
					<li><a href="../../logout.php">Log Out</a></li>
					<hr>
					<li><a href="../../add_borrower/">Add Borrower</a></li>
					<hr>
					<li><a href="../../credit_division/edit_credit_borrower/">Edit Credit Borrower</a></li>
					<li><a href="../../credit_division/credit_payment/">Credit Payment</a></li>
					<li><a href="../../credit_division/view_credit_borrower/">View Credit Borrower</a></li>
					<hr>
					<li><a href="../../eda_division/edit_eda_borrower/">Edit EDA Borrower</a></li>
					<li><a href="../../eda_division/eda_payment/">EDA Paymnet</a></li>
					<li><a href="../../eda_division/view_eda_borrower/">View EDA Borrower</a></li>
					<?php if ($_SESSION["privileges"] == 2): ?>
					<hr>
					<li><a href="../add_employee/">Add Employee</a></li>
					<li><a href="../edit_employee/">Edit Employee</a></li>
					<li><a href="../view_employees/">View Employees</a></li>
					<hr>
					<li><a href="../../credit_division/view_credit_edit_log/">View Credit Edit Log</a></li>
					<li><a href="../../eda_division/view_eda_edit_log/">View EDA Edit Log</a></li>
					<?php endif; ?>
				</ul>
			</nav>
			<hr><hr>
			<p>Developed by <a href="http://www.speygee.com">Speygee</a></p>
		</aside>
		
		<article id="content_wrapper">
			<header id="title">
				<h2>Adding Employee:</h2>
			</header>

			<section id="content">
			<?php if (isset($success)): ?>
				<div id="messages">
					<p>Sucessfully Added <?= $_POST["username"] . " | " . $_POST["last_name"] . ", " . $_POST["first_name"] ?><br>Continue Adding or Select Another Option from Side Menu</p>
				</div>
			<?php endif; ?>
				<form id="form" name="add_employee" action="" method="post">
					<p>
						<label for="username">* Username:</label><br>
						<input id="username" type="text" name="username" >
					</p>
					<p>
						<label for="password">* Password:</label><br>
						$<input id="password" size="19" type="password" name="password" >
					</p>
					<p>
						<label for="first_name">* First Name:</label><br>
						$<input id="first_name" size="19" type="text" name="first_name" >
					</p>
					<p>
						<label for="last_name">* Last Name:</label><br>
						$<input id="last_name" size="19" type="text" name="last_name" >
					</p>
					<input type="submit" id="submit" name="adding_employee" value="Add Employee">
				</form>
			</section>
		</article>
	</div>
</body>
</html>