<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Login</title>
    <!-- Bootstrap core CSS -->
        <link href="css/bootstrap.min.css" rel="stylesheet">

    <!-- Add custom CSS here -->
<style>
body { 
  background: url(images/login_bg.jpg) no-repeat center center fixed; 
  -webkit-background-size: cover;
  -moz-background-size: cover;
  -o-background-size: cover;
  background-size: cover;
}

.panel-default {
opacity: 0.9;
margin-top:30px;
}
.form-group.last { margin-bottom:0px; }
</style>

    <!-- Page Specific CSS -->
  </head>


  <body>
<div class="container">
    <div class="row">
 
        <div class="col-md-4 col-md-offset-7">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <span class="glyphicon glyphicon-lock"></span> Login</div>
                <div class="panel-body">
                    <form class="form-horizontal" role="form" action="includes/login.php" method="post"> 
                    <div class="form-group">
                        <label for="inputEmail3" class="col-sm-3 control-label">
                            Email</label>
                        <div class="col-sm-9">
                            <input type="email" class="form-control" name="myusername" id="inputEmail3" placeholder="Email" required>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="inputPassword3" class="col-sm-3 control-label">
                            Password</label>
                        <div class="col-sm-9">
                            <input type="password" class="form-control" id="inputPassword3" placeholder="Password" name="mypassword" required>
                        </div>
                    </div>
                    <div class="form-group">
                        
                    </div>
                    <div class="form-group last">
                        <div class="col-sm-offset-3 col-sm-9">
                            <button type="submit" class="btn btn-success btn-sm">
                                Sign in</button>
                                
                        </div>
                    </div>
                    </form>
                </div>
                <div class="panel-footer">
                 </div>
            </div>
        </div>
                   <div class="col-md-4 col-md-offset-7">


<?php
  $status = $_GET['status'];
if ($status=="incorrect") {
  ?>
  
  <div class="row">
  <div class="col-lg-4"></div>
          <div class="col-lg-4">
            <div class="alert alert-dismissable alert-danger">
              Whoops, that password and username combo can't be found....</div>
          </div>

        </div>

<?php }

?>
</div>
    </div>
</div>

</body>
</html>
