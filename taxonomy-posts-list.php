<?php
/**
 * Plugin Name: Taxonomy Posts List
 * Plugin URI: https://buddydev.com/plugins/taxonomy-posts-list/
 * Version: 1.0.1
 * Author: BuddyDev
 * Author URI: https://buddydev.com/
 * Description: Generates List of posts for a particular term/post type
 */

/**
 * Helper Class for generating toc
 */
class BPDev_Taxonomy_Posts_List_Helper {

	private static $instance;

	private function __construct() {
		//use any of the three shortcodes, each have same purpose
		//our suggestion, use taxonomy-posts-list, other aliases are for backward compatibility
		add_shortcode( 'category_toc', array( $this, 'generate_toc' ) );
		add_shortcode( 'term_toc', array( $this, 'generate_toc' ) );
		add_shortcode( 'taxonomy-posts-list', array( $this, 'generate_toc' ) );
	}

	/**
	 *
	 * @return BPDev_Taxonomy_Posts_List_Helper
	 */
	public static function get_instance() {

		if ( ! isset ( self::$instance ) ) {
			self::$instance = new self();
		}

		return self::$instance;
	}

	public function generate_toc( $atts, $content = null ) {

		$atts = shortcode_atts(
			array(
				'term'        => '',
				'term_id'     => 0,
				'max'         => - 1,
				'taxonomy'    => 'category',//default taxonomy is category
				'wrapper'     => 'ol',
				'post_type'   => '',
				'post_status' => 'publish'
			), $atts

		);

		extract( $atts );

		if ( in_the_loop() && ! $post_type ) {
			$post_type = get_post_type( get_the_ID() );

			//if we are using it inside page, and post type is not given, we won't use any post type
			if ( $post_type == 'page' ) {
				$post_type = '';
			}
		}

		//reset post status to inherit for attachment
		if ( $post_type == 'attachment' ) {
			$post_status = 'inherit';
		}

		//if post type is not attachment, and the term_id and term is not given, then we will get it from the current post
		if ( ! $term_id && ! $term && $post_type != 'attachment' ) {
			$terms   = get_the_terms( get_the_ID(), $taxonomy );

			if ( ! empty( $terms )  && ! is_wp_error( $terms ) ) {
				$terms   = array_values( $terms );
				$term_id = $terms[0]->term_id;
			}
		}

		if ( ! $term_id && $term ) {
			$term_obj = get_term_by( 'slug', $term, $taxonomy );

			if ( ! is_wp_error( $term_obj ) ) {
				$term_id = $term_obj->term_id;
			}
		}

		//if neither term not post type is given, return
		if ( ! $term_id && ! $post_type ) {
			return;
		}

		//list the posts
		//let us prepare query
		$query = array();

		$query['posts_per_page'] = $max;//how many

		if ( $term_id ) {
			$query['tax_query'] = array(
				array(
					'taxonomy' => $taxonomy,
					'field'    => 'id',
					'terms'    => array( 0 => $term_id )
				)
			);
		}

		//if post type is given
		if ( $post_type ) {
			$query['post_type'] = $post_type;
		}

		if ( $post_status ) {
			$query['post_status'] = $post_status;
		}

		$wpq  = new WP_Query( $query );
		$html = '';

		if ( $wpq->have_posts() ) {
			$html = "<$wrapper>";

			while ( $wpq->have_posts() ) {
				$wpq->the_post();
				$html .= "<li><a href='" . get_permalink() . "'>" . get_the_title() . "</a></li>";
			}

			$html .= "</$wrapper>";
		}

		wp_reset_postdata();

		return $html;
	}
}

BPDev_Taxonomy_Posts_List_Helper::get_instance();