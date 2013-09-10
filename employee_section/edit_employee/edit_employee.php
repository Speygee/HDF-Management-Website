<?php
	session_start();
	
	if(isset($_SESSION["authenticated"])) {
		if(isset($_POST["edit_employee"])) {
			require "../../include.php";
			if(($connection = mysql_connect(HOST, USER, PASS)) === FALSE)
	            die("Could not connect to database");
	        if(mysql_select_db(DB, $connection) === FALSE)
	            die("Could not select database");


	        $sql = "UPDATE users SET username='$_POST[username]', first_name='$_POST[first_name]', last_name='$_POST[last_name]', password=AES_ENCRYPT('$_POST[password]','$_POST[password]') WHERE username='$_SESSION[selected_employee]'";
			$result = mysql_query($sql);
			if ($result == FALSE) {
				die("Could Not Query Database");
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
	<title>HDF - New Employee Info</title>
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
				<h2>New Employee Info:</h2>
			</header>

			<section id="content">
				<p>
					Username: <?= $_POST["username"] ?>
				</p>
				<p>
					First Name: <?= $_POST["first_name"] ?>
				</p>
				<p>
					Last Name: <?= $_POST["last_name"] ?>
				</p>
			</section>
		</article>
	</div>
</body>
</html>