<?php

	//$inData = getRequestInfo();

	$Username = 0;
	$Password = "";
	$PreferredName = "";

	$conn = new mysqli("localhost", "group4cp_admin", "!@Pass4U@!", "group4cp_corporate");
	if ($conn->connect_error)
	{
		returnWithError( $conn->connect_error );
	}
	else
	{
		// $sql = "SELECT Username,PreferredName FROM Users where Login='" . $inData["login"] . "' and Password='" . $inData["password"] . "'";
		$sql = "select * FROM USERS";
		$result = $conn->query($sql);
		if ($result->num_rows > 0)
		{
			$row = $result->fetch_assoc();
			$Username = $row["Username"];
			$Password = $row["Password"];
			$PreferredName = $row["PreferredName"];

			// Only used to confirm database connection works
			echo $Username;
			echo "<br>";
			echo $Password;
			echo "<br>";
			echo $PreferredName;

			//returnWithInfo($PreferredName, $Username);
		}
		else
		{
			returnWithError( "No Records Found" );
		}
		//$conn->close();
	}

	/*function getRequestInfo()
	{
		return json_decode(file_get_contents('php://input'), true);
	}

	function sendResultInfoAsJson( $obj )
	{
		header('Content-type: application/json');
		echo $obj;
	}

	function returnWithError( $err )
	{
		$retValue = '{"Username":0,"PreferredName":"","error":"' . $err . '"}';
		sendResultInfoAsJson( $retValue );
	}

	function returnWithInfo( $PreferredName, $Username )
	{
		$retValue = '{"id":' . $Username . ',"firstName":"' . $PreferredName . '","lastName":"' . $lastName . '","error":""}';
		sendResultInfoAsJson( $retValue );
	}*/

?>