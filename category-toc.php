<?php
/**
 * Plugin Name: Category TOC
 * Plugin URI: http://buddydev.com/plugins/category-toc/
 * Version: 1.0
 * Author: Brajesh Singh
 * Author URI: http://buddydev.com/members/sbrajesh/
 * Description: Generates table of Content from a category
 */
/**
 * Helper Class for generating toc
 */
class Category_TOC_Helper{
    
    private static $instanace;
    
    private function __construct() {
        
        
        add_shortcode( 'category_toc', array( $this, 'generate_toc' ) );
    }
    
    /**
     *
     * @return Category_TOC_Helper 
     */
    public static function get_instance(){
        
        if( !isset ( self::$instanace ) )
                self::$instanace = new self();
        
        return self::$instanace;
        
    }
    
    
    public function generate_toc( $atts, $content = null ){
        
        $atts = shortcode_atts(
                array(
                    'term'  => '',
                    'term_id'   => 0,
                    'max'=> -1,
                    'taxonomy'=>'category',
                    'wrapper'=>'ol'
                    
                    
                    
                    
                ), $atts);
        extract($atts);
        
        if(!$term_id && !$term ){
            
            $terms = get_the_terms(get_the_ID(), $taxonomy);
            
            $terms = array_values( $terms );
            
            $term_id = $terms[0]->term_id;
            
        }
        
       
        if( !$term_id && $term ){
            
            $term_obj = get_term_by( 'slug', $term, $taxonomy);
            
            if(!is_wp_error( $term_obj ) )
                $term_id = $term_obj->term_id;
        }
        
        if( !$term_id )
            return ;
        
        //list the posts
        
        
        $tax_query = array(
            
            'tax_query'=> array(
                array(
                    'taxonomy'=>$taxonomy,
                    'field'=>'id',
                    'terms'=> array(0=>$term_id)
                )
            ),
           'posts_per_page'=>$max
        );
        
        
        
        
        $wpq = new WP_Query( $tax_query );
        $html = '';
        
        if( $wpq->have_posts() ){
         
            $html ="<$wrapper>";
            while( $wpq->have_posts() ){
             
                $wpq->the_post();   
            
                $html .= "<li><a href='". get_permalink (). "'>". get_the_title (). "</a></li>";
        
            }
          $html .= "</$wrapper>"  ;
        }   
        wp_reset_postdata();

            return $html;
        
        }
    

}

Category_TOC_Helper::get_instance();