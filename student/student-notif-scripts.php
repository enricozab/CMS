<?php
if($crow){
  if($crow['CASES'] > 0){ ?>
    $('#cn').text('<?php echo $crow['CASES'] ?>');
  <?php }
  else{ ?>
    $('#cn').text('');
  <?php }
} ?>
