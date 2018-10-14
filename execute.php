<?php
	session_start();
	include "settings.php";
	if ($_SESSION["level"] != $problem_count)
		die("You have not finish the problem yet");

	if (hash_equals($_POST["token_calc"] , hash_hmac('sha256', '/calc.php', $_SESSION["token_calc"]))===false)
		die("Cross-site Request Forgery Detected");

	$arg[0]=$_POST["Text"];
	$arg[1]=$_POST["Passwd"];
	$arg[2]=$_POST["Security"];
	$arg[3]=$_POST["Length"];
	$arg[4]=$_POST["Type"];
	$cmd="/usr/bin/passwdg ";
	for ($i = 0; $i < 5; $i ++)
	{
		$arg[$i]=str_replace("'","'\"'\"'",$arg[$i]);
		$arg[$i]="'".$arg[$i]."'";
		$cmd=$cmd." ".$arg[$i];
	}
	echo shell_exec($cmd);
?>