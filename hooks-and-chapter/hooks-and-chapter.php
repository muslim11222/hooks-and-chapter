<?php 

/*

* Plugin Name: Hooks And Chapte
* description: this is my plugin description
* author: Muslim khan

*/

class hooks_and_chapter{
     function  __construct(){
      add_action('init', array($this, 'init'));
      // add_action( 'init', array($this,'cptui_register_my_cpts_book' ));
     }

     function init(){
        add_filter('the_content', [$this, 'show_chapter_book']);
        add_filter('the_content', [$this,'show_book_chapter']);
        add_filter('post_type_link', [$this,'post_type_link'],1, 2);
     }


    //  slug
     function post_type_link($post_link, $chapter) {
        if(get_post_type($chapter)=='chapter') {
            $book_id = get_post_meta($chapter->ID, 'book', true);
            $book = get_post($book_id);
            $post_link = str_replace('%book%', $book->post_name, $post_link);
        }
        return $post_link;
     }


     function show_book_chapter($content) {
        if(is_singular('chapter')) {
            $chapter_id = get_the_ID();
            $book_id = get_post_meta($chapter_id, 'book', true);
            $book = get_post($book_id);
            $image = get_the_post_thumbnail($book_id, 'medium');
            $image_html = '<p><a href="' .get_permalink($book_id) . '">' . $image . '</a></p>';
            $content = $image_html . $content;
        }
            return $content;
     }


        public function show_chapter_book($content) {
            if(is_singular('book')) {
              $book_id = get_the_ID();
              $heading = "<h2>Chapters</h2>";
              $content = $content . $heading;
      
                $args = array(
                  'post_type' => 'chapter',

                  'meta_query' => [

                    [
                        'key' => 'book',
                        'value' => $book_id,
                        'compare' => '='
                    ]
                  ],

                  'meta_key' => 'chapter_number',
                  'orderby' => 'meta_value_num',
                  'orderby' => 'title',
                  'order' => 'ASC' 
                );
      
              $chapters = get_posts($args);
              $content .= '<ul>';
              foreach ($chapters as $chapter) {
                  $content .= '<li><a href="' . get_permalink($chapter->ID) . '">' . $chapter->post_title . '</a></li>';
              }
              $content .= '</ul>'; 
      
            }
          return $content;
        }
      

     // function cptui_register_my_cpts_book() {

     //      /**
     //       * Post Type: books.
     //       */
     
     //      $labels = [
     //           "name" => esc_html__( "books", "twentytwentyfour" ),
     //           "singular_name" => esc_html__( "book", "twentytwentyfour" ),
     //           "add_new" => esc_html__( "add new books", "twentytwentyfour" ),
     //      ];
     
     //      $args = [
     //           "label" => esc_html__( "books", "twentytwentyfour" ),
     //           "labels" => $labels,
     //           "description" => "",
     //           "public" => true,
     //           "publicly_queryable" => true,
     //           "show_ui" => true,
     //           "show_in_rest" => true,
     //           "rest_base" => "",
     //           "rest_controller_class" => "WP_REST_Posts_Controller",
     //           "rest_namespace" => "wp/v2",
     //           "has_archive" => false,
     //           "show_in_menu" => true,
     //           "show_in_nav_menus" => true,
     //           "delete_with_user" => false,
     //           "exclude_from_search" => false,
     //           "capability_type" => "post",
     //           "map_meta_cap" => true,
     //           "hierarchical" => false,
     //           "can_export" => false,
     //           "rewrite" => [ "slug" => "book", "with_front" => true ],
     //           "query_var" => true,
     //           "supports" => [ "title", "editor", "thumbnail" ],
     //           "show_in_graphql" => false,
     //      ];
     
     //      register_post_type( "book", $args );
     // }
     
     
     
}

new hooks_and_chapter();



