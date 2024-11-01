<?php

class JobListings {
	private static $initiated = false;
	private static $caps = array( 
		'edit_job' => true, 
		'edit_jobs' => true,  
		'edit_private_jobs' => true,  
		'edit_published_jobs' => true,  
		'edit_others_jobs' => true,  
		'read_job' => true, 
		'publish_jobs' => true,
		'delete_job' => true,
		'delete_jobs' => true,
		'delete_published_jobs' => true,
		'delete_private_jobs' => true,
		'delete_others_jobs' => true,
		'read_private_jobs' => true,
	);

	private static $allowed_sorts = array( 'title', 'date', 'modified', 'rand' );

	public static function init(){
		if ( ! self::$initiated ) {
			self::doInit();
		}
	}

	public static function doInit(){
		$labels = array(
			'name'               => _x( 'Jobs', 'post type general name', 'joblistings' ),
			'singular_name'      => _x( 'Job', 'post type singular name', 'joblistings' ),
			'menu_name'          => _x( 'Jobs', 'admin menu', 'joblistings' ),
			'name_admin_bar'     => _x( 'Job', 'add new on admin bar', 'joblistings' ),
			'add_new'            => __( 'Add New', 'job', 'joblistings' ),
			'add_new_item'       => __( 'Post New Job', 'joblistings' ),
			'new_item'           => __( 'New Job', 'joblistings' ),
			'edit_item'          => __( 'Update Job', 'joblistings' ),
			'view_item'          => __( 'View Job', 'joblistings' ),
			'all_items'          => __( 'All Jobs', 'joblistings' ),
			'search_items'       => __( 'Search Jobs', 'joblistings' ),
			'parent_item_colon'  => __( 'Parent Jobs:', 'joblistings' ),
			'not_found'          => __( 'No jobs found.', 'joblistings' ),
			'not_found_in_trash' => __( 'No jobs found in Trash.', 'joblistings' )
		);

		$args = array(
			'labels'             => $labels,
			'public'             => false,
			'publicly_queryable' => false,
			'show_ui'            => true,
			'show_in_menu'       => true,
			'query_var'          => true,
			'capability_type'    => 'job',
			'has_archive'        => false,
			'hierarchical'       => false,
			'map_meta_cap'       => true,
			'supports'           => array( 'title', 'editor' )
		);

		register_post_type( 'job', $args );

		add_shortcode( 'jobs', array( 'JobListings', 'do_shortcode' ) );
		
		self::$initiated = true;
	}

	public static function activate_plugin(){
		self::doInit();
		flush_rewrite_rules();
		add_role( 
			'jobs_manager', 
			'Jobs Manager', 
			array_merge( self::$caps, array('read' => true, 'level_0' => true ) )
		);
	}

	public static function deactivate_plugin(){
		remove_role('jobs_manager');
	}
	
	public static function add_perms( $wp_caps ){
		if ( !empty( $wp_caps['edit_pages'] ) ) {
			$wp_caps = array_merge( $wp_caps, self::$caps );
		}
		return $wp_caps;
	}

	public static function do_shortcode( $atts ){
		$a = shortcode_atts( array(
			'order'     => 'title',
			'show_date' => false,
		), $atts );

		if( !in_array( $a['order'], apply_filters( 'jobslistings_frontend_allowed_sorts' , self::$allowed_sorts ) ) ){
			$a['order'] = 'title';
		}

		$args = array(
			'posts_per_page'   => 100,
			'offset'           => 0,
			'category'         => '',
			'category_name'    => '',
			'orderby'          => $a['order'],
			'order'            => 'ASC',
			'include'          => '',
			'exclude'          => '',
			'meta_key'         => '',
			'meta_value'       => '',
			'post_type'        => 'job',
			'post_mime_type'   => '',
			'post_parent'      => '',
			'author'           => '',
			'post_status'      => 'publish',
			'suppress_filters' => true,
		);

		$jobs = get_posts( $args );

		ob_start();

		echo "<div class='jobs-list'>";

		if ( $jobs ) {
			foreach ( $jobs as $job ) {
				setup_postdata( $job );
				$publish_date = "<span class='job-published'>Published: <span class='entry-date published'>" . get_the_date() . "</span></span>";

				echo "<div class='job-posting'>";
				echo "<h3>" . get_the_title( $job->ID ) . "</h3>";
				the_content();
				
				if( bool_from_yn( $a['show_date'] ) ){
					echo apply_filters( "joblistings_published_date", $publish_date, get_the_date() );
				}

				echo "</div>";
				wp_reset_postdata();
			}
		} else {
			printf( "<span class='no-jobs'>%s</span>", __( "No jobs are currently posted.", "joblistings" ) );
		}

		echo "</div>";

		$joblist = ob_get_contents();

		ob_end_clean();

		return $joblist;
	}
}