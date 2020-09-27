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
				//Convert an array of IDs into a SQL query friendly string.
				$idWhere = "(";
				foreach ($idArr as $id)
				{
					$idWhere = $idWhere . $id . ", ";
				}
				$idWhere = substr_replace($idWhere, ")", -2); //Replaces the final ", " with and end parenthesis to close the "IN" list.

				//Check number of existing records first.
				$sql = "SELECT `ID` FROM `CONTACTS`" .
					"WHERE `ID` IN " . $idWhere;
				$result = $conn->query($sql);
				$foundIDs = array();
				if ($result->num_rows > 0)
				{
						while($row = $result->fetch_assoc())
						{
								array_push($foundIDs, $row["ID"]);
						}
				}

				//$sql = "delete from CONTACTS where ContactName like '%'"; . $inData["search"] . "%' and UserID=" . $inData["ID"];
				$sql = "DELETE FROM `CONTACTS`" .
					" WHERE `ID` IN " . $idWhere;

				if ($result = $conn->query($sql) == TRUE)
				{
						$returnArr = array(
							"RemovedIDs" => $foundIDs,
							"Message" => count($idArr) . " record(s) removed."
						);
						returnWithInfo(json_encode($returnArr));
				}
				else
		  			returnWithError($conn->error);
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
