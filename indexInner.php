<?php
session_start();
    if (isset($_POST['action']) && $_POST['action'] === "signin_data") {
        // echo 111;exit;
        $loginDetails   = 'loginDetails.json';
        if (file_exists($loginDetails)) {
            $data       = file_get_contents($loginDetails, true);
            $users      = json_decode($data, true);

            // echo'<pre>';print_r($users);exit;

            if (isset($_POST['userName']) && isset($_POST['userPwd'])) {
                $userName   = $_POST["userName"];
                $userPwd    = $_POST["userPwd"];
                /* $arr = array(
                    'userName' => $_POST['userName'],
                    'userPwd' => $_POST['userPwd'],
                ); */
                // echo'<pre>';print_r($users[0]['UserName'] . '--'. $userName);exit;
                

                $authenticated = false;


                foreach ($users as $user) {
                    if ($user['UserName'] == $userName && $user['Password'] == $userPwd) {
                        $authenticated = true;
                        break;
                    }
                }

                // exit;

                if ($authenticated) {
                    $_SESSION['logedUser']  = true;
                    $_SESSION['userName']   = $user['UserName'];
                    $response = array('status' => 'success');
                } else {
                    $response = array('status' => 'error', 'message' => 'Invalid username or password');
                }
            } else {
                $response = array('status' => 'error', 'message' => 'Missing username or password');
            }
        } else {
            $response = array('status' => 'error', 'message' => 'Login details file not found');
        }

        echo json_encode($response);
    }
?>
