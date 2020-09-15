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

    $conn = new mysqli("localhost", "group4cp_admin", "!@Pass4U@!", "group4cp_corporate");

    if ($conn->connect_error)
    {
        returnWithError($conn->connect_error);
    }
    else
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
        $conn->close();
    }
?>