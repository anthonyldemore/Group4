<?php

    $conn = new mysqli("localhost", "group4cp_admin", "!@Pass4U@!", "group4cp_corporate");
    $response = array();

    if ($conn -> connect_error)
        returnwithError($conn -> connect_error);
    else
    {
        $sql = "select * from USERS";
        $result = mysqli_query($conn,$sql);
        if ($result -> num_rows > 0)
        {
            $i = 0;
            $key = "poop";
            while ($row = mysqli_fetch_assoc($result))
            {
                $response[$i]['Username'] = $row['Username'];
                $i++;
            }

            echo json_encode($response, JSON_PRETTY_PRINT);
        }
    }

?>
