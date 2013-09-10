<?php
	session_start();
	if (isset($_SESSION["authenticated"])) {
		
	}
	else
		header("Location: ./");
?>
<!doctype html>
<html>
<head>
	<meta charset="UTF-8">
	<link rel="stylesheet" type="text/css" href="./css/style.css">
	<title>HDF - Home</title>
	
</head>
<body>
	<div id="banner">
		<h1>Hoopa Development Fund Management</h1>
	</div>
	<div id="container">
		<div id="side">
			<div>
				<ul>
					<li><a href="./employee_section/myaccount.php">My Account</a></li>
					<li><a href="./logout.php">Log Out</a></li>
				</ul>
			</div>
			<hr><hr>
			<p>Developed by <a href="http://www.speygee.com">Speygee</a></p>
		</div>
		
		<div id="content_wrapper">
			<div id="title">
				<h2>Pick an Option:</h2>
			</div>

			<div id="content">
				<ul id="options">
					<li><a href="./add_borrower/">Add Borrower</a></li>
					<hr>
					<li><a href="./credit_division/edit_credit_borrower/">Edit Credit Borrower</a></li>
					<li><a href="./credit_division/credit_payment/">Credit Payment</a></li>
					<li><a href="./credit_division/view_credit_borrower/">View Credit Borrower</a></li>
					<hr>
					<li><a href="./eda_division/edit_eda_borrower/">Edit EDA Borrower</a></li>
					<li><a href="./eda_division/eda_payment/">EDA Paymnet</a></li>
					<li><a href="./eda_division/view_eda_borrower/">View EDA Borrower</a></li>
					<?php if ($_SESSION["privileges"] == 2): ?>
					<hr>
					<li><a href="./employee_section/add_employee/">Add Employee</a></li>
					<li><a href="./employee_section/edit_employee/">Edit Employee</a></li>
					<li><a href="./employee_section/view_employees/">View Employees</a></li>
					<li><a href="./credit_division/view_credit_edit_log/">View Credit Edit Log</a></li>
					<li><a href="./eda_division/view_eda_edit_log/">View EDA Edit Log</a></li>
					<?php endif; ?>
				</ul>
			</div>
		</div>
	</div>
</body>
</html>