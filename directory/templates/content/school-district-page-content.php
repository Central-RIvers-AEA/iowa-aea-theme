<?php
/**
 * Template part for displaying page content in page.php
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package WordPress
 * @subpackage Twenty_Twenty_One
 * @since Twenty Twenty-One 1.0
 */
global $post;
if ($post->post_parent){
	$ancestors=get_post_ancestors($post->ID);
	$root=count($ancestors)-1;
	$parent=$ancestors[$root];
} else {
	$parent = $post->ID;
	$ancestors=array();

}
$ancestors = array_reverse($ancestors);

?>

<section class="base-banner">
  <div class="container">
    <div class="row">
      <?php $backgroundImg = wp_get_attachment_image_src( get_post_thumbnail_id($post->ID), 'full' ); ?>
      <?php if ($backgroundImg) : ?>
        <div class="base-banner--imgbox col-sm-12 col-lg-12 page-heading--has-image" style="background: url('<?php echo $backgroundImg[0]; ?>') no-repeat; ">
          <picture></picture>
      <?php else: ?>
        <div class="base-banner--imgbox col-sm-12 col-lg-12 " >
      <?php endif; ?>
        <div class="base-banner--imgbox-content">
          <h1 class="base-banner--imgbox-title"><?php echo get_the_title(); ?></h1>
          <ol class="breadcrumbs">
            <li class="breadcrumbs--item root"><a href="<?php echo site_url() ?>" title="Return to homepage"><i class="fa-solid fa-home"></i><span class="sr-only">Home</span></a></li>
            <?php 
              if ( function_exists('yoast_breadcrumb') ) {
                yoast_breadcrumb( '<li class="breadcrumbs--item ">' ,'</li> ' );
              }
            ?>
          </ol>
        </div>
      </div>
    </div>
  </div>
</section>

<article class="base">
  <div class="container">
    <div class="row">
      <section class="blog-post rte col-sm-12 col-lg-12 ">
        <?php include('template-parts/district-info.php'); ?>
        <?php
          // Find connected pages
          $connected = new WP_Query( array(
            'connected_type' => 'posts_to_pages',
            'connected_items' => get_queried_object(),
            'nopaging' => true,
          ) );

          // Display connected pages
          if ( $connected->have_posts() ) :
          ?>
          <h2>Schools</h2>
          <div class='row'>
            <?php while ( $connected->have_posts() ) : $connected->the_post(); ?>
              <?php include('template-parts/school-info.php') ?>
            <?php endwhile; ?>
          </div>

          <?php 
          // Prevent weirdness
          wp_reset_postdata();

          endif;
          ?>
        <footer class='blog-post--footer'>
          <div></div>
          <a href='<?php echo site_url('about/school-directory') ?>' class='blog-post--return'>All Districts</a>
        </footer>
      </section>
    </div>
  </div>
</article>