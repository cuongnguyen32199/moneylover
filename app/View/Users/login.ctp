<html>
<head>
	
</head>

<body>
<div class ="container">
	<div class="content col-md-4">
	</div>
		<div class="content col-md-4">
			<div class="panel panel-info">
				<div class="panel-heading">
	            	<h3 class="panel-title"><strong class="glyphicon glyphicon-user"></strong> Đăng nhập </h3>
            	</div>
	            <div class="panel-body"> 
					<div class="users form">
						<?php echo $this->Session->flash('auth'); ?>
						<?php echo $this->Form->create('User' ); ?>
						<fieldset>
							<?php echo $this->Form->input('username',array('label'=>'Tên đăng nhập','class'=>"form-control", 'placeholder'=>" Tên đăng nhập"));
							echo $this->Form->input('password',array('lable'=>'Mật khẩu', 'class'=>'form-control', 'placeholder'=>"Mật khẩu" ));
							?>
							
						</fieldset></br>
						<?php echo $this->Form->button('Đăng nhập',array('type' => 'submit','class'=>'btn btn-lg btn-primary btn-block')); ?></br>
						
						<?php echo $this->Html->link('Quên mật khẩu?','/quen-mat-khau'); ?></br>
						<?php echo $this->Html->link('Đăng kí mới','/users/add', array('class' => 'btn btn-sm btn-default')); ?>
						
						<?php echo $this->Form->end(); ?>
					</div>
				</div>
			</div>
		</div>
	</div>
</body>
</html>