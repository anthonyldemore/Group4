<?php
  header("Access-Control-Allow-Origin: *");

  $key = 'poop';

  function getRequestInfo()
  {
    $inData = json_decode(file_get_contents('php://input'), true);

    //Need to pad every apostrophe with 2 backslashes, as SQL sees them as the beginning and/or end of strings. This will cause syntax errors due to bad strings.
    //One backslash is needed to write the other backslash into the php string, which will then write the apostrophe into the SQL string.
    $keys = array_keys($inData);
    foreach ($keys as $key)
    {
      if (is_string($inData[$key]))
      {
        $quotepos = strpos($inData[$key], "'");
        while ($quotepos !== false)
        {
          $inData[$key] = substr_replace($inData[$key], "\\", $quotepos, 0); //Inserts a backslash literal before the single quote.
          $quotepos = strpos($inData[$key], "'", $quotepos+2);
        }
      }
    }

    return $inData;
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
