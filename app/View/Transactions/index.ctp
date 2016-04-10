<!DOCTYPE html>
<html>
<body>
	<?php echo $this->element('header');	?>
	<div class="col-sm-3 col-md-2 sidebar">
          <ul class="nav nav-sidebar">
      		<li class="active"><?php echo $this->Html->link(__('Trang chủ'), array('controller' => 'users', 'action' => 'index')); ?> </li>
            <li><?php echo $this->Html->link(__(' Thêm giao dịch mới'), array('action' => 'add')); ?></li>
			<li><?php echo $this->Html->link(__('Trở về'), array('controller' => 'wallets', 'action' => 'index')); ?> </li>
          </ul>
	</div>

	<div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">
		<?php echo $this->Session->flash(); ?>
		<div class="transactions index">
		<?php if(!empty($transactions)): ?>
			<h2><?php echo __('Các giao dịch đã lưu'); ?></h2>
			<table class="table table-striped">
			<thead>
			<tr>
					<!-- <th><?php echo $this->Paginator->sort('id'); ?></th> -->
					<th><?php echo $this->Paginator->sort('amount','Giá trị'); ?></th>
					<th><?php echo $this->Paginator->sort('create_date','Ngày giao dịch'); ?></th>
					<th><?php echo $this->Paginator->sort('note','Ghi chú'); ?></th>
					<th><?php echo $this->Paginator->sort('wallet_name', 'Tên ví'); ?></th>
					<th><?php echo $this->Paginator->sort('category_name','Kiểu danh mục'); ?></th>
					<th><?php echo __('Actions'); ?></th>
			</tr>
			</thead>
			<tbody>
			<?php foreach ($transactions as $transaction): ?>
			<tr>
				<!-- <td><?php echo h($transaction['Transaction']['id']); ?>&nbsp;</td> -->
				<td><?php echo h($transaction['Transaction']['amount']); ?>&nbsp;</td>
				<td><?php echo h($transaction['Transaction']['create_date']); ?>&nbsp;</td>
				<td><?php echo h($transaction['Transaction']['note']); ?>&nbsp;</td>
				<td>
					<?php echo $this->Html->link($transaction['Wallet']['wallet_name'], array('controller' => 'wallets', 'action' => 'view', $transaction['Wallet']['id'])); ?>
				</td>
				<td>
					<?php echo $this->Html->link($transaction['Category']['category_name'], array('controller' => 'categories', 'action' => 'view', $transaction['Category']['id'])); ?>
				</td>
				<td class="actions">
					<?php echo $this->Html->link(__('Chi tiết'), array('action' => 'view', $transaction['Transaction']['id']),array('class' => 'btn btn-xs btn-primary')); ?>
					<?php echo $this->Html->link(__('Sửa'), array('action' => 'edit', $transaction['Transaction']['id']),array('class' => 'btn btn-xs btn-primary')); ?>
					<?php echo $this->Form->postLink(__('Xóa'), array('action' => 'delete', $transaction['Transaction']['id']), array('confirm' => __('Are you sure you want to delete # %s?', $transaction['Transaction']['id']))); ?>
				</td>
			</tr>
			<?php endforeach; ?>
			</tbody>
			</table>
			<?php echo $this->Html->link(__(' Thêm giao dịch mới'), array('controller' => 'transactions', 'action' => 'add'), array('class' => 'btn btn-sm btn-primary')); ?></br>
			<?php echo $this->element('paginate', array('object' => 'giao dịch')); ?>
		</div>
	<?php else: ?>
		<h1>Opps!!!</h1>
		<h4><strong> Bạn chưa tạo giao dịch nào. Nhấn vào <?php echo $this->Html->link('đây', array('controller'=> 'transactions', 'action' => 'add')) ; ?> để tạo giao dịch mới </strong></h4>
	<?php endif ?>
	</div>

</body>


</html>