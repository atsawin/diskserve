<h2>ปิดเครื่องลูกทุกเครื่องก่อนเรียกคำสั่ง</h2>
<ul>
  <li>
    <?php echo $this->Html->link('Running mode', array('controller' => 'homes', 'action' => 'run')); ?>
    เป็น mode ใช้งานปกติ
  </li>
  <li>
    <?php echo $this->Html->link('Updating mode', array('controller' => 'homes', 'action' => 'update')); ?>
    สำหรับติดตั้งโปรแกรม หรือ update patch - เปิดเครื่องลูกได้เพียงเครื่องเดียวเท่านั้น
  </li>
  <li>
    <?php echo $this->Html->link('Clear CoW', array('controller' => 'homes', 'action' => 'clearCow')); ?>
    เมื่อติดตั้งโปรแกรม หรือ update patch เสร็จแล้ว จะต้องล้าง CoW เพื่อสร้างใหม่ จากนั้นจึงกลับไปใช้ Running mode ได้
    หรีอใช้ในกรณีต้องการล้าง CoW
  </li>
  <li>Save as initial CoW</li>
  <li>Restore initial CoW</li>
  <li>
    <?php echo $this->Html->link('Show status', array('controller' => 'homes', 'action' => 'status')); ?>
  </li>
  <li>
    <?php echo $this->Html->link('Logout', array('controller' => 'users', 'action' => 'logout')); ?>
  </li>
</ul>
