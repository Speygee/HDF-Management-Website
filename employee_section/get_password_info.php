<?php
	session_start();
	
	if(isset($_SESSION["authenticated"])) {

		if(isset($_POST["update"])) {
			if ($_POST["current_password"] == "" || $_POST["new_password"] == "" || $_POST["repeat_password"] == "") {
				$blank_error = TRUE;
			}
			elseif ($_POST["new_password"] != $_POST["repeat_password"]) {
				$mismatch_error = TRUE;
			}
			else{
				require "../include.php";
				if(($connection = mysql_connect(HOST, USER, PASS)) === FALSE)
		            die("Could not connect to database");
		        if(mysql_select_db(DB, $connection) === FALSE)
		            die("Could not select database");
				$sql = "UPDATE users SET password=AES_ENCRYPT('$_POST[new_password]','$_POST[new_password]') WHERE username='$_SESSION[username]' AND password=AES_ENCRYPT('$_POST[current_password]','$_POST[current_password]')";
				$result = mysql_query($sql);
				if(mysql_affected_rows() == 1){
					$_SESSION["updated_password"] = TRUE;
					header("Location: ./myaccount.php");
				}
				elseif ($result == FALSE)
					die("Could Not Query Database");
				else{
					$password_error = TRUE;
				}	
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
					if (isset($blank_error)) {
						if ($blank_error == TRUE) {
							print ("<p style='color:red;'>One or More Fields were Blank!</p>");
						}
						$blank_error = FALSE;
					}
				?>
				<?php
					if (isset($password_error)) {
						if ($password_error == TRUE) {
							print ("<p style='color:red;'>Password was Incorrect!</p>");
						}
						$password_error == FALSE;
					}
				?>
				<?php
					if (isset($mismatch_error)) {
						if ($mismatch_error == TRUE) {
							print ("<p style='color:red;'>Passwords did not Match!</p>");
						}
						$mismatch_error == FALSE;
					}
				?>
				<form id="form" name="edit_employee" action="" method="post">
					<p>
						<label for="current_password">* Current Password:</label><br>
						<input id="current_password" type="password" name="current_password">
					</p>
					<p>
						<label for="new_password">* New Password:</label><br>
						<input id="new_password" type="password" name="new_password">
					</p>
					<p>
						<label for="repeat_password">* Repeat Password:</label><br>
						<input id="repeat_password" type="password" name="repeat_password">
					</p>
					<input type="submit" id="submit" name="update" value="Edit My Account">
				</form>
			</div>
		</div>
	</div>
</body>
</html>