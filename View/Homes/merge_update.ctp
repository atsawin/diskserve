<?php $this->Html->meta(null, null, array('http-equiv' => 'refresh', 'content' => 5, 'inline' => false)); ?>
<?php
  echo 'Updating... ' . $this->Number->toPercentage(100 * ($merge['cow_usage_size'] - $status['pending_size']) / $merge['cow_usage_size']);
?>
