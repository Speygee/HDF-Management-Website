<?php
	session_start();
	if(isset($_SESSION["authenticated"])){
		if (isset($_POST["editing_eda_borrower"])) {
			require "../../include.php";
			if (($connection = mysql_connect(HOST, USER, PASS)) === FALSE)
	        	die("Could not connect to database");
		    if (mysql_select_db(DB, $connection) === FALSE)
		        die("Could not select database");
		    if ($_POST["cash_recieved"] == "")
	        	$_POST["cash_recieved"] = 0;
	        if ($_POST["late_charges_applied"] == "")
	        	$_POST["late_charges_applied"] = 0;
	        if ($_POST["interest_applied"] == "") 
	        	$_POST["interest_applied"] = 0;
	        if ($_POST["principal_applied"] == "") 
	        	$_POST["principal_applied"] = 0;
	        if ($_POST["impound_applied"] == "") 
	        	$_POST["impound_applied"] = 0;
	        if ($_POST["impound_balance"] == "") 
	        	$_POST["impound_balance"] = 0;
	        if ($_POST["date_paid_to"] == "") 
	        	$_POST["date_paid_to"] = $_POST["date_paid"];
	        if ($_POST["interest_rate"] == "") 
	        	$_POST["interest_rate"] = 0;

	        $_POST["loan_id"] = mysql_real_escape_string($_POST["loan_id"]);
	        $_POST["first_name"] = mysql_real_escape_string($_POST["first_name"]);
	        $_POST["last_name"] = mysql_real_escape_string($_POST["last_name"]);
	        $_POST["suffix"] = mysql_real_escape_string($_POST["suffix"]);
	        $_POST["date_paid"] = mysql_real_escape_string($_POST["date_paid"]);
	        $_POST["date_paid_to"] = mysql_real_escape_string($_POST["date_paid_to"]);
	        $_POST["cash_recieved"] = mysql_real_escape_string($_POST["cash_recieved"]);
	        $_POST["late_charges_applied"] = mysql_real_escape_string($_POST["late_charges_applied"]);
	        $_POST["interest_applied"] = mysql_real_escape_string($_POST["interest_applied"]);
	        $_POST["interest_rate"] = mysql_real_escape_string($_POST["interest_rate"]);
	        $_POST["principal_applied"] = mysql_real_escape_string($_POST["principal_applied"]);
	        $_POST["impound_applied"] = mysql_real_escape_string($_POST["impound_applied"]);
	        $_POST["principal_balance"] = mysql_real_escape_string($_POST["principal_balance"]);
	        $_POST["impound_balance"] = mysql_real_escape_string($_POST["impound_balance"]);

	        $_POST["interest_rate"] = $_POST["interest_rate"]/100;
	        date_default_timezone_set('America/Los_Angeles');
	        $today = date("Y-n-j");

	        $insert = "INSERT INTO eda_edit_history (loan_id, first_name, last_name, suffix, date_paid, date_paid_to, cash_recieved, late_charges_applied, interest_applied, interest_rate, principal_applied, impound_applied, principal_balance, impound_balance, editor, date_edited) VALUES ('$_POST[loan_id]','$_POST[first_name]','$_POST[last_name]','$_POST[suffix]','$_POST[date_paid]','$_POST[date_paid_to]',$_POST[cash_recieved],$_POST[late_charges_applied],$_POST[interest_applied],$_POST[interest_rate],$_POST[principal_applied],$_POST[impound_applied],$_POST[principal_balance],$_POST[impound_balance],'$_SESSION[user]', '$today')";
	        	        
	        $insert_result = mysql_query($insert);
	        if (!$insert_result)
	        	die("Could Not Query Database.");
	        
	        $update = "UPDATE current_eda_status SET loan_id='$_POST[loan_id]', first_name='$_POST[first_name]', last_name='$_POST[last_name]', suffix='$_POST[suffix]', date_paid='$_POST[date_paid]', date_paid_to='$_POST[date_paid_to]', cash_recieved=$_POST[cash_recieved], late_charges_applied=$_POST[late_charges_applied], interest_applied=$_POST[interest_applied], interest_rate=$_POST[interest_rate], principal_applied=$_POST[principal_applied], impound_applied=$_POST[impound_applied], principal_balance=$_POST[principal_balance], impound_balance=$_POST[impound_balance], editor='$_SESSION[user]' WHERE `current_eda_status`.`loan_id`='$_SESSION[selected_borrower]'";
	        $update_result = mysql_query($update);
	        if (!$update_result)
	        	die("Could Not Query Database.");
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
	<title>HDF EDA Receipt</title>
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
			</div>
			<hr><hr>
			<p>Developed by <a href="http://www.speygee.com">Speygee</a></p>
		</div>
		
		<div id="content_wrapper">
			<div id="title">
				<h2>EDA Edit Receipt:</h2>
			</div>

			<div id="content">
				<div id="reciept">
					<p>
						<?= $_POST["last_name"]." ". $_POST["suffix"] .", ".$_POST["first_name"] ?>
					</p>
					<p>
						<?= $_POST["loan_id"] ?>
					</p>
					<p>
						Date Paid: <?= $_POST["date_paid"] ?>
					</p>
					<p>
						Date Paid To: <?= $_POST["date_paid_to"] ?>
					</p>
					<p>
						Cash Recieved: $<?= $_POST["cash_recieved"] ?>
					</p>
					<p>
						Late Charges Applied: $<?= $_POST["late_charges_applied"] ?>
					</p>
					<p>
						Interest Applied: $<?= $_POST["interest_applied"] ?>
					</p>
					<p>
						Interest Rate: <?= ($_POST["interest_rate"]*100) ?>%
					</p>
					<p>
						Principal Applied: $<?= $_POST["principal_applied"] ?>
					</p>
					<p>
						Impound Applied: $<?= $_POST["impound_applied"] ?>
					</p>
					<p>
						Principal Balance: $<?= $_POST["principal_balance"] ?>
					</p>
					<p>
						Impound Balance: $<?= $_POST["impound_balance"] ?>
					</p>
				</div>
					
			</div>
		</div>
	</div>
</body>

</html>
