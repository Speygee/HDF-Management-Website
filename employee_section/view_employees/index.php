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
			
				<table border="1">
					<tr>
						<th>Username</th>
						<th>First Name</th>
						<th>Last Name</th>
					</tr>
				<?php while($row = mysql_fetch_array($result)): ?>
					<tr>
						<td><?= $row["username"] ?></td>
						<td><?= $row["first_name"] ?></td>
						<td><?= $row["last_name"] ?></td>
					</tr>
				<?php endwhile; ?>
				</table>		
			
			</section>
		</article>
	</div>
</body>
</html>