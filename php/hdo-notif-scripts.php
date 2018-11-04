<?php
if($row){
  if($row['CASES'] > 0){ ?>
    $('#cn').text('<?php echo $row['CASES'] ?>');
  <?php }
  else{ ?>
    $('#cn').text('');
  <?php }
} ?>
