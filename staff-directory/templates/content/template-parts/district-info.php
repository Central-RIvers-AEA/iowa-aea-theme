<?php
/**
 * Partial for Districts info
 */

global $post;

?>

<div class='row'>
  <div class='col-sm-12 col-lg-6'>
    <dl>
      <dt>Address</dt>
      <dd><?php echo get_post_meta($post->ID, 'address', true) ?></dt>
      <dt>Phone</dt>
      <dd><?php echo get_post_meta($post->ID, 'phone_number', true) ?></dt>
      <dt>Fax</dt>
      <dd><?php echo get_post_meta($post->ID, 'fax_number', true) ?></dt>
    </dl>
  </div>
  <div class='col-sm-12 col-lg-6'>
    <dl>
      <?php
        $personnel = get_post_meta($post->ID, 'school_personnel', true);
        foreach($personnel as $person){
          echo "<dt>".$person['title'] . "<dt> <dd> " . $person['name'] . "<dd>";
          echo '<a href="mailto:' . $person['email'] . '">'.$person['email']."</a>";
        }
      ?>
    </dl>
  </div>
</div>
<hr />
