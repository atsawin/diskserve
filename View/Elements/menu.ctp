<div class="actions">
  <h3>Actions</h3>
  <ul>
    <li><?php echo $this->Html->link('Update Master Image', array('controller' => 'homes', 'action' => 'merge')); ?></li>
    <li><?php echo $this->Html->link('Change Mode', array('controller' => 'homes', 'action' => 'mode')); ?></li>
    <li><?php echo $this->Html->link('Restart Service', array('controller' => 'homes', 'action' => 'restart')); ?></li>
    <li><?php echo $this->Html->link('Configure', array('controller' => 'clusters', 'action' => 'index')); ?></li>
    <li><?php echo $this->Html->link('Setting', array('controller' => 'settings', 'action' => 'index')); ?></li>
    <li><?php echo $this->Html->link('Logout', array('controller' => 'users', 'action' => 'logout')); ?></li>
  </ul>
</div>
