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
      $sql = "insert into CONTACTS (UserId, ContactName, CompanyName, Address, Email, Phone) "
      . "VALUES (" . $userId . ",'" . $contactName . "','" . $companyName . "','" . $address
      . "','" . $email . "','" . $phone . "')";

      if ($result = $conn->query($sql) != TRUE)
      {
          returnWithError($conn->error);
      }

      $conn->close();
  }
?>
