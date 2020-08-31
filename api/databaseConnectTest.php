<?php

    $conn = new mysqli("localhost", "group4cp_admin", "!@Pass4U@!", "group4cp_corporate");

    if ($conn -> connect_error)
        returnwithError($conn -> connect_error);
    else
        echo "DB Connected";

?>
