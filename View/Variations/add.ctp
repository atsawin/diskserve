<div class="variations form">
<?php echo $this->Form->create('Variation');?>
	<fieldset>
		<legend><?php echo __('Add Variation'); ?></legend>
	<?php
		echo $this->Form->input('name');
		echo $this->Form->input('cow', array('label' => 'CoW File Name'));
		echo $this->Form->input('cluster_id');
		echo $this->Form->input('computer_id', array('label' => 'Copy CoW from'));
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit'));?>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>

		<li><?php echo $this->Html->link(__('List Variations'), array('action' => 'index'));?></li>
		<li><?php echo $this->Html->link(__('List Clusters'), array('controller' => 'clusters', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Cluster'), array('controller' => 'clusters', 'action' => 'add')); ?> </li>
	</ul>
</div>
