<?php


function wpestate_comment_columns( $columns ){
    
    $columns['is_review']   = esc_html__( 'Is Review','wprentals' );
    $columns['review_stars'] = esc_html__( 'Stars','wprentals' );
    return $columns;

    
}
add_filter( 'manage_edit-comments_columns', 'wpestate_comment_columns' );


function wpestate_comment_column( $column, $comment_ID ){
    $stars =  get_comment_meta( $comment_ID , 'review_stars', true );
  
    if ( 'is_review' == $column ) {
        if($stars==''){
            echo esc_html__('no','wprentals');
        }else{
            echo esc_html__('yes','wprentals');
        }
    }
    if ( 'review_stars' == $column ) {
        if(trim($stars)!=''){
	        $total_stars_raw = get_comment_meta( $comment_ID , 'review_stars', true );
	        $total_stars = wpestate_get_star_total_rating($total_stars_raw);
                print  floatval($total_stars ).' '.esc_html__('stars','wprentals');
        }else{
            echo '-';
        }
        
    }
    
}
add_filter( 'manage_comments_custom_column', 'wpestate_comment_column', 10, 2 );



//add_filter( 'manage_edit-comments_sortable_columns', 'wpestate_sort_me_comments' );
if( !function_exists('wpestate_sort_me_comments') ):
function wpestate_sort_me_comments( $columns ) {

    $columns['review_stars']        = 'review_stars';
    $columns['is_review']       = 'is_review';
 
    return $columns;
}
endif; // end   wpestate_sort_me 




//add_filter( 'request', 'wpestate_comments_column_orderby' );
function wpestate_comments_column_orderby( $vars ) {
  
   
    if ( isset( $vars['orderby'] ) && 'review_stars' == $vars['orderby'] ) {
        $vars = array_merge( $vars, array(
            'meta_key' => 'review_stars',
            'orderby' => 'meta_value'
        ) );
    }
    if ( isset( $vars['orderby'] ) && 'is_review' == $vars['orderby'] ) {
        $vars = array_merge( $vars, array(
            'meta_key' => 'is_review',
            'orderby' => 'meta_value'
        ) );
    }


    return $vars;
}
