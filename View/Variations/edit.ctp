<div class="variations form">
<?php echo $this->Form->create('Variation');?>
	<fieldset>
		<legend><?php echo __('Edit Variation'); ?></legend>
	<?php
		echo $this->Form->input('id');
		echo $this->Form->input('name');
		echo $this->Form->input('cow');
		echo $this->Form->input('cluster', array('type' => 'text', 'readonly' => true, 'value' => $clusters[$this->request->data['Variation']['cluster_id']]));
		echo $this->Form->input('computer_id', array('label' => 'Copy CoW from', 'empty' => 'Do not copy'));
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit'));?>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>

		<li><?php echo $this->Form->postLink(__('Delete'), array('action' => 'delete', $this->Form->value('Variation.id')), null, __('Are you sure you want to delete # %s?', $this->Form->value('Variation.id'))); ?></li>
		<li><?php echo $this->Html->link(__('List Variations'), array('action' => 'index'));?></li>
		<li><?php echo $this->Html->link(__('List Clusters'), array('controller' => 'clusters', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Cluster'), array('controller' => 'clusters', 'action' => 'add')); ?> </li>
	</ul>
</div>
