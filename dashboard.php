<?php 
   session_start();
//    print_r($_SESSION['logedUser']);exit();
   if (!isset($_SESSION['logedUser'])) {
   	header("Location: index.php");
   }
   ?>
<!doctype html>
<html lang="en">
   <head>
      <meta charset="utf-8">
      <meta name="viewport" content="width=device-width, initial-scale=1">
      <title>Welcome - <?php echo $_SESSION['userName']; ?></title>
      <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
   </head>
   <body>
      <div class="container">
      <div class="row justify-content-md-center">
      <div class="col col-lg-12">
         <div class="container">
            <div class="row justify-content-center">
               <div class="col-md-6">
                  <br><br><br><br><br>
                  <h3> Welcome: <?php echo '<b>' . $_SESSION['userName'] . '</b>';?> </h3>
                  <br>
                  <div class="col-md-8">
                    <form id="dashbrdId">
                    <input type="hidden" name="setTime" id="setTime" value="">
                    <label for="cc-name" class="form-label"> Enter numer whom you want to talk </label>
                    <input type="text" class="form-control" name="EnterNum" id="EnterNum" placeholder="Enter Mobile Number" maxlength="10">
                    <span id="check-error" class="error"></span>
                    <small class="text" style="color: red;"> This conversion will cost 1 Minutes of speech for 1 Rupee less! </small><br>
                    <div class="col-md-6">
                        <label for="timer-demo" class="form-label"> Timer </label>
                        <input type="text" class="form-control timer-demo" name="timer-demo" id="timer-demo" value="" placeholder="0 sec" readonly>
                    </div>
                    <br>
                    <button type="button" class='btn btn-success start-timer-btn' name="startTimeBtn" id="startTimeBtn"> START </button>
                    <button type="button" class='btn btn-danger remove-timer-btn' name="endTime"> STOP </button>
                    <a type="submit" href="logout.php" class="btn btn-primary"> Logout </a>
                    </form>
                  </div><br><br>
                  <div class="container">
                    <div class="row justify-content-center">
                        <div class="col-md-12">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                <th scope="col">Sl#</th>
                                <th scope="col">Login User</th>
                                <th scope="col">Balance</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php 
                                    $ParentRecord   = file_get_contents('loginDetails.json');
                                    $ChildRecord    = file_get_contents('recordDetails.json');
                                    $ParentRecord   = json_decode($ParentRecord, true);
                                    
                                    if (!empty($ParentRecord)) {
                                        foreach ($ParentRecord as $key => $record) {
                                            if($_SESSION['userName'] == $ParentRecord[$key]['UserName']) {
                                ?>
                                <tr>
                                    <th scope="row"> <?= $key; ?>    </th>
                                    <td> <?= $record['UserName']; ?> </td>
                                    <td> <?= $record['Balance']; ?>  </td>
                                </tr>
                                <?php 
                                        }
                                    }
                                }
                                ?>
                            </tbody>
                        </table>
                        </div>
                    </div>
                </div>
               </div>
            </div>
         </div>
      </div>
      <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
      <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
      <script src="https://cdnjs.cloudflare.com/ajax/libs/timer.jquery/0.9.0/timer.jquery.min.js"></script>
      <script>

        /* ============ Validation =============== */
        function blankCheck(controlId,msg)
        {
            if($('#'+controlId).val()=='')
            {
                alert(msg,controlId);
                $('#'+controlId).focus();
                return false;
            }
            return true;
        }
         
        $(document).ready(function() {
        
            

            $("small").hide();
            $(".remove-timer-btn").hide();
            $("#EnterNum").click(function() {
                $("small").show();
            });
        
            /* :::::::::::::::::: StopWatch :::::::::::::::::: */
            var hasTimer                = false;
            
            /* ::::: Init timer start ::::: */
            $('.start-timer-btn').on('click', function() {
            //  timeCount();

                if (!blankCheck('EnterNum', 'Please enter a Mobile Number!!!'))
                    return false;

                hasTimer = true;

                $('.timer-demo').timer({
                    editable: true
                });
                var $timer = $('#timer-demo');
                // setInterval(CountMin_Func, $timer.data('seconds') * 1000);
                $(".remove-timer-btn").show();
        
            });
        
            /* ::::: Remove timer ::::: */
            $('.remove-timer-btn').on('click', function() {
                var $timer      = $('#timer-demo');
                var timerValue  = $timer.data('seconds');
                // console.log(timerValue); 
                $('#setTime').val(timerValue);
                hasTimer = false;
                $('.timer-demo').timer('remove');
                $(".remove-timer-btn").show();
                timeCount();
                //clearInterval(setInterval(myFunction, $timer.data('seconds') * 1000));
            });
        });
          
        function timeCount() {
            
            var setTime     = $('#setTime').val();
            var EnterNum    = $('#EnterNum').val();
            
            $.ajax({
                type: 'POST',
                url: 'dashboardInner.php',
                data: { setTime:setTime, EnterNum:EnterNum },
                dataType: "json",
                success: function(response) {
                    console.log(response);
                        if(response.status == 404){
                            alert(response.message);
                        } 
                }
            });
        }
      </script>
   </body>
</html>