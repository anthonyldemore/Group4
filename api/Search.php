<?php
	include 'common.php';

	$inData = getRequestInfo();

	$search = $inData["search"];
	$userId = $inData["userId"];
	$resultArr = array();

	$conn = new mysqli("localhost", "group4cp_admin", "!@Pass4U@!", "group4cp_corporate");
	if ($conn->connect_error)
	{
		returnWithError( $conn->connect_error );
	}
	else
	{
		$sql = "SELECT * FROM CONTACTS WHERE ContactName LIKE '%" . $search . "%' and userID = " . $userId;
		$result = $conn->query($sql);
		if ($result->num_rows > 0)
		{
			while($row = $result->fetch_assoc())
			{
				$resultArr[] = array(
					"ID" => $row["ID"],
					"ContactName" => $row["ContactName"],
					"CompanyName" => $row["CompanyName"],
					"Address" => $row["Address"],
					"Email" => $row["Email"],
					"Phone" => $row["Phone"]
				);
			}

			returnWithInfo(json_encode($resultArr));
		}
		else
		{
			//returnWithError( "No Records Found" );
			/*$resultArr[] = array(
			);*/

			returnWithInfo(json_encode($resultArr));
		}
		$conn->close();
	}
?>
