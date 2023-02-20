<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title> JSON Login </title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
  </head>
  <body class="text-center" data-new-gr-c-s-check-loaded="14.1097.0" data-gr-ext-installed="" cz-shortcut-listen="true">
    <div class="container">
      <div class="row justify-content-center">
        <div class="col-md-3"><br><br><br><br><br>
          <main class="form-signin w-100 m-auto">
            <form id="frm"> 
                <img class="mb-4" src="https://upload.wikimedia.org/wikipedia/commons/thumb/b/b2/Bootstrap_logo.svg/1280px-Bootstrap_logo.svg.png" alt="" width="72" height="57">
                <h1 class="h3 mb-3 fw-normal">Please sign in</h1>
                <div class="form-floating">
                    <input type="text" class="form-control" name="userName" id="userName" placeholder="User Name">
                    <label for="floatingInput">User Name</label>
                </div><br>
                <div class="form-floating">
                    <input type="password" class="form-control" name="userPwd" id="userPwd" placeholder="Password">
                    <label for="floatingPassword">Password</label>
                </div><br>
                <button type="button" class="w-100 btn btn-lg btn-primary" onclick="LogInSub()">Sign in</button>
              <p class="mt-5 mb-3 text-muted">© <?php echo date("Y"); ?></p>
              <small class="mt-5 mb-3 text-muted" style="color: gray;"> Design By - Shuvadeep </small>
            </form>
          </main>
        </div>
      </div>
    </div>
  </body>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
  <script>
    function LogInSub() {
        var log = new FormData(frm);
		log.append('action','signin_data');
        // console.log(log);
            $.ajax({
                data : log,
                type : 'post',
                url : 'indexInner.php',
                dataType: "json",
                processData : false,
                contentType : false,
                success: function(val) {
                    // console.log(val);
                    if (val = 'success') {
                        // alert("correct");
                        window.location.href = "dashboard.php";
                    }else{
                        alert("Sorry, something went wrong!");
                    }
                    
                }
            })
    }
  </script>
</html>