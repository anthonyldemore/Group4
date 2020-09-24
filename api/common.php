<?php
  header("Access-Control-Allow-Origin: *");

  $key = 'poop';

  function getRequestInfo()
  {
    return json_decode(file_get_contents('php://input'), true);
  }

  function sendResultInfoAsJson( $obj )
  {
    header('Content-type: application/json');
    echo $obj;
  }

  function returnWithError( $err )
  {
    $retValue = '{"error":"' . $err . '"}';
    sendResultInfoAsJson( $retValue );
  }

  function returnWithInfo( $resultJSON )
  {
    $retValue = '{"results":' . $resultJSON . '}';
    sendResultInfoAsJson( $retValue );
  }
?>
