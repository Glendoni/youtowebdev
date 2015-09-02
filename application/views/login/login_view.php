            <?php
            $this->load->library('user_agent');

 if ($this->agent->is_browser('Chrome'))
{?>
<?php }
else if ($this->agent->is_browser())
{?>
<div class="alert alert-info" role="alert"><strong>Tip:</strong> Baselist is designed to work best on Chrome.</div>
    <?php
} ?>

<div class="container">
    <div class="row">
    <?php $msg = $this->session->flashdata('message'); $msg_2 = validation_errors(); if($msg or $msg_2): ?>
        <div class="alert alert-danger alert-dismissible " role="alert">
          <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
           <strong> <?php echo $msg ?>
            <?php echo $msg_2 ?></strong>
        </div>
    <?php endif; ?>
        <div class="col-md-4 col-md-offset-4">
            <div class="login-panel panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title">Please Sign In</h3>
                </div>
                <div class="panel-body">
                    <form name="login" role="form" action="" method="post"> 
                        <fieldset>
                            <div class="form-group">
                                <input class="form-control" placeholder="E-mail" name="email" type="email" autofocus>
                            </div>
                            <div class="form-group">
                                <input class="form-control" placeholder="Password" name="password" type="password" value="">
                            </div>
                            <!-- Change this to a button or input when using this as a form -->
                            <button type="submit" class="btn btn-lg btn-success btn-block">Login</button> 
                        </fieldset>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

