<?php
  returnWithInfo( $searchResults );

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

  function returnWithInfo( $results )
  {
    $retValue = '{"results":' . $results . '}';
    sendResultInfoAsJson( $retValue );
  }
?>
