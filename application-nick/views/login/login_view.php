<div class="container-fluid">
    <!-- Page Heading -->
    <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header">
                Login 
            </h1>
            <!-- <ol class="breadcrumb">
                <li class="active">
                    <i class="fa fa-dashboard"></i> Dashboard
                </li>
            </ol> -->
        </div>
    </div>
    <!-- /.row -->
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <span class="glyphicon glyphicon-lock"></span> Login</div>
                <div class="panel-body">
                    <form class="form-horizontal" name="login" role="form" action="" method="post"> 
                    <div class="form-group">
                        <label for="email" class="col-sm-3 control-label">
                            Email</label>
                        <div class="col-sm-9">
                            <input type="email" class="form-control" name="email" id="email" placeholder="Email" required>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="password" class="col-sm-3 control-label">
                            Password</label>
                        <div class="col-sm-9">
                            <input type="password" class="form-control" id="password" placeholder="Password" name="password" required>
                        </div>
                    </div>
                    <div class="form-group last">
                        <div class="col-sm-offset-3 col-sm-9">
                            <button type="submit" class="btn btn-success btn-sm">
                                Sign in
                            </button>    
                        </div>
                    </div>
                    </form>
                </div>
                <div class="panel-footer">
                    <?php if(validation_errors()): ?>
                    <div class="alert alert-danger" role="alert">
                        <?php echo validation_errors(); ?>
                    </div>
                <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>