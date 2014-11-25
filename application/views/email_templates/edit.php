<div class="row">
<ol class="breadcrumb">
          <li><a href="<?php echo site_url(); ?>email_templates/"><span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>Dashboard</a></li>
        </ol>
  <div class="col-lg-12">
    <div class="panel panel-default">
        <div class="panel-heading"> 
            <h3>Email Template</h3>
        </div>
        <!-- /.panel-heading -->
        <div class="panel-body">
            <?php echo form_open_multipart('/email_templates/update');  if(isset($template->id)) {echo form_hidden('template_id', $template->id);} ?>
                <div class="form-group col-md-6">  
                  <label>Name*</label>
                  <input type="text" class="form-control" required name="name" value="<?php echo isset($template->name)?$template->name:'';  ?>" > 
                </div>
                <div class="form-group col-md-6">  
                  <label>Subject*</label>
                  <input type="text" class="form-control" required name="subject" value="<?php echo isset($template->subject)?$template->subject:''  ?>" > 
                </div>
                <div class="form-group col-md-12">            
                <label>Message* <small>Variables: {{contact_name}}</small></label>
                <textarea rows="4" cols="50" class="form-control" required name="message"><?php echo isset($template->message)?$template->message:'$contact_name';  ?></textarea>
                </div>
                <div class="form-group col-md-12">
                 
                  <?php if(!empty($template_attachments)): ?> 
                  <h4>Attachments: </h4>                  
                  <?php foreach ($template_attachments as $template_attachment):?>
                  <p><small><?php echo preg_replace('/^.+[\\\\\\/]/', '', $template_attachment); ?> </small></p>
                  <?php endforeach;?> 
                  <button class="btn btn-danger btn-xs" name="clear_attachments" value="1">Clear attachments</button>
                  <?php endif;?> 
                  <hr> 
                  <label>add attachments <small>(hold down 'Crtl' (PC) or 'cmd' (Mac) to select multiple files )</small></label>
                  <input type="file" name="files[]" multiple />
                </div>      
                <div class="form-group col-md-12">
                  <button class="btn btn-primary" name="email_template" value="1">Update</button>
                </div>
            </form>
        </div>
        <!-- /.panel-body -->
    </div>
    <!-- /.panel -->
  </div>
</div>