<?php
    include 'common.php';

    $inData = getRequestInfo();

    // In our data, we need the following information
    $userId = $inData["userId"];
    $contactId = $inData["contactId"];
    $contactName = $inData["contactName"];
    $companyName = $inData["companyName"];
    $address = $inData["address"];
    $email = $inData["email"];
    $phone = $inData["phone"];

    if (is_null($userId)
      || is_null($contactId)
      || isEmptyString($contactName)
      || isEmptyString($companyName)
      || isEmptyString($address)
      || isEmptyString($email)
      || isEmptyString($phone))
        returnWithInsufficientArguments();
    else
    {
      $conn = new mysqli("localhost", "group4cp_admin", "!@Pass4U@!", "group4cp_corporate");

      if ($conn->connect_error)
      {
          returnWithError($conn->connect_error);
      }
      else
      {
          //Check if contact exists first.
          $sql = "SELECT * FROM `CONTACTS`"
            . " WHERE `UserID` = " . $userId
            . " AND `ID` = " . $contactId;
          $result = $conn->query($sql);
          if ($result->num_rows > 0)
          {
            // Insert Values
            $sql = "UPDATE `CONTACTS` "
                    . "SET ContactName = '" . $contactName . "',"
                    . "CompanyName = '" . $companyName . "',"
                    . "Address = '" . $address . "',"
                    . "Email = '" . $email . "',"
                    . "Phone = '" . $phone . "' "
                    . "WHERE UserID = " . $userId . " AND ID = " . $contactId;


            if ($result = $conn->query($sql) != TRUE)
            {
                returnWithError($conn->error);
            }
            else
            {

                $responseArr = array(
                    "ContactName" => $contactName,
                    "CompanyName" => $companyName,
                    "Address" => $address,
                    "Email" => $email,
                    "Phone" => $phone,
                    "Message" => "Contact " . $contactId . " (" . $contactName . ") has been updated
                    successfully."
                );

                returnWithInfo(json_encode($responseArr));
            }
          }
          else
          {
            returnWithError("No records found");
          }

          $conn->close();
      }
    }
?>
