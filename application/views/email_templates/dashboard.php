<div class="row">
  <div class="col-lg-10">
    <div class="panel panel-green">
        <div class="panel-heading profile-heading">
            <h3>Email templates</h3>
        </div>
        <!-- /.panel-heading -->
        <div class="panel-body">
            <?php if(empty($email_templates)): ?>
              <h3>No email tempaltes </h3>
            <?php else: ?>
              <table class="table table-striped">
                <thead>
                <tr>
                <th>Name</th>
                <th>Subject</th>
                <th>created_by</th>
                <th>created_on</th>
                <th></th>
                </tr>
                </thead>
                <tbody>
                <?php foreach ($email_templates as $tempalte): ?>
                  <tr>
                    <td><?php echo $tempalte->name ?></td>
                    <td><?php echo $tempalte->subject ?></td>
                    <td>
                      <div class="profile-heading">
                        <span>
                          <img src="<?php echo asset_url();?>images/profiles/<?php echo isset($system_users_images[$tempalte->created_by])? $system_users_images[$tempalte->created_by]: 'none.jpg' ;?> " class="img-circle img-responsive" alt="" />
                        <span>
                      </div>
                    </td>
                    <td><a href="<?php echo site_url(); ?>email_templates/edit/?id=<?php echo $tempalte->id ?>">view/edit</a></td>
                  </tr>
                <?php endforeach; ?>
                </tbody>
              </table>
            <?php endif; ?>
        </div>
        <!-- /.panel-body -->
    </div>
    <!-- /.panel -->
  </div>
</div>