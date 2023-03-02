<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<div class="container-fluid">
<?php
        echo form_open(base_url('/Home/login'), array('class' => 'login', 'id' => 'login-form') , array('form_mod'=>'') );
        echo $this->session->flashdata('message');
        ?>
        <div class="grid grid_3"></div>
        <div class="card grid grid_6" >
          <div class="card-body nicdark_aligncenter_responsive">
            <h5 class="card-title">

            </h5>
            <div class="form-group">
              <?php echo form_label('Login', 'login'); ?>
              <?php echo form_input('login', '', 'class="form-control" aria-describedby="emailHelp" placeholder="Enter email"'); ?>
              <?php echo form_error('login', 	'<div class="alert alert-danger">', '</div>'); ?>
            </div>
            <div class="form-group">
              <?php echo form_label('Password', 'password'); ?>
              <?php echo form_password('password', 'password', 'class="form-control" aria-describedby="passwordHelp" placeholder="Password"'); ?>
              <?php echo form_error('password', 	'<div class="alert alert-danger">', '</div>'); ?>	  
            </div>	
            <div class="form-group">
              <div class="modal-footer">
          
              <?php 
                if ($this->config->item('captcha')){
                  echo $this->render_object->label('recaptchaResponse');
                  echo $this->render_object->RenderFormElement('recaptchaResponse'); 
                  if ($captcha_error){
                    $this->bootstrap_tools->render_msg($captcha_error);
                  }
                } else { ?>
                  <div class="modal-footer">
                    <button type="submit" class="btn btn-success"><?php echo $this->lang->line('CNX_ME');?></button>
                  </div>
                  <?php
                }


                if ($login_error){
                  $this->bootstrap_tools->render_msg($login_error);
                }
              ?>
              </div>
            </div>          			
          </div>
      </div>	
      <?php
      echo form_close();
      ?>
</div>




	  


<script src="https://www.google.com/recaptcha/api.js" async defer></script>
<script>
grecaptcha.ready(function() {
    grecaptcha.execute('<?php echo SITE_CAPTCHA_KEY;?>', {action: 'homepage'}).then(function(token) {
        document.getElementById('recaptchaResponse').value = token
    });
});
</script>
