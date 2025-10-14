<?php
/**
 * Template Name: NewsDetail
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package WordPress
 * @subpackage Twenty_Twenty_One
 * @since Twenty Twenty-One 1.0
 */

?>
	
<section id="cr-directory" class="directory">
	<div class="container">
			<div class="row">
				<div class="school-directory--filter col-sm-12 col-lg-4 d-print-none">
					<div class="directory--filter-wrap">
						<form id="school-directory--filter-form">
							<div class="directory--filter-form select">
								<label for="school_district_city">City</label>
								<select id="school_district_city" name="school_district_city">
									<option value="">All Cities</option>
								</select>
							</div>

							<div class="directory--filter-form select">
								<label for="school_district_name">School District</label>
								<select id="school_district_name" name="school_district_name">
									<option value="">All Districts</option>
								</select>
							</div>

							<div class="directory--filter-form" >
								<label for="school_district_superintendent">Superintendent</label>
								<input type='text' id='school_district_superintendent' />
							</div>

							<div class="directory--filter-button">
								<button type="reset" class="btn btn-primary school-directory--reset-search" >Reset Search</button>
							</div>
						</form>				
					</div>
					<div class='school-directory--link-update'>
						<a href='<?php echo site_url('update-your-district-school-information') ?>' >Update your disrict/school information</a>
					</div>	
				</div><!-- end dir filter-->
				<div class="directory--content col-sm-12 col-lg-8">
					<ul class="school-directory--list">

					</ul>
				</div><!-- end content-->
			</div><!-- end row-->
		</div><!-- end container-->
</section>