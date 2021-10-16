<?php
// SavingPet_Member.php otaco 2021.04.21

$host = "my8002.gabiadb.com";	// DB Host
$user = "otacoadmin";	// DB User
$pw = "sool1130sool";
$db = "otacosystemdb"; // DB Name

$con = mysqli_connect($host,$user,$pw) or die(mysqli_error());
mysqli_select_db($con,$db) or die(mysqli_error());
mysqli_query($con,"SET CHARACTER SET utf8");
mysqli_query($con,"SET NAMES 'utf8'");

date_default_timezone_set('Asia/Seoul');
$now = new DateTime();
$datenow = $now->format("Y-m-d H:i:s");

$action = $_POST["action"];

//~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
switch ($action)
{
	case "insertMember":
	{
		try{
			$tableName = $_POST["tableName"];
			$email = $_POST["email"];
			$name = $_POST["name"];
			//$phone = $_POST["phone"];
			//$family = $_POST["family"];
			//$age = $_POST["age"];
			//$sex = $_POST["sex"];
			//$weight = $_POST["weight"];
			//$address = $_POST["address"];

			mysqli_autocommit($con, FALSE);

			$result= mysqli_begin_transaction($con, MYSQLI_TRANS_START_READ_WRITE);

			//$q = "INSERT INTO $tableName (email, name, phone, family, age, sex, weight, address) VALUES ('$email','$name','$phone','$family','$age','$sex','$weight','$address')";
			$q = "INSERT INTO $tableName (email, name) VALUES ('$email','$name')";
			$result = mysqli_query($con,$q);

			$result = mysqli_commit($con);
			if ($result) {
				print json_encode("insertMember");
			}
			else {
				print json_encode("false");
			}
		}
		catch(Exception $e)
		{
			$s = $e->postMessage() . ' (오류코드:' . $e->postCode() . ')';
			echo $s;

			mysqli_rollback($con);
			print json_encode("false");
		}
	}
	break;

	case "deleteMember":
	{
		try{
			$tableName = $_POST["tableName"];
			$email = $_POST["email"];

			mysqli_autocommit($con, FALSE);

			$result= mysqli_begin_transaction($con, MYSQLI_TRANS_START_READ_WRITE);

			$q = mysqli_query($con,"DELETE FROM $tableName WHERE email = '$email'");
			$result = mysqli_query($con,$q);

			$result = mysqli_commit($con);
			if ($result) {
				print json_encode("deleteMember");
			}
			else {
				print json_encode("false");
			}
		}
		catch(Exception $e)
		{
			$s = $e->postMessage() . ' (오류코드:' . $e->postCode() . ')';
			echo $s;

			mysqli_rollback($con);
			print json_encode("false");
		}
	}
	break;

	case "updateMember":
	{
		try{
			$tableName = $_POST["tableName"];
			$email = $_POST["email"];
			$phone = $_POST["phone"];
			$family = $_POST["family"];
			$age = $_POST["age"];
			$sex = $_POST["sex"];
			$weight = $_POST["weight"];
			$address = $_POST["address"];

			mysqli_autocommit($con, FALSE);

			$result = mysqli_begin_transaction($con, MYSQLI_TRANS_START_READ_WRITE);

			$q = "UPDATE $tableName SET	phone = '$phone', family = '$family', age = '$age', sex = '$sex', weight = '$weight', address = '$address' WHERE email = '$email'";
			$result = mysqli_query($con,$q);

			$result = mysqli_commit($con);
			if ($result) {
				print json_encode("updateMember");
			}
			else {
				print json_encode("false");
			}
		}
		catch(Exception $e)
		{
			$s = $e->postMessage() . ' (오류코드:' . $e->postCode() . ')';
			echo $s;

			mysqli_rollback($con);
			print json_encode("false");
		}
	}
	break;

	case "updateMemberPoint":
	{
		try{
			$tableName = $_POST["tableName"];
			$email = $_POST["email"];
			$memberPoint = $_POST["memberPoint"];

			mysqli_autocommit($con, FALSE);

			$result = mysqli_begin_transaction($con, MYSQLI_TRANS_START_READ_WRITE);

			$q = "UPDATE $tableName SET	memberPoint = '$memberPoint' WHERE email = '$email'";
			$result = mysqli_query($con,$q);

			$result = mysqli_commit($con);
			if ($result) {
				print json_encode("updateMemberPoint");
			}
			else {
				print json_encode("false");
			}
		}
		catch(Exception $e)
		{
			$s = $e->postMessage() . ' (오류코드:' . $e->postCode() . ')';
			echo $s;

			mysqli_rollback($con);
			print json_encode("false");
		}
	}
	break;

	case "selectMember":
	{
		try{
			$tableName = $_POST["tableName"];
			$email = $_POST["email"];

			$q = mysqli_query($con,"SELECT * FROM $tableName WHERE email = '$email'");
			$rows = array();
			while($r = mysqli_fetch_assoc($q))
			{
				$rows[] = $r;
			}
			print json_encode($rows,JSON_UNESCAPED_UNICODE);
		}
		catch(Exception $e)
		{
			$s = $e->postMessage() . ' (오류코드:' . $e->postCode() . ')';
			echo $s;

			print json_encode("false");
		}
	}
	break;

} //switch

mysqli_close($con);
?>
