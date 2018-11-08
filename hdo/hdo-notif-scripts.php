<?php
if($crow){
  if($crow['CASES'] > 0){ ?>
    $('#cn').text('<?php echo $crow['CASES'] ?>');
  <?php }
  else{ ?>
    $('#cn').text('');
  <?php }
} ?>

<?php
if($irrow){
  if($irrow['INCIDENT REPORTS'] > 0){ ?>
    $('#ir').text('<?php echo $irrow['INCIDENT REPORTS'] ?>');
  <?php }
  else{ ?>
    $('#ir').text('');
  <?php }
} ?>
