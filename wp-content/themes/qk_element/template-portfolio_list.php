<?php 
/*
*Template Name: Portfolio List Style
*/
?>
<?php get_header(); ?>
<?php global $wp_query;?>
		<!-- content 
			================================================== -->
		<div id="content">

			<?php if(get_post_meta($wp_query->get_queried_object_id(), '_cmb_page_breadcrumb', true)!="yes"){ ?>
			<!-- page-banner-section
				================================================== -->
			<div class="section-content page-banner-section">
				<div class="container">
					<h1><?php single_post_title(); ?></h1>
					<?php element_breadcrumb(); ?>
				</div>
			</div>
			<?php } ?>
			<!-- portfolio-page
				================================================== -->
			<div class="section-content portfolio-page list-page">
				<div class="container">
					<div class="row">

						<?php
							global $wp_query; 
							if(get_post_meta($wp_query->get_queried_object_id(), '_cmb_page_fullwidth', true)=="yes"){
								$page_class="col-md-12";
							}else{
								$page_class="col-md-9";
							}
						?>
						<?php 
							if(get_post_meta($wp_query->get_queried_object_id(), '_cmb_page_fullwidth', true)!="yes" and get_post_meta($wp_query->get_queried_object_id(), '_cmb_sidebar_position', true)=="left"){
								$page_class .=' pull-right';
							}
						?>
						<div class="main-page <?php echo esc_attr($page_class); ?>">
							<ul class="filter">
								<li><a class="active" href="#" data-filter="*"><?php _e('All','element'); ?></a></li>
								<?php $portfolio_skills = get_terms('portfolio_category'); ?>
								<?php foreach($portfolio_skills as $portfolio_skill) { ?>
								<li><a href="#" data-filter=".<?php echo esc_attr($portfolio_skill->slug); ?>"><?php echo esc_html($portfolio_skill->name); ?></a></li>
								<?php } ?>
							</ul>
							<div class="portfolio-box masonry <?php if(get_post_meta($wp_query->get_queried_object_id(), '_cmb_page_fullwidth', true)!="yes"){ ?> with-sidebar <?php } ?>">
								<?php if(is_front_page()) {
									$paged = (get_query_var('page')) ? get_query_var('page') : 1;
									} else {
										$paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
									}
									$args = array(
										'post_type' => 'portfolio',
										'paged' => $paged,
										'posts_per_page' => 4,
									);
									$portfolio = new WP_Query($args);
									
									if($portfolio->have_posts()) : while($portfolio->have_posts()) : $portfolio->the_post(); ?>
								<?php
									$item_classes = '';
									$item_skill = '';
									$item_cats = get_the_terms(get_the_ID(), 'portfolio_category');
									foreach((array)$item_cats as $item_cat){
										if(count($item_cat)>0){
											$item_classes .= $item_cat->slug . ' ';
											$item_skill .= $item_cat->name . ' | ';
										}
									}
								?>
								<?php
									$img = element_thumbnail_url('');
								?>
								<div class="work-post <?php echo esc_attr($item_classes); ?>">
									<div class="work-gal">
									<?php if(get_post_meta($wp_query->get_queried_object_id(), '_cmb_page_fullwidth', true)=="yes"){ ?>
										<img src="<?php echo esc_attr(bfi_thumb($img, array('width'=>770, 'height'=> 361))); ?>" alt="<?php the_title(); ?>">
									<?php }else{ ?>
										<img src="<?php echo esc_attr(bfi_thumb($img, array('width'=>450, 'height'=> 353))); ?>" alt="<?php the_title(); ?>">
									<?php } ?>
										<div class="hover-box">
											<a class="zoom" href="<?php echo esc_attr($img); ?>"><i class="fa fa-search"></i></a>				
										</div>
									</div>
									<div class="work-content">
										<h2><?php the_title(); ?></h2>
										<span><?php the_time('d F, Y'); ?></span>
										<p><?php echo do_shortcode(element_excerpt($limit=40)); ?></p>
										<a href="<?php the_permalink(); ?>"><?php _e('Details','element'); ?> <i class="fa fa-angle-right"></i></a>
									</div>
								</div>
							<?php endwhile; endif; ?>	

							</div>

							<?php element_pagination($prev = '<i class="fa fa-angle-left"></i>', $next = '<i class="fa fa-angle-right"></i>', $pages=$portfolio->max_num_pages); ?>
						</div>

						<?php if(get_post_meta($wp_query->get_queried_object_id(), '_cmb_page_fullwidth', true)!="yes"){ ?>
						<div class="col-md-3">
							<?php get_sidebar(); ?>
						</div>
						<?php } ?>

					</div>

				</div>
			</div>

		</div>
		<!-- End content -->
<?php get_footer(); ?>