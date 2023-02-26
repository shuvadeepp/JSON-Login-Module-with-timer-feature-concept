<?php

session_start();
    /* ::::::::::: This Function to get array search inner key :::::::::::: */
    function array_search_inner ($array, $attr, $val, $strict = FALSE) {
        //echo '<pre>';print_r($array);exit;
        // Error is input array is not an array
        if (!is_array($array)) return FALSE;
        // Loop the array
        foreach ($array as $key => $inner) {
        // Error if inner item is not an array (you may want to remove this line)
            if (!is_array($inner)) return FALSE;
            // Skip entries where search key is not present
            if (!isset($inner[$attr])) continue;
            if ($strict) {
                // Strict typing
                if ($inner[$attr] === $val) return $key;
            } else {
                // Loose typing
                if ($inner[$attr] == $val) return $key;
            }
        }
        // We didn't find it
        return NULL;
    }

    if (isset($_POST['setTime'])) {
        
        $setTime    = $_POST['setTime'];
        $EnterNum   = $_POST['EnterNum'];

        // echo $setTime . ' -- ' . $EnterNum;exit;

        $newdata    = array();
        $arrData    = array(
            "UserName"          => $_SESSION['userName'],
            "MobileNumber"      => $EnterNum,
            "Time"              => $setTime
        );
        
        $get_file           = json_decode(file_get_contents('loginDetails.json'),true);
        $get_ParentKey      = array_search_inner($get_file, 'UserName', $_SESSION['userName']); 
        $yourBalace         = $get_file[$get_ParentKey]['Balance'];
        // echo "<pre>";print_r($get_file[$get_ParentKey]['UserName'] . '--' . $_SESSION['userName']);exit;
        
        /* ::::: Calculate timer & check Balance ::::: */
        $setTime = ceil($setTime / 60);

        if ($get_ParentKey !== null) {
            $time_diff = $yourBalace - $setTime;
            if ($yourBalace > 0) {
                $get_file[$get_ParentKey]['Balance'] = $time_diff;
                file_put_contents('loginDetails.json', json_encode($get_file));
                $response = array('status' => '200');
            } else {
                $response = array('status' => '404', 'message' => 'You dont have balance!!!');
            }  
        }

        /* ::::: Insert In another json file to store time & number number ::::: */
        $recordDetailsFile    = 'recordDetails.json';
        $getRecordFile        = file_get_contents($recordDetailsFile);
        $decodeRecordFile     = json_decode($getRecordFile, TRUE);
        // echo'<pre>';print_r($decodeRecordFile);exit;
        // echo'<pre>';print_r($arrData);exit;
        // 
        array_push($newdata, $decodeRecordFile, $arrData); 
        // array_merge($newdata, $arrData); 

        if($get_file[$get_ParentKey]['UserName'] == $_SESSION['userName']) {
            $encodeData     = json_encode($newdata, JSON_PRETTY_PRINT);
            file_put_contents('recordDetails.json', $encodeData);
        }
        echo json_encode($response);
    }
    
?>