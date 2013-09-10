<?php
	session_start();
	if(isset($_SESSION["authenticated"])){
		if (isset($_POST["selected_borrower"])) {
			if ($_POST["borrower"] == "") {
				$_SESSION["blank_error"] = TRUE;
				header("Location: ./");
			}
			else{
				require "../../include.php";
				if (($connection = mysql_connect(HOST, USER, PASS)) === FALSE)
		        	die("Could not connect to database");
			    if (mysql_select_db(DB, $connection) === FALSE)
			        die("Could not select database");
			    $current = "SELECT * FROM current_credit_status WHERE loan_id='$_POST[borrower]'";
			    $history = "SELECT * FROM credit_payment_history WHERE loan_id='$_POST[borrower]' ORDER BY `credit_payment_history`.`date_paid` DESC";
			    
			    $current_result = mysql_query($current);
			    if(!$current_result)
			    	die("Could Not Query Database");
			    while ($current_row = mysql_fetch_array($current_result)){
			    	$loan_id = $current_row["loan_id"];
			    	$first_name = $current_row["first_name"];
			    	$last_name = $current_row["last_name"];
			    	$suffix = $current_row["suffix"];
			    	$date_paid = $current_row["date_paid"];
			    	$date_paid_to = $current_row["date_paid_to"];
			    	$cash_recieved = $current_row["cash_recieved"];
			    	$late_charges_applied = $current_row["late_charges_applied"];
			    	$interest_applied = $current_row["interest_applied"];
			    	$interest_rate = $current_row["interest_rate"];
			    	$principal_applied = $current_row["principal_applied"];
			    	$impound_applied = $current_row["impound_applied"];
			    	$principal_balance = $current_row["principal_balance"];
			    	$impound_balance = $current_row["impound_balance"];
			    }
			    date_default_timezone_set('America/Los_Angeles');
			    $daily_rate = ($interest_rate/365);
			    $days_passed = floor((strtotime(date("Y-n-j"))-strtotime($date_paid))/(60*60*24));
			    $growing = round(($daily_rate*$principal_balance),2);
			    $interest_accrued = round(($daily_rate * $days_passed * $principal_balance),2);

			    $history_result = mysql_query($history);
			    if(!$history_result)
			    	die("Could Not Query Database");
			}
				
		}
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
	<title>HDF Viewing Credit Borrower</title>
</head>

<body>
	<div id="banner">
		<h1>Hoopa Development Fund Management</h1>
	</div>
	
	<div id="container">
		<div id="side">
			<div>
				<ul>
					<li><a href="../../home.php">Home</a></li>
					<li><a href="../../employee_section/myaccount.php">My Account</a></li>
					<li><a href="../../logout.php">Log Out</a></li>
					<hr>
					<li><a href="../../add_borrower/">Add Borrower</a></li>
					<hr>
					<li><a href="../edit_credit_borrower/">Edit Credit Borrower</a></li>
					<li><a href="../credit_payment/">Credit Payment</a></li>
					<li><a href="../view_credit_borrower/">View Credit Borrower</a></li>
					<hr>
					<li><a href="../../eda_division/edit_eda_borrower/">Edit EDA Borrower</a></li>
					<li><a href="../../eda_division/eda_payment/">EDA Paymnet</a></li>
					<li><a href="../../eda_division/view_eda_borrower/">View EDA Borrower</a></li>
					<?php if ($_SESSION["privileges"] == 2): ?>
					<hr>
					<li><a href="../../employee_section/add_employee/">Add Employee</a></li>
					<li><a href="../../employee_section/edit_employee/">Edit Employee</a></li>
					<li><a href="../../employee_section/view_employees/">View Employees</a></li>
					<hr>
					<li><a href="../view_credit_edit_log/">View Credit Edit Log</a></li>
					<li><a href="../../eda_division/view_eda_edit_log/">View EDA Edit Log</a></li>
					<?php endif; ?>
				</ul>
			</div>
			<hr><hr>
			<p>Developed by <a href="http://www.speygee.com">Speygee</a></p>
		</div>
		
		<div id="content_wrapper">
			<div id="title">
				<h2>Viewing Credit Borrower:</h2>
			</div>

			<div id="content">
				<div>
					<p>
						Interest Accrued for <?= date("Y-n-j") ?>: $<?= $interest_accrued ?>
					</p>
					<p>
						Growing at a rate of $<?= $growing ?> a day.
					</p>
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
						</tr>

						<tr>
							<td><?= $loan_id ?></td>
							<td><?= $first_name ?></td>
							<td><?= $last_name ?></td>
							<td><?= $suffix ?></td>
							<td><?= $date_paid ?></td>
							<td><?= $date_paid_to ?></td>
							<td>$<?= $cash_recieved ?></td>
							<td>$<?= $late_charges_applied ?></td>
							<td>$<?= $interest_applied ?></td>
							<td><?= ($interest_rate*100) ?>%</td>
							<td>$<?= $principal_applied ?></td>
							<td>$<?= $impound_applied ?></td>
							<td>$<?= $principal_balance ?></td>
							<td>$<?= $impound_balance ?></td>
						</tr>
					<?php while ($history_row = mysql_fetch_array($history_result)): ?>
						<tr>
							<td><?= $history_row["loan_id"] ?></td>
							<td><?= $history_row["first_name"] ?></td>
							<td><?= $history_row["last_name"] ?></td>
							<td><?= $history_row["suffix"] ?></td>
							<td><?= $history_row["date_paid"] ?></td>
							<td><?= $history_row["date_paid_to"] ?></td>
							<td>$<?= $history_row["cash_recieved"] ?></td>
							<td>$<?= $history_row["late_charges_applied"] ?></td>
							<td>$<?= $history_row["interest_applied"] ?></td>
							<td><?= ($history_row["interest_rate"]*100) ?>%</td>
							<td>$<?= $history_row["principal_applied"] ?></td>
							<td>$<?= $history_row["impound_applied"] ?></td>
							<td>$<?= $history_row["principal_balance"] ?></td>
							<td>$<?= $history_row["impound_balance"] ?></td>
						</tr>
					<?php endwhile; ?>
					</table>
				</div>
					
			</div>
		</div>
	</div>
</body>

</html>
