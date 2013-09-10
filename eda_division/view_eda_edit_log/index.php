<?php
	session_start();
	if(isset($_SESSION["authenticated"])){
		require "../../include.php";
		if (($connection = mysql_connect(HOST, USER, PASS)) === FALSE)
        	die("Could not connect to database");
	    if (mysql_select_db(DB, $connection) === FALSE)
	        die("Could not select database");
	    $sql = "SELECT * FROM eda_edit_history";
	    
	    $result = mysql_query($sql);
	    if(!$result)
	    	die("Could Not Query Database");
	}
	else{
		header('Location: ../../');
		exit;
	}
?>
<!DOCTYPE html>

<html>

<head>
	<meta charset="UTF-8" />
	<link rel="stylesheet" type="text/css" href="../../css/style.css">
	<title>HDF Viewing EDA Edit Log</title>
</head>

<body>
	<header>
		<h1 id="banner">Hoopa Development Fund Management Website</h1>
	</header>
	
	<div id="container">
		<aside id="side">
			<nav>
				<ul>
					<li><a href="../../home.php">Home</a></li>
					<li><a href="../../employee_section/myaccount.php">My Account</a></li>
					<li><a href="../../logout.php">Log Out</a></li>
					<hr>
					<li><a href="../../add_borrower/">Add Borrower</a></li>
					<hr>
					<li><a href="../../credit_division/edit_credit_borrower/">Edit Credit Borrower</a></li>
					<li><a href="../../credit_division/credit_payment/">Credit Payment</a></li>
					<li><a href="../../credit_division/view_credit_borrower/">View Credit Borrower</a></li>
					<hr>
					<li><a href="../edit_eda_borrower/">Edit EDA Borrower</a></li>
					<li><a href="../eda_payment/">EDA Paymnet</a></li>
					<li><a href="../view_eda_borrower/">View EDA Borrower</a></li>
					<?php if ($_SESSION["privileges"] == 2): ?>
					<hr>
					<li><a href="../../employee_section/add_employee/">Add Employee</a></li>
					<li><a href="../../employee_section/edit_employee/">Edit Employee</a></li>
					<li><a href="../../employee_section/view_employees/">View Employees</a></li>
					<hr>
					<li><a href="../../credit_division/view_credit_edit_log/">View Credit Edit Log</a></li>
					<li><a href="../view_eda_edit_log/">View EDA Edit Log</a></li>
					<?php endif; ?>
				</ul>
			</nav>
			<hr><hr>
			<p>Developed by <a href="http://www.speygee.com">Speygee</a></p>
		</aside>
		
		<article id="content_wrapper">
			<header id="title">
				<h2>Viewing EDA Edit Log:</h2>
			</header>

			<section id="content">
				<div>
					<table border="1">
						<tr>
							<th>Loan #</th>
							<th>First Name</th>
							<th>Last Name</th>
							<th>Suffix</th>
							<th>Date Paid</th>
							<th>Paid To</th>
							<th>Cash<br>Received</th>
							<th>Late<br>Charges<br>Applied</th>
							<th>Interest<br>Applied</th>
							<th>Interest<br>Rate</th>
							<th>Principal<br>Applied</th>
							<th>Impound<br>Applied</th>
							<th>Principle<br>Balance</th>
							<th>Impound<br>Balance</th>
							<th>Editor</th>
							<th>Date<br>Edited</th>
						</tr>
					<?php while ($row = mysql_fetch_array($result)): ?>
						<tr>
							<td><?= $row["loan_id"] ?></td>
							<td><?= $row["first_name"] ?></td>
							<td><?= $row["last_name"] ?></td>
							<td><?= $row["suffix"] ?></td>
							<td><?= $row["date_paid"] ?></td>
							<td><?= $row["date_paid_to"] ?></td>
							<td>$<?= $row["cash_recieved"] ?></td>
							<td>$<?= $row["late_charges_applied"] ?></td>
							<td>$<?= $row["interest_applied"] ?></td>
							<td><?= ($row["interest_rate"]*100) ?>%</td>
							<td>$<?= $row["principal_applied"] ?></td>
							<td>$<?= $row["impound_applied"] ?></td>
							<td>$<?= $row["principal_balance"] ?></td>
							<td>$<?= $row["impound_balance"] ?></td>
							<td><?= $row["editor"] ?></td>
							<td><?= $row["date_edited"] ?></td>
						</tr>
					<?php endwhile; ?>
					</table>
				</div>
					
			</section>
		</article>
	</div>
</body>

</html>
