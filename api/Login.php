<?php
	include 'common.php';

	$inData = getRequestInfo();

	$Username = $inData["username"];
	$Password = $inData["password"];

	$conn = new mysqli("localhost", "group4cp_admin", "!@Pass4U@!", "group4cp_corporate");
	if ($conn->connect_error)
	{
		returnWithError( $conn->connect_error );
	}
	else
	{
		// $sql = "SELECT ID,PreferredName FROM Users where Login='" . $inData["login"] . "' and Password='" . $inData["password"] . "'";
		$sql = "SELECT * FROM `USERS`"
			. "WHERE `Username` = '" . $Username . "' AND `PASSWORD` = AES_ENCRYPT('" . $Password . "', UNHEX(SHA2('" . $key . "', 256)));";
		$result = $conn->query($sql);

		//Check if results are found.
		if ($result->num_rows > 0)
		{
			$row = $result->fetch_assoc();

			$resultArr = array(
				"ID" => $row["ID"],
				"Username" => $row["Username"],
				"Name" => $row["PreferredName"],
				"Prev Login Date" => $row["LastLoginDate"],
				"Message" => "User $Username has logged in."
			);

			//Update Last Login Date.
			$sql = "UPDATE `USERS` SET `LastLoginDate` = CURRENT_TIMESTAMP()"
			.	"WHERE `Username` = '" . $row["Username"] . "';";
			$result = $conn->query($sql);

			returnWithInfo(json_encode($resultArr));

			// // Only used to confirm database connection works
			// echo $Username;
			// echo "<br>";
			// echo $Password;
			// echo "<br>";
			// echo $Id;

			//returnWithInfo($ID, $Username);
		}
		else
		{
			returnWithError( "Invalid username or password." );
		}
		$conn->close();
	}
?>
