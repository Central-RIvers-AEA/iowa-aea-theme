<?php 

global $post;

?>

<div class='col-sm-12 col-lg-6'>
  <h3><?php the_title() ?></h3>
  <dl>
    <dt>Address</dt>
    <dd>
      <?php echo get_post_meta($post->ID, 'address', true) ?> <br />
      <?php echo get_post_meta($post->ID, 'city_state_zip', true) ?>
    </dd>
    <dt>Phone</dt>
    <dd><?php echo get_post_meta($post->ID, 'phone_number', true) ?></dt>
    <dt>Fax</dt>
    <dd><?php echo get_post_meta($post->ID, 'fax_number', true) ?></dt>
    <?php
      $personnel = get_post_meta($post->ID, 'school_personnel', true);
      foreach($personnel as $person){
        echo "<dt>".$person['title'] . "<dt> <dd> " . $person['name'] . "<dd>";
        if($person['email'] != ''){
          echo '<a href="mailto:' . $person['email'] . '">'.$person['email']."</a>";
        }
      }
    ?>
  </dl>

</div>