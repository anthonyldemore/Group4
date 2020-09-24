<?php
  include 'common.php';

  $inData = getRequestInfo();

  // We need the following info
  $username = $inData["username"];
  $password = $inData["password"];
  $name = $inData["name"];
  $email = $inData["email"];

  // Encrypt password
  $encryptedPassword = "AES_ENCRYPT('" . $password . "', UNHEX(SHA2('" . $key . "', 256)))";


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
      $sql = "INSERT INTO `USERS` (`Username`, `Password`, `PreferredName`, `Email`)"
      . "VALUES (
          '" . $username . "',
          " . $encryptedPassword . ",
          '" . $name . "',
          '" . $email . "')";

      // Check if our query is successful or not
      if ($result = $conn->query($sql) != TRUE)
      {
          returnWithError($conn->error);
      }

      else
      {
          // Verify that the inserted data exists in the database.
          $sql = "SELECT * FROM `USERS`"
              . "WHERE `Username` = '" . $username . "';";
          $result = $conn->query($sql);
          if ($result->num_rows > 0) {
              $row = $result->fetch_assoc();

              $returnArr = array(
                "ID" => $row["ID"],
                "Username" => $row["Username"],
                "CreatedDate" => $row["CreatedDate"],
                "Message:" => "User $username has been created."
              );

              returnWithInfo(json_encode($returnArr));
          }
          else
          {
              returnWithError("An unknown error has occurred when creating user.");
          }
      }

      $conn->close();
  }
?>
