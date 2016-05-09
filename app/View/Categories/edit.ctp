<!DOCTYPE html>
<html>
<body>
	<?php echo $this->element('header'); ?>
	<div class="col-sm-3 col-md-2 sidebar">
        <ul class="nav nav-sidebar">
        	<li ><?php echo $this->Form->postLink(__('Xóa danh mục'), array('action' => 'delete', $this->Form->value('Category.id')), array('confirm' => __('Bạn có chắc chắn muốn xóa danh mục %s?', $this->Form->value('Category.category_name')))); ?></li>
        	<li><?php echo $this->Html->link(__('Trở về'), array('action' => 'index')); ?></li>
	    </ul>
	</div>
	<div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">
		<?php echo $this->Session->flash(); ?>
		<div class="categories form">
		<?php echo $this->Form->create('Category'); ?>
		<fieldset>
			<legend><?php echo __('Sửa danh mục'); ?></legend>
		<?php
			echo $this->Form->input('id');
			echo $this->Form->input('category_name',array('label'=>'Tên danh mục','class'=>"form-control", 'placeholder'=>" Tên danh mục"));
			echo $this->Form->input('category_type',array('label'=>'Kiểu danh mục','class'=>"form-control", 'options' => array('Nợ' => 'Nợ' , 'Cho Vay' => 'Cho Vay' , 'Chi Tiêu' => 'Chi Tiêu', 'Khoản Thu Nhập' => 'Thu Nhập')));
		?>
		</fieldset>
		</br>
		<?php echo $this->Form->button('Lưu thay đổi',array('type' => 'submit','class'=>'btn btn-primary')); ?>
		<?php echo $this->Form->end(); ?>
		</div>
	</div>
</body>

</html>