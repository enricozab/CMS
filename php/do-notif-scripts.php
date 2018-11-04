<?php
if($row){
  if($row['INCIDENT REPORTS'] > 0){ ?>
    $('#ir').text('<?php echo $row['INCIDENT REPORTS'] ?>');
  <?php }
  else{ ?>
    $('#ir').text('');
  <?php }
} ?>
