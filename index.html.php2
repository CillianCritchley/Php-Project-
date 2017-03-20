<?php
session_start();
if(!isset($_SESSION['userloggedin']))
{
    $_SESSION['count'] =0;
    header('location: login.php');
}
else{
    unset($_SESSION['count']);
}?>
<!--
The main menu page for our project (The Bank System)
Craig Lawlor, Craig Doyle, Cillian o Criothaile (c00139896), Helmuts Dunavskis (C00208483)

-->

<!DOCTYPE HTML>
<html>
	<head>

		<title>HCCC Bank</title>
		<meta charset="utf-8" />
		<meta name="viewport" content="initial-scale = 1">
		<link rel="stylesheet" href="style.css" />

        <script type="text/javascript" src="myScript.js"></script>
	</head>
	<body>
		<!--The header will hold the logo-->
		<div class="header">
			<center><img src="logo2.png"  height="80" width="170"></center>
		</div>
		<!--This side bar has clickable dropdowns with further options-->
			<div class="sidebar">
			<br><br><br>	
			<a href="Welcome.html" target="contentframe" class="dropbut">Home</a>
			<div  class="dropLink">
				<a href="javascript: toggle1()" id="test" class="dropbut">Parent 1</a>
				<div id="link1" class="dropdownSide">
					<a href="../OpenDeposit.html.php" target="contentframe" id="puece" onclick="testfunction(this.id)" class="linkbut"  > Open Deposit</a>
					<a href="../CloseDeposit.html.php" target="contentframe" class="linkbut" > Close Deposit Account</a>
					<a href="../ViewDeposit.html.php" target="contentframe" class="linkbut" >View Deposit</a>
					<a href="../DepositReport.html.php" target="contentframe" class="linkbut" >Report</a>
				</div>
				<a href="javascript: toggle2()" class="dropbut">Parent 2</a>
				<div id="link2" class="dropdownSide">
					<a href="" target="contentframe">Amend/View?</a>
					<a href="" target="contentframe">More amend view?</a>
					<a href="#">Child 3</a>
					<a href="#">Child 4</a>
				</div>
				<a href="javascript: toggle3()" class="dropbut">Parent 3</a>
				<div id="link3" class="dropdownSide">
					<a href="#">Child 1</a>
					<a href="#">Child 2</a>
					<a href="#">Child 3</a>
					<a href="#">Child 4</a>
				</div>
				<a href="javascript: toggle4()" class="dropbut">Parent 4</a>
				<div id="link4" class="dropdownSide">
					<a href="#">Child 1</a>
					<a href="#">Child 2</a>
					<a href="#">Child 3</a>
					<a href="#">Child 4</a>
				</div>
			</div>
		</div>
		<div class="content">
 			<iframe  id="contentframe" name="contentframe" src="Welcome.html"> </iframe>
		</div>
		<!--<div class="footer">
			
		</div>-->
	</body>
</html>

