<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<!doctype html>
<html lang="fr">
<head>
	<!-- Required meta tags -->
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<?php $this->bootstrap_tools->RenderAttachFiles('css');?>
	<title><?php echo $app_name;?></title>
</head>
<body>

<!-- Bootstrap NavBar -->
<nav class="navbar navbar-expand-md navbar-dark  bg-dark">
    <a href="<?php echo base_url();?>" class="navbar-brand"><?php echo $this->config->item('app_name');?></a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNav">
		<ul class="navbar-nav">
			<?php echo $this->render_menu->Get('topmenu');?>
		</ul>
		<ul class="navbar-nav ml-auto">	

			<?php
			if ($search_object->autorize){ ?>
				<li class="nav-item dropdown">
				<?php echo form_open($search_object->url, ['class' => 'form-inline', 'id' => 'myform']);?>
				<input class="form-control mr-sm-2" type="search" name='global_search' id='global_search' placeholder="Search" aria-label="Search" value="<?php echo $search_object->global_search;?>">
				<button class="btn btn-success btn-sm" type="submit"><span class="oi oi-magnifying-glass"></span></button>&nbsp;
				<?php if ($search_object->global_search){ ?>
					<a href='<?php echo base_url($search_object->url);?>/search/reset' class='btn btn-warning btn-sm'><span class="oi oi-circle-x"></span></a>
				<?php } ?>
				</form>
				</li>
				<?php
			}
			?>
			<?php echo $this->render_menu->Get('sysmenu');?>
			<?php echo $this->render_menu->Get('optionmenu');?>	
			<?php if ($this->session->userdata('usercheck') || $this->acl->_get('DontCheck')  ) { ?>
			<li class="nav-item dropdown">
				<a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
					<span class="mr-2 d-none d-lg-inline text-gray-600 small"><?php echo (($this->session->userdata('usercheck')) ? $this->session->userdata('usercheck')->name:''); ?></span>
					<?php echo  $this->render_object->RenderImg('undraw_profile.svg','" class="img-profile rounded-circle" alt="'); ?>
				</a>	
				<!-- Dropdown - User Information -->
				<div class="dropdown-menu dropdown-menu-right" aria-labelledby="userDropdown">
					<a class="dropdown-item" href="<?php echo base_url('Home/myaccount');?>"><span class="oi oi-people"></span> <?php echo Lang('myaccount');?></a>
					<a class="dropdown-item" href="<?php echo base_url('Home/logout');?>"><span class="oi oi-account-logout"></span> <?php echo Lang('Login_out');?></a>
				</div>
			</li>
			<?php } ?>
		</ul>
    </div>
</nav>
<!-- NavBar END -->
<!-- Bootstrap row -->
<div class="row" id="body-row">
	<!-- Sidebar -->
	<?php /*<div id="sidebar-container" class="sidebar-expanded d-none d-md-block">
	<ul class="list-group">
		<li class="list-group-item sidebar-separator-title text-muted d-flex align-items-center menu-collapsed">
			<small>MAIN MENU</small>
		</li>
		<?php echo $this->render_menu->Get('leftmenu');?>
		<?php /*<a href="#top" data-toggle="sidebar-colapse" class="bg-dark list-group-item list-group-item-action d-flex align-items-center">
			<div class="d-flex w-100 justify-content-start align-items-center">
				<span id="collapse-icon" class="oi oi-chevron-left"></span>
				<span id="collapse-text" class="menu-collapsed">Collapse</span>
			</div>
		</a>
	</ul>
	</div>
	<!-- sidebar-container END -->  */ ?>
	
	<!-- Page Content  -->
	<div class="col p-4">
		<nav class="navbar navbar-expand-lg navbar-light bg-light"> 
			<ul class="navbar-nav mr-auto">
				<li class="nav-item"> 
					<h2><?php echo $title;?></h2> 
				</li> 
			</ul>
			<ul class="nav justify-content-end">
			<?php  
			if ($this->render_object->_get('_ui_rules') AND !$this->render_object->_get('form_mod')){  
				foreach($this->render_object->_get('_ui_rules') AS $rule){
					if (in_array($rule->term , $this->render_object->_get('_not_link_list')) AND $rule->autorize ){
						echo '<a class="btn btn-sm '.$this->lang->line($rule->term.'_class').'" href="'.$rule->url.'"><span class="'.$rule->icon.'"></span> '.$rule->name.'</a>&nbsp;';
					}
				}
			} 
			?>
			</ul> 
		</nav> 
	
		

