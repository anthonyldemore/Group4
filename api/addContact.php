<?php
  include 'common.php';

  $inData = getRequestInfo();

  // In our data, we need the following information
  $userId = $inData["userId"];
  $contactName = $inData["contactName"];
  $companyName = $inData["companyName"];
  $address = $inData["address"];
  $email = $inData["email"];
  $phone = $inData["phone"];

  if (is_null($userId)
    || isEmptyString($contactName)
    || isEmptyString($companyName)
    || isEmptyString($address)
    || isEmptyString($email)
    || isEmptyString($phone))
      returnWithInsufficientArguments();
  else
  {
    // Establish connection
    $conn = new mysqli("localhost", "group4cp_admin", "!@Pass4U@!", "group4cp_corporate");

    // Test connection
    if ($conn->connect_error)
    {
        returnWithError($conn->connect_error);
    }
    else
    {
        // Insert necessary values.
        $sql = "INSERT INTO `CONTACTS` (`UserId`, `ContactName`, `CompanyName`, `Address`, `Email`, `Phone`) "
        . "VALUES (" . $userId . ",'" . $contactName . "','" . $companyName . "','" . $address
        . "','" . $email . "','" . $phone . "')";

        if ($result = $conn->query($sql) != TRUE)
        {
            returnWithError($conn->error);
        }
        else
        {
            //Verify that the contact has been inserted.
            $sql = "SELECT * FROM `CONTACTS`" .
                "WHERE `UserID` = " . $userId . " ORDER BY `ID` DESC LIMIT 1";
            $result = $conn->query($sql);
            if ($result->num_rows > 0)
            {
                $row = $result->fetch_assoc();

                $returnArr = array(
                  "ID" => $row["ID"],
                  "ContactName" => $row["ContactName"],
                  "Message" => "Contact $contactName has been added."
                );

                returnWithInfo(json_encode($returnArr));
            }
            else
            {
                returnWithError("An unknown error has occurred when inserting contact info.");
            }
        }

        $conn->close();
    }
  }
?>
