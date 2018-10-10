<?php
	header('Content-type: application/json');
	require "settings.php";
	if ($_SERVER['REQUEST_METHOD']=="GET")
	{
		$ret["count"]=$problem_count;
		for ($i=0;$i<$problem_count;$i++)
			$ret["problem_".strval($i+1)]=urlencode($problem[$i]);
		echo urldecode(json_encode($ret));
		return ;
	}
	if ($_SERVER['REQUEST_METHOD']=="POST")
	{
		if ($_POST["count"]!=strval($problem_count))
		{
			echo json_encode(array("status"=>0,"result"=>"Parameters Wrong"));
			return ;
		}
		for ($i=0;$i<$problem_count;$i++)
		{
			if (!isset($_POST["answer_".strval($i+1)]))
			{
				echo json_encode(array("status"=>0,"result"=>"Parameters Wrong"));
				return ;
			}
			if ($_POST["answer_".strval($i+1)]!=$correct_answers[$i])
			{
				echo json_encode(array("status"=>0,"result"=>"Answer Wrong"));
				return ;
			}
		}
		if (! ( isset($_POST["Text"]) && isset($_POST["Passwd"]) && isset($_POST["Security"]) && isset($_POST["Length"]) && isset($_POST["Type"]) ) )
		{
			echo json_encode(array("status"=>0,"result"=>"Parameters Wrong"));
			return ;
		}
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
		echo json_encode(array("status"=>"0","result"=>str_replace("\n",'',shell_exec($cmd))));
		return ;
	}
?>