<div class="variations index">
	<h2><?php echo __('Variations');?></h2>
	<table cellpadding="0" cellspacing="0">
	<tr>
			<th><?php echo $this->Paginator->sort('id');?></th>
			<th><?php echo $this->Paginator->sort('name');?></th>
			<th><?php echo $this->Paginator->sort('cow');?></th>
			<th><?php echo $this->Paginator->sort('cluster_id');?></th>
			<th><?php echo $this->Paginator->sort('created');?></th>
			<th><?php echo $this->Paginator->sort('modified');?></th>
			<th class="actions"><?php echo __('Actions');?></th>
	</tr>
	<?php
	foreach ($variations as $variation): ?>
	<tr>
		<td><?php echo h($variation['Variation']['id']); ?>&nbsp;</td>
		<td><?php echo h($variation['Variation']['name']); ?>&nbsp;</td>
		<td><?php echo h($variation['Variation']['cow']); ?>&nbsp;</td>
		<td>
			<?php echo $this->Html->link($variation['Cluster']['name'], array('controller' => 'clusters', 'action' => 'view', $variation['Cluster']['id'])); ?>
		</td>
		<td><?php echo h($variation['Variation']['created']); ?>&nbsp;</td>
		<td><?php echo h($variation['Variation']['modified']); ?>&nbsp;</td>
		<td class="actions">
			<?php echo $this->Html->link(__('View'), array('action' => 'view', $variation['Variation']['id'])); ?>
			<?php echo $this->Html->link(__('Edit'), array('action' => 'edit', $variation['Variation']['id'])); ?>
			<?php echo $this->Form->postLink(__('Delete'), array('action' => 'delete', $variation['Variation']['id']), null, __('Are you sure you want to delete # %s?', $variation['Variation']['id'])); ?>
		</td>
	</tr>
<?php endforeach; ?>
	</table>
	<p>
	<?php
	echo $this->Paginator->counter(array(
	'format' => __('Page {:page} of {:pages}, showing {:current} records out of {:count} total, starting on record {:start}, ending on {:end}')
	));
	?>	</p>

	<div class="paging">
	<?php
		echo $this->Paginator->prev('< ' . __('previous'), array(), null, array('class' => 'prev disabled'));
		echo $this->Paginator->numbers(array('separator' => ''));
		echo $this->Paginator->next(__('next') . ' >', array(), null, array('class' => 'next disabled'));
	?>
	</div>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('New Variation'), array('action' => 'add')); ?></li>
		<li><?php echo $this->Html->link(__('List Clusters'), array('controller' => 'clusters', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Cluster'), array('controller' => 'clusters', 'action' => 'add')); ?> </li>
	</ul>
</div>
