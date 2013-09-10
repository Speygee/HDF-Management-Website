<?php
	session_start();
	if(isset($_SESSION["authenticated"])){
		require "../../include.php";
		if (($connection = mysql_connect(HOST, USER, PASS)) === FALSE)
        	die("Could not connect to database");
	    if (mysql_select_db(DB, $connection) === FALSE)
	        die("Could not select database");
	    if($_POST["date_paid_to"] == "")
	    	$_POST["date_paid_to"] = $_POST["date_paid"];
	    if($_POST["late_charges_applied"] == "")
	    	$_POST["late_charges_applied"] = 0;
	    if($_POST["impound_applied"] == "")
	    	$_POST["impound_applied"] = 0;
	    date_default_timezone_set('America/Los_Angeles');
	    $date_paid = mysql_real_escape_string($_POST["date_paid"]);
	    $date_paid_to = mysql_real_escape_string($_POST["date_paid_to"]);
	    $cash_recieved = mysql_real_escape_string($_POST["cash_recieved"]);
	    $late_charges_applied = mysql_real_escape_string($_POST["late_charges_applied"]);

	    $number_of_days = floor((strtotime($date_paid)-strtotime($_SESSION["date_paid"]))/(60*60*24));

	    $interest_applied = round((($_SESSION["interest_rate"]/365)*$number_of_days*$_SESSION["principal_balance"]), 2);
	    $impound_applied = mysql_real_escape_string($_POST["impound_applied"]);
	    $principal_applied = $cash_recieved-($interest_applied+$late_charges_applied+$impound_applied);
	    $principal_balance = $_SESSION["principal_balance"]-$principal_applied;
	    $impound_balance = $_SESSION["impound_balance"]+$impound_applied;

	    $insert = "INSERT credit_payment_history SELECT * FROM current_credit_status WHERE loan_id='$_SESSION[loan_id]'";
	    $update = "UPDATE `current_credit_status` SET `date_paid`='$date_paid',`date_paid_to`='$date_paid_to',`cash_recieved`=$cash_recieved,`late_charges_applied`=$late_charges_applied,`interest_applied`=$interest_applied,`principal_applied`=principal_applied,`impound_applied`=impound_applied,`principal_balance`=$principal_balance,`impound_balance`=$impound_balance,`editor`='$_SESSION[user]' WHERE loan_id='$_SESSION[loan_id]'";
	    $insert_result = mysql_query($insert);
	    if (!$insert_result) {
	    	die("Could Not Query Database");
	    }
	    $update_result = mysql_query($update);
	    if (!$update_result) {
	    	die("Could Not Query Database");
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
	<title>HDF Credit Receipt</title>
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
				<h2>Credit Receipt:</h2>
			</div>

			<div id="content">
				<div id="reciept">
					<p>
						<?= $_SESSION["last_name"]." ". $_SESSION["suffix"] .", ".$_SESSION["first_name"] ?>
					</p>
					<p>
						<?= $_SESSION["loan_id"] ?>
					</p>
					<p>
						Updated Principal Balance: $<?= $principal_balance ?>
					</p>
					<p>
						Updated Impound Balance: $<?= $impound_balance ?>
					</p>
					<p>
						Interest Rate: <?= ($_SESSION["interest_rate"]*100) ?>%
					</p>
					<p>
						Date Paid: <?= $date_paid ?>
					</p>
					<p>
						Date Paid To: <?= $date_paid_to ?>
					</p>
					<p>
						Cash Received: $<?= $cash_recieved ?>
					</p>
					<p>
						Principal Applied: $<?= $principal_applied ?>
					</p>
					<p>
						Interest Applied: $<?= $interest_applied ?>
					</p>
					<p>
						Late Charges Applied: $<?= $late_charges_applied ?>
					</p>
					<p>
						Impound Applied: $<?= $impound_applied ?>
					</p>
				</div>
					
			</div>
		</div>
	</div>
</body>

</html>
