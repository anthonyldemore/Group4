<?php

	//$inData = getRequestInfo();

	$searchResults = "";
	$email = "";

	$conn = new mysqli("localhost", "group4cp_admin", "!@Pass4U@!", "group4cp_corporate");
	if ($conn->connect_error)
	{
		returnWithError( $conn->connect_error );
	}
	else
	{
		//$sql = "select Name from CONTACTS where ContactName like '%" . $inData["search"] . "%' and UserID=" . $inData["ID"];
		$sql = "select * from CONTACTS where ContactName like 'John Smith'";	// testing to see if database can be searched
		$result = $conn->query($sql);
		if ($result->num_rows > 0)
		{
			$row = $result->fetch_assoc();

			$searchResults = $row["ContactName"];
			$email = $row["Email"];

			echo $searchResults;
			echo "<br>";
			echo $email;
		}
		else
		{
			returnWithError( "No Records Found" );
		}
		//$conn->close();
	}

	/*returnWithInfo( $searchResults );

	function getRequestInfo()
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
		$retValue = '{"id":0,"Username":"","PerferredName":"","error":"' . $err . '"}';
		sendResultInfoAsJson( $retValue );
	}

	function returnWithInfo( $searchResults )
	{
		$retValue = '{"results":[' . $searchResults . '],"error":""}';
		sendResultInfoAsJson( $retValue );
	}*/

?>
