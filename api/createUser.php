<?php
  include 'dataFetch.php';

  $inData = getRequestInfo();

  // We need the following info
  $username = $inData["username"];
  $password = $inData["password"];
  $name = $inData["name"];
  $companyName = $inData["companyName"];
  $position = $inData["position"];
  $address = $inData["address"];
  $email = $inData["email"];
  $phone = $inData["phone"];

  // Encrypt password
  $key - 'poop';
  $encryptedPassword = "AES_ENCRYPT(" . $password . ", UNHEX(SHA2('" . $key . "', 256)))";


  // Establish connection
  $conn = new mysqli("localhost", "group4cp_admin", "!@Pass4U@!", "group4cp_corporate");

  // Test connection
  if ($conn->connect_error)
  {
      returnWithError($conn->connect_error);
  }
  else
  {
      // Our SQL command.
      $sql = "insert into USERS (Username, Password, PreferredName, CompanyName, Position, Address,"
      . "Email, Phone) VALUES (
          '" . $username . "',
          " . $encryptedPassword . ",
          '" . $name . "',
          '" . $companyName . "',
          '" . $position . "',
          '" . $address . "',
          '" . $email . "',
          '" . $phone . "')";

      // Check if our query is successful or not
      if ($result = $conn->query($sql) != TRUE)
      {
          returnWithError($conn->error);
      }

      $conn->close();
  }
?>
