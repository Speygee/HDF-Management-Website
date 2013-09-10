<?php
	session_start();
	
	if(isset($_SESSION["authenticated"])) {

		require "../include.php";
		if(($connection = mysql_connect(HOST, USER, PASS)) === FALSE)
            die("Could not connect to database");
        if(mysql_select_db(DB, $connection) === FALSE)
            die("Could not select database");

        $info = "SELECT * FROM users WHERE username='$_SESSION[username]'";
        $info_result = mysql_query($info);
        if ($info_result == FALSE) 
			die("Could Not Query Database");

		if(isset($_POST["update"])) {
	        $sql = "UPDATE users SET username='$_POST[username]', password=AES_ENCRYPT('$_POST[password]','$_POST[password]') WHERE username='$_SESSION[username]'";
			$result = mysql_query($sql);
			if ($result == FALSE)
				die("Could Not Query Database");
			else{
				$_SESSION["username"] = $_POST["username"];
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
	<link rel="stylesheet" type="text/css" href="../css/style.css">
	<title>HDF - My Account</title>
</head>

<body>
	<div id="banner">
		<h1>Hoopa Development Fund Management</h1>
	</div>

	<div id="container">
		<div id="side">
			<div>
				<ul>
					<li><a href="../home.php">Home</a></li>
					<li><a href="./myaccount.php">My Account</a></li>
					<li><a href="../logout.php">Log Out</a></li>
					<hr>
					<li><a href="../add_borrower/">Add Borrower</a></li>
					<hr>
					<li><a href="../credit_division/edit_credit_borrower/">Edit Credit Borrower</a></li>
					<li><a href="../credit_division/credit_payment/">Credit Payment</a></li>
					<li><a href="../credit_division/view_credit_borrower/">View Credit Borrower</a></li>
					<hr>
					<li><a href="../eda_division/edit_eda_borrower/">Edit EDA Borrower</a></li>
					<li><a href="../eda_division/eda_payment/">EDA Paymnet</a></li>
					<li><a href="../eda_division/view_eda_borrower/">View EDA Borrower</a></li>
					<?php if ($_SESSION["privileges"] == 2): ?>
					<hr>
					<li><a href="./add_employee/">Add Employee</a></li>
					<li><a href="./edit_employee/">Edit Employee</a></li>
					<li><a href="./view_employees/">View Employees</a></li>
					<hr>
					<li><a href="../credit_division/view_credit_edit_log/">View Credit Edit Log</a></li>
					<li><a href="../eda_division/view_eda_edit_log/">View EDA Edit Log</a></li>
					<?php endif; ?>
				</ul>
			</div>
			<hr><hr>
			<p>Developed by <a href="http://www.speygee.com">Speygee</a></p>
		</div>
		
		<div id="content_wrapper">
			<div id="title">
				<h2>My Account</h2>
			</div>

			<div id="content">
				<?php
					if (isset($_SESSION["updated_username"])) {
						if ($_SESSION["updated_username"] == TRUE) {
							print("<p>Successfully Updated Username.</p>");
						}
						$_SESSION["updated_username"] = FALSE;
					}
				?>
				<?php
					if (isset($_SESSION["updated_password"])) {
						if ($_SESSION["updated_password"] == TRUE) {
							print("<p>Successfully Updated Password.</p>");
						}
						$_SESSION["updated_password"] = FALSE;
					}
				?>
				<ul id="options">
					<li><a href="./get_username_info.php">Change Username</a></li>
					<li><a href="./get_password_info.php">Change Password</a></li>
				</ul>
			</div>
		</div>
	</div>
</body>
</html>