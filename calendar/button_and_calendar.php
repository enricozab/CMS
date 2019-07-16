<div>
  <button class="btn btn-primary" id="login">Login with Google</button>
  <button class="btn btn-primary" id="create">Create New Event</button><br><br>
  <?php
  $email = $_SESSION['user_email'];
  if ( strpos( $email, '@gmail.com' ) !== false) {
    $email_before_at = substr($email, 0, strpos($email, "@"));
    $email_after_at = 'gmail.com';
  }
  if ( strpos( $email, '@dlsu.edu.ph' ) !== false) {
    $email_before_at = substr($email, 0, strpos($email, "@"));
    $email_after_at = 'dlsu.edu.ph';
  }
  $linksource="https://calendar.google.com/calendar/embed?height=600&amp;wkst=1&amp;bgcolor=%23FFFFFF&amp;src=".$email_before_at."%40".$email_after_at."&amp;color=%231B887A&amp;ctz=Asia%2FManila"
  ?>
  <iframe src="<?= $linksource ?>" style="border-width:0" width="100%" height="600" frameborder="0" scrolling="no"></iframe>
</div>
