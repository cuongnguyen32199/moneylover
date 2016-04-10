<!DOCTYPE html>
<html>

<body>
	<?php echo $this->element('header'); ?>
	<div class="col-sm-3 col-md-2 sidebar">
          <ul class="nav nav-sidebar">
          	<li class="active"><?php echo $this->Html->link(__('Trang chủ'), array('controller' => 'users', 'action' => 'index')); ?> </li>
            <li><?php echo $this->Html->link(__(' Thêm ví mới'), array('action' => 'add')); ?></li>
			
			<li><?php echo $this->Html->link(__(' Các giao dịch'), array('controller' => 'transactions', 'action' => 'index')); ?> </li>
			<li><?php echo $this->Html->link(__(' Thêm giao dịch mới'), array('controller' => 'transactions', 'action' => 'add')); ?></li>
			<li><?php echo $this->Html->link(__('Trở về'), array('controller' => 'users', 'action' => 'index')); ?></li>
          </ul>
	</div>
	<div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">
		<?php echo $this->Session->flash(); ?>
			<?php if(!empty($wallets)): ?>
				
				<div class="wallets index">
					<h2><?php echo __('Danh sách ví'); ?></h2>
					<table class="table table-striped">
					<thead>
					<tr>
							<!-- <th><?php echo $this->Paginator->sort('id'); ?></th> -->
							<th><?php echo $this->Paginator->sort('wallet_name','Tên Ví'); ?></th>
							<th><?php echo $this->Paginator->sort('currency','Đơn vị tiền tệ'); ?></th>
							<th><?php echo $this->Paginator->sort('banlances', 'Số dư'); ?></th>
							<th><?php echo $this->Paginator->sort('user_id', 'Tài khoản'); ?></th>
							<th><?php echo __('Actions'); ?></th>
					</tr>
					</thead>
					<tbody>
					<?php foreach ($wallets as $wallet): ?>
					<tr>
						<!-- <td><?php echo h($wallet['Wallet']['id']); ?>&nbsp;</td> -->
						<td><?php echo h($wallet['Wallet']['wallet_name']); ?>&nbsp;</td>
						<td><?php echo h($wallet['Wallet']['currency']); ?>&nbsp;</td>
						<td><?php echo h($wallet['Wallet']['banlances']); ?>&nbsp;</td>
						<td>
							<?php echo $this->Html->link($wallet['User']['username'], array('controller' => 'users', 'action' => 'view', $wallet['User']['id'])); ?>
						</td>
						<td class="actions">
							<?php echo $this->Html->link(__('Chi tiết'), array('action' => 'view', $wallet['Wallet']['id']), array('class' => 'btn btn-xs btn-primary')); ?>
							<?php echo $this->Html->link(__('Sửa'), array('action' => 'edit', $wallet['Wallet']['id']),array('class' => 'btn btn-xs btn-primary')); ?>
							<?php echo $this->Form->postLink(__('Xóa'), array('action' => 'delete', $wallet['Wallet']['id']), array('confirm' => __(' Bạn có chắc chắn muốn xóa %s?', $wallet['Wallet']['id']))); ?>
						</td>
					</tr>
					<?php endforeach; ?>
					</tbody>
					</table>
					<?php echo $this->element('paginate', array('object' => 'ví')); ?>
			<?php else: ?>
					<h1>Opps!!!</h1>
					<strong> Bạn chưa tạo ví. Nhấn vào <?php echo $this->Html->link('đây', array('controller'=> 'wallets', 'action' => 'add')) ; ?> để tạo ví mới </strong>
			<?php endif ?>
			</div>
	</div>
</body>
</html>