<?php
	include 'common.php';

	$inData = getRequestInfo();
	$idArr = $inData["idArr"];

	$conn = new mysqli("localhost", "group4cp_admin", "!@Pass4U@!", "group4cp_corporate");
	if ($conn->connect_error)
	{
		returnWithError( $conn->connect_error );
	}
	else
	{
		if (is_array($idArr))
		{
			if (count($idArr) > 0)
			{
				//$sql = "delete from CONTACTS where ContactName like '%'"; . $inData["search"] . "%' and UserID=" . $inData["ID"];
				$sql = "DELETE FROM `CONTACTS`" . " WHERE `ID` IN (";;
				foreach ($idArr as $id)
				{
					$sql = $sql . $id . ", ";
				}
				$sql = substr_replace($sql, ")", -2); //Replaces the final ", " with and end parenthesis to close the "IN" list.

				if ($result = $conn->query($sql) == TRUE)
					returnWithInfo('"' . count($idArr) . ' record(s) removed."');
				else
		  		returnWithError($conn->$error);
			}
			else
			{
				returnWithError("No contacts to delete.");
			}
		}
		else
		{
			returnWithError("Expected array of IDs. Passed value: " . $idArr);
		}

		$conn->close();
	}

?>
