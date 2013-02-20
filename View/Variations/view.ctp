<div class="variations view">
<h2><?php  echo __('Variation');?></h2>
	<dl>
		<dt><?php echo __('Id'); ?></dt>
		<dd>
			<?php echo h($variation['Variation']['id']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Name'); ?></dt>
		<dd>
			<?php echo h($variation['Variation']['name']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Cow'); ?></dt>
		<dd>
			<?php echo h($variation['Variation']['cow']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Cluster'); ?></dt>
		<dd>
			<?php echo $this->Html->link($variation['Cluster']['name'], array('controller' => 'clusters', 'action' => 'view', $variation['Cluster']['id'])); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Created'); ?></dt>
		<dd>
			<?php echo h($variation['Variation']['created']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Modified'); ?></dt>
		<dd>
			<?php echo h($variation['Variation']['modified']); ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('Edit Variation'), array('action' => 'edit', $variation['Variation']['id'])); ?> </li>
		<li><?php echo $this->Form->postLink(__('Delete Variation'), array('action' => 'delete', $variation['Variation']['id']), null, __('Are you sure you want to delete # %s?', $variation['Variation']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__('List Variations'), array('action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Variation'), array('action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Clusters'), array('controller' => 'clusters', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Cluster'), array('controller' => 'clusters', 'action' => 'add')); ?> </li>
	</ul>
</div>
