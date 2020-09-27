<?php
  $key = 'poop';

  // header("Access-Control-Allow-Origin: *"); 
  // header("Content-Type: application/json; charset=UTF-8"); 
  // header("Access-Control-Allow-Methods: OPTIONS,GET,POST,PUT,DELETE"); 
  // header("Access-Control-Max-Age: 3600");
  // header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With"); 

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
