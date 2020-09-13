<?php
	include 'common.php';

	$inData = getRequestInfo();

	$SearchedName = $inData["search"];

	$searchResults = "";
	$email = "";

	$conn = new mysqli("localhost", "group4cp_admin", "!@Pass4U@!", "group4cp_corporate");
	if ($conn->connect_error)
	{
		returnWithError( $conn->connect_error );
	}
	else
	{
		$sql = "select * from CONTACTS where ContactName like '%'" . $inData["search"] . "%' and UserID=" . $inData["ID"];
		if ($result->num_rows > 0)
		{
			$row = $result->fetch_assoc();

			while($row = $result->fetch_assoc())
			{
				if( $searchCount > 0 )
				{
					$searchResults .= ",";
				}
				$searchCount++;
				$searchResults .= '"' . $row["ContactName"] . '"';
			}

			returnWithInfo(json_encode($searchResults));
		}
		else
		{
			returnWithError( "No Records Found" );
		}
		$conn->close();
	}
?>
