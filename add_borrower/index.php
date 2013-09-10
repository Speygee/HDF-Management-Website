<?php
	session_start();
	
	if(isset($_SESSION["authenticated"])) {
		if(isset($_POST["adding_borrower"])) {
			require "../include.php";
			if(($connection = mysql_connect(HOST, USER, PASS)) === FALSE)
	            die("Could not connect to database");
	        if(mysql_select_db(DB, $connection) === FALSE)
	            die("Could not select database");
	        
	        if ($_POST["cash_recieved"] == "")
	        	$_POST["cash_recieved"] = 0;
	        if ($_POST["impound_balance"] == "") 
	        	$_POST["impound_balance"] = 0;
	        if ($_POST["interest_rate"] == "") 
	        	$_POST["interest_rate"] = 0;
	        if ($_POST["loan_type"] == 1)
	        	$_POST["loan_type"] = "current_credit_status";
	        if ($_POST["loan_type"] == 2)
	        	$_POST["loan_type"] = "current_eda_status";

	        $_POST["loan_id"] = mysql_real_escape_string($_POST["loan_id"]);
	        $_POST["loan_type"] = mysql_real_escape_string($_POST["loan_type"]);
	        $_POST["first_name"] = mysql_real_escape_string($_POST["first_name"]);
	        $_POST["last_name"] = mysql_real_escape_string($_POST["last_name"]);
	        $_POST["suffix"] = mysql_real_escape_string($_POST["suffix"]);
	        $_POST["date_paid"] = mysql_real_escape_string($_POST["date_paid"]);
	        $_POST["cash_recieved"] = mysql_real_escape_string($_POST["cash_recieved"]);
	        $_POST["interest_rate"] = mysql_real_escape_string($_POST["interest_rate"]);
	        $_POST["principal_balance"] = mysql_real_escape_string($_POST["principal_balance"]);
	        $_POST["impound_balance"] = mysql_real_escape_string($_POST["impound_balance"]);

	        $_POST["interest_rate"] = $_POST["interest_rate"]/100;

	        $sql = "INSERT INTO $_POST[loan_type] (loan_id, first_name, last_name, suffix, date_paid, date_paid_to, cash_recieved, late_charges_applied, interest_applied, interest_rate, principal_applied, impound_applied, principal_balance, impound_balance, editor) VALUES('$_POST[loan_id]', '$_POST[first_name]', '$_POST[last_name]', '$_POST[suffix]', '$_POST[date_paid]', '$_POST[date_paid]', $_POST[cash_recieved], '0', '0', $_POST[interest_rate], '0', '0', $_POST[principal_balance], $_POST[impound_balance], '$_SESSION[user]')";
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
	<link rel="stylesheet" type="text/css" href="../css/style.css">
	<title>HDF - Add Borrower</title>

	<script type="text/javascript" src="../js/jquery-1.8.3.js"></script>
	<script type="text/javascript" src="../js/jquery.validate.min.js"></script>
	<script type="text/javascript">
		$(function(){
			$("#form").validate({
				rules:{
					loan_id:{
						required: true
					},
					first_name:{
						required: true
					},
					last_name:{
						required: true
					},
					date_paid:{
						required: true
					},
					cash_recieved:{
						number:true
					},
					interest_rate:{
						number: true
					},
					principal_balance:{
						required: true,
						number: true
					},
					impound_balance:{
						number: true
					},

				}
			});
		});
	</script>
</head>

<body OnLoad="document.add_borrower.loan_id.focus();">
	<div id="banner">
		<h1>Hoopa Development Fund Management</h1>
	</div>

	<div id="container">
		<div id="side">
			<div>
				<ul>
					<li><a href="../home.php">Home</a></li>
					<li><a href="../employee_section/myaccount.php">My Account</a></li>
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
					<li><a href="../employee_section/add_employee/">Add Employee</a></li>
					<li><a href="../employee_section/edit_employee/">Edit Employee</a></li>
					<li><a href="../employee_section/view_employees/">View Employees</a></li>
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
				<h2>Adding Borrower:</h2>
			</div>

			<div id="content">
			<?php if (isset($success)): ?>
				<div id="messages">
					<p>Sucessfully Added <?= $_POST["loan_id"] . " | " . $_POST["last_name"] . " " . $_POST["suffix"] . ", " . $_POST["first_name"] ?><br>Continue Adding or Select Another Option from Side Menu</p>
				</div>
			<?php endif; ?>
				<form id="form" name="add_borrower" action="" method="post">
					<p>
						<label for="loan_id">* Loan #:</label><br>
						<input id="loan_id" type="text" name="loan_id" >
					</p>
					<p>
						<label>* Loan Department:</label>
					</p>
					<p>
						<input id="credit_loan" type="radio" name="loan_type" value="1" ><label for="credit_loan"> Credit Department</label>
					</p>
					<p>
						<input id="eda_loan" type="radio" name="loan_type" value="2" ><label for="eda_loan"> EDA Department</label>
					</p>
					<p>
						<label for="first_name">* First Name:</label><br>
						<input id="first_name" type="text" name="first_name" >
					</p>
					<p>
						<label for="last_name">* Last Name:</label><br>
						<input id="last_name" type="text" name="last_name" >
					</p>
					<p>
						<label for="suffix">Suffix:</label><br>
						<input id="suffix" type="text" name="suffix" >
					</p>
					<p>
						<label for="date_paid">* Last Date Paid (yyyy-mm-dd):</label><br>
						<input id="date_paid" type="text" name="date_paid" >
					</p>
					<p>
						<label for="cash_recieved">Payment Amount:</label><br>
						$<input id="cash_recieved" size="19" type="text" name="cash_recieved" >
					</p>
					<p>
						<label for="interest_rate">Interest Rate:</label><br>
						<input id="interest_rate" size="19" type="text" name="interest_rate" >%
					</p>
					<p>
						<label for="principal_balance">* Principal Balance:</label><br>
						$<input id="principal_balance" size="19" type="text" name="principal_balance" >
					</p>
					<p>
						<label for="impound_balance">Impound Balance:</label><br>
						$<input id="impound_balance" size="19" type="text" name="impound_balance" >
					</p>
					<input type="submit" id="submit" name="adding_borrower" value="Add Borrower">
				</form>
			</div>
		</div>
	</div>
</body>
</html>