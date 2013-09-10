<?php
	session_start();
	
	if(isset($_SESSION["authenticated"])) {
		require "../../include.php";
		if(($connection = mysql_connect(HOST, USER, PASS)) === FALSE)
            die("Could not connect to database");
        if(mysql_select_db(DB, $connection) === FALSE)
            die("Could not select database");

        $sql = "SELECT * FROM users";
		$result = mysql_query($sql);
		if ($result == FALSE) {
			die("Could Not Query Database");
		}
		else{
			$success = TRUE;
		}
	
	}
	else
		header("Location: ../");
?>

<!DOCTYPE html>
<html>

<head>
	<meta charset="UTF-8">
	<link rel="stylesheet" type="text/css" href="../../css/style.css">
	<title>HDF - Select Employee</title>
</head>

<body>
	<header id="banner">
		<h1>Hoopa Development Fund Management</h1>
	</header>

	<div id="container">
		<aside id="side">
			<nav>
				<ul>
					<li><a href="../../home.php">Home</a></li>
					<li><a href="../myaccount.php">My Account</a></li>
					<li><a href="../../logout.php">Log Out</a></li>
					<hr>
					<li><a href="../../add_borrower/">Add Borrower</a></li>
					<hr>
					<li><a href="../../credit_division/edit_credit_borrower/">Edit Credit Borrower</a></li>
					<li><a href="../../credit_division/credit_payment/">Credit Payment</a></li>
					<li><a href="../../credit_division/view_credit_borrower/">View Credit Borrower</a></li>
					<hr>
					<li><a href="../../eda_division/edit_eda_borrower/">Edit EDA Borrower</a></li>
					<li><a href="../../eda_division/eda_payment/">EDA Paymnet</a></li>
					<li><a href="../../eda_division/view_eda_borrower/">View EDA Borrower</a></li>
					<?php if ($_SESSION["privileges"] == 2): ?>
					<hr>
					<li><a href="../add_employee/">Add Employee</a></li>
					<li><a href="../edit_employee/">Edit Employee</a></li>
					<li><a href="../view_employees/">View Employees</a></li>
					<hr>
					<li><a href="../../credit_division/view_credit_edit_log/">View Credit Edit Log</a></li>
					<li><a href="../../eda_division/view_eda_edit_log/">View EDA Edit Log</a></li>
					<?php endif; ?>
				</ul>
			</nav>
			<hr><hr>
			<p>Developed by <a href="http://www.speygee.com">Speygee</a></p>
		</aside>
		
		<article id="content_wrapper">
			<header id="title">
				<h2>Select Employee:</h2>
			</header>

			<section id="content">
				<?php
					if (isset($_SESSION["blank_error"])) {
						if ($_SESSION["blank_error"] == TRUE) {
							print("<p style='color:red;'>Please Select an Employee!</p>");
						}
						$_SESSION["blank_error"] = FALSE;
					}
				?>
				<?php if (mysql_num_rows($result)): ?>
					<form id="selection" name="select_employee" action="./get_info.php" method="post">
						<?php
							$count = 0;
							while($row = mysql_fetch_array($result)){
								echo "<input type='radio' name='employee' id='$row[username]' value='$row[username]'><label for='$row[username]'> $row[username] | $row[last_name], $row[first_name]</label><br>";
								$count++;
								if($count == 15){
									echo "<input type='submit' name='selected_employee' value='Continue'/><br>";
									$count = 0;
								}
							}
						?>
						<input type='submit' name="selected_employee" value='Continue'/><br>
					</form>
				<?php  else: ?>
					<div id="message">
						<p id="selection">No Employees at this time.<br>Do you want to <a href="../add_employee">add</a> a employee?</p>
					</div>
					
				<?php endif; ?>
			</section>
		</article>
	</div>
</body>
</html>