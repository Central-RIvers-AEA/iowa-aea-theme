<?php /* Template Name: School Directory */ 

get_header();

/* Start the Loop */
while ( have_posts() ) :
	the_post();
	include('content/school-directory-page-content.php' );

endwhile; // End of the loop.


get_footer();
?>