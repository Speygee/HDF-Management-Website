<?php
	session_start();
	if (isset($_SESSION["authenticated"])) {
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
		        $sql = "SELECT * FROM current_eda_status WHERE loan_id='$_POST[borrower]'";
				$result = mysql_query($sql);
				if ($result == FALSE) 
					die("Could Not Query Database");
				$_SESSION["selected_borrower"] = $_POST["borrower"];
			}
		}
	}
	else
		header("Location: ../../");
?>

<!DOCTYPE html>
<html>

<head>
	<meta charset="UTF-8">
	<link rel="stylesheet" type="text/css" href="../../css/style.css">
	<title>HDF - Gathering EDA Edit Info</title>
	
	<script type="text/javascript" src="../../js/jquery-1.8.3.js"></script>
	<script type="text/javascript" src="../../js/jquery.validate.min.js"></script>
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
						required: true,
						number: true
					},
					late_charges_applied:{
						number: true
					},
					interest_applied:{
						number: true
					},
					interest_rate:{
						number: true
					},
					principal_applied:{
						number: true
					},
					impound_applied:{
						number: true
					},
					principal_balance:{
						required: true,
						number: true
					},
					impound_balance:{
						number: true
					}
				}
			});
		});
	</script>
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
				<h2>Apply Updated Information for EDA Borrower:</h2>
			</div>

			<div id="content">
				<form id="form" name="edit_borrower" action="./edit_eda_borrower.php" method="post">
				<?php while($row = mysql_fetch_array($result)): ?>
					<p>
						<label for="loan_id">* Loan #:</label><br>
						<input id="loan_id" type="text" name="loan_id" value="<?= $row['loan_id'] ?>">
					</p>
					<p>
						<label for="first_name">* First Name:</label><br>
						<input id="first_name" type="text" name="first_name" value="<?= $row['first_name'] ?>">
					</p>
					<p>
						<label for="last_name">* Last Name:</label><br>
						<input id="last_name" type="text" name="last_name" value="<?= $row['last_name'] ?>">
					</p>
					<p>
						<label for="suffix">Suffix:</label><br>
						<input id="suffix" type="text" name="suffix" value="<?= $row['suffix'] ?>">
					</p>
					<p>
						<label for="date_paid">* Date Paid (yyyy-mm-dd):</label><br>
						<input id="date_paid" type="text" name="date_paid" value="<?= $row['date_paid'] ?>">
					</p>
					<p>
						<label for="date_paid_to">Paid To (yyyy-mm-dd):</label><br>
						<input id="date_paid_to" type="text" name="date_paid_to" value="<?= $row['date_paid_to'] ?>">
					</p>
					<p>
						<label for="cash_recieved">* Cash Received:</label><br>
						$<input id="cash_recieved" size="19" type="text" name="cash_recieved" value="<?= $row['cash_recieved'] ?>">
					</p>
					<p>
						<label for="late_charges_applied">Late Charges:</label><br>
						$<input id="late_charges_applied" size="19" type="text" name="late_charges_applied" value="<?= $row['late_charges_applied'] ?>">
					</p>
					<p>
						<label for="interest_applied">Interest Applied:</label><br>
						$<input id="interest_applied" size="19" type="text" name="interest_applied" value="<?= $row['interest_applied'] ?>">
					</p>
					<p>
						<label for="interest_rate">Interest Rate:</label><br>
						<input id="interest_rate" size="19" type="text" name="interest_rate" value="<?= ($row['interest_rate']*100) ?>">%
					</p>
					<p>
						<label for="principal_applied">Principal Applied:</label><br>
						$<input id="principal_applied" size="19" type="text" name="principal_applied" value="<?= $row['principal_applied'] ?>">
					</p>
					<p>
						<label for="impound_applied">Impound Applied:</label><br>
						$<input id="impound_applied" size="19" type="text" name="impound_applied" value="<?= $row['impound_applied'] ?>">
					</p>
					<p>
						<label for="principal_balance">* Principal Balance:</label><br>
						$<input id="principal_balance" size="19" type="text" name="principal_balance" value="<?= $row['principal_balance'] ?>">
					</p>
					<p>
						<label for="impound_balance">Impound Balance:</label><br>
						$<input id="impound_balance" size="19" type="text" name="impound_balance" value="<?= $row['impound_balance'] ?>">
					</p>
					<input type="submit" name="editing_eda_borrower" value="Edit EDA Borrower">
				</form>
			<?php endwhile; ?>
			</div>
		</div>
	</div>
</body>
</html>