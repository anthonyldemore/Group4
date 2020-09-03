<?php

	//$inData = getRequestInfo();

	$conn = new mysqli("localhost", "group4cp_admin", "!@Pass4U@!", "group4cp_corporate");
	if ($conn->connect_error)
	{
		returnWithError( $conn->connect_error );
	}
	else
	{
		//$sql = "delete from CONTACTS where ContactName like '%'"; . $inData["search"] . "%' and UserID=" . $inData["ID"];
		$sql = "delete from CONTACTS where ContactName = 'delete me'";	// test delete

		if ($conn->query($sql) === TRUE)
  			echo "Record deleted successfully";
		else
  			echo "Error deleting record: " . $conn->error;

		$conn->close();
	}

?>
