<?php
// echo'<pre>';print_R($_POST);exit;
session_start();
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
        // echo 1111;exit;
        $setTime    = $_POST['setTime'];
        $EnterNum   = $_POST['EnterNum'];
        // echo $setTime . ' -- ' . $EnterNum;exit;
        
        $get_file           = json_decode(file_get_contents('loginDetails.json'),true);
        $get_ParentKey      = array_search_inner($get_file, 'UserName', $_SESSION['userName']); 
        $yourBalace         = $get_file[$get_ParentKey]['Balance'];

        $setTime = ceil($setTime / 60);

        if ($get_ParentKey !== null) {
            $time_diff = $yourBalace - $setTime;
            if ($yourBalace > 0) {
                $get_file[$get_ParentKey]['Balance'] = $time_diff;
                file_put_contents('loginDetails.json', json_encode($get_file));
                $response = array('status' => 'success');
            } else {
                $response = array('status' => '404', 'message' => 'You dont have balence!!!');
            }  
        }
        echo json_encode($response);
    }

    /* 
        * When balence is 0 then show alert message 
        * when balence is 1 then balence is 0 then automatically end button activated.
        * another json file details of login user details 
            * how times talk 
            * which number dail 
    */
    
?>