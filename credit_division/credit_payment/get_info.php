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
		        $sql = "SELECT * FROM current_credit_status WHERE loan_id='$_POST[borrower]'";
				$result = mysql_query($sql);
				if ($result == FALSE) {
					die("Could Not Query Database");
				}
				else{
					while ($row = mysql_fetch_array($result)) {
						$_SESSION["loan_id"] = $row["loan_id"];
						$_SESSION["first_name"] = $row["first_name"];
						$_SESSION["last_name"] = $row["last_name"];
						$_SESSION["suffix"] = $row["suffix"];
						$_SESSION["interest_rate"] = $row["interest_rate"];
						$_SESSION["principal_balance"] = $row["principal_balance"];
						$_SESSION["impound_balance"] = $row["impound_balance"];

						$_SESSION["date_paid"] = $row["date_paid"];
						$date_paid_to = $row["date_paid_to"];
						$cash_recieved = $row["cash_recieved"];
						$late_charges_applied = $row["late_charges_applied"];
						$principal_applied = $row["principal_applied"];
						$impound_applied = $row["impound_applied"];
					}
					date_default_timezone_set('America/Los_Angeles');
					$today = date("Y-n-j");
					$number_of_days = floor((strtotime($today)-strtotime($_SESSION["date_paid"]))/(60*60*24));
					$interest_accrued = ($_SESSION["interest_rate"]/365)*$number_of_days*$_SESSION["principal_balance"];
				}
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
	<title>HDF - Gathering Credit Payment Info</title>

	<script type="text/javascript" src="../../js/jquery-1.8.3.js"></script>
	<script type="text/javascript" src="../../js/jquery.validate.min.js"></script>
	<script type="text/javascript">
		$(function(){
			$("#form").validate({
				rules:{
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
					impound_applied:{
						number: true
					},

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
				<h2>Gathering Credit Payment Info:</h2>
			</div>

			<div id="content">
				<form id="form" name="get_info" action="./make_credit_payment.php" method="post">
					<p>
						Loan #: <?= $_SESSION["loan_id"] ?>
					</p>
					<p>
						Name: <?= $_SESSION["last_name"] . " " . $_SESSION["suffix"] . " , " . $_SESSION["first_name"] ?>
					</p>
					<p>
						Principal Balance: $<?= $_SESSION["principal_balance"] ?>
					</p>
					<p>
						Impound Balance: $<?= $_SESSION["impound_balance"] ?>
					</p>
					<p>
						Interest Accrued as of (<?= $today ?>): $<?= round($interest_accrued,2) ?>
					</p>
					<p>
						<label for="date_paid">* Date Paid (yyyy-mm-dd):</label><br>
						<input id="date_paid" type="text" name="date_paid" value="<?= $_SESSION["date_paid"] ?>">
					</p>
					<p>
						<label for="date_paid_to">Paid To (yyyy-mm-dd):</label><br>
						<input id="date_paid_to" type="text" name="date_paid_to" value="<?= $date_paid_to ?>">
					</p>
					<p>
						<label for="cash_recieved">* Cash Received:</label><br>
						$<input id="cash_recieved" size="19" type="text" name="cash_recieved" value="<?= $cash_recieved ?>">
					</p>
					<p>
						<label for="late_charges_applied">Late Charges:</label><br>
						$<input id="late_charges_applied" size="19" type="text" name="late_charges_applied" value="<?= $late_charges_applied ?>">
					</p>
					<p>
						<label for="impound_applied">Impound to Apply:</label><br>
						$<input id="impound_applied" size="19" type="text" name="impound_applied" value="<?= $impound_applied ?>">
					</p>
					<input id="submit" type="submit" name="got_info" value="Submit Credit Payment">
				</form>
			</div>
		</div>
	</div>
</body>
</html>