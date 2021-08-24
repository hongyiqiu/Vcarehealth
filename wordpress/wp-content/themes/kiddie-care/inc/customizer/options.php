<?php 
/**
 * List of posts for post choices.
 * @return Array Array of post ids and name.
 */
function kiddie_care_post_choices() {
    $posts = get_posts( array( 'numberposts' => -1 ) );
    $choices = array();
    $choices[0] = esc_html__( '--Select--', 'kiddie-care' );
    foreach ( $posts as $post ) {
        $choices[ $post->ID ] = $post->post_title;
    }
    return  $choices;
}

if ( ! function_exists( 'kiddie_care_switch_options' ) ) :
    /**
     * List of custom Switch Control options
     * @return array List of switch control options.
     */
    function kiddie_care_switch_options() {
        $arr = array(
            'on'        => esc_html__( 'On', 'kiddie-care' ),
            'off'       => esc_html__( 'Off', 'kiddie-care' )
        );
        return apply_filters( 'kiddie_care_switch_options', $arr );
    }
endif;


 /**
 * Get an array of google fonts.
 * 
 */
function kiddie_care_font_choices() {
    $font_family_arr = array();
    $font_family_arr[''] = esc_html__( '--Default--', 'kiddie-care' );

    // Make the request
    $request = wp_remote_get( get_theme_file_uri( 'assets/fonts/webfonts.json' ) );

    if( is_wp_error( $request ) ) {
        return false; // Bail early
    }
    // Retrieve the data
    $body = wp_remote_retrieve_body( $request );
    $data = json_decode( $body );
    if ( ! empty( $data ) ) {
        foreach ( $data->items as $items => $fonts ) {
            $family_str_arr = explode( ' ', $fonts->family );
            $family_value = implode( '-', array_map( 'strtolower', $family_str_arr ) );
            $font_family_arr[ $family_value ] = $fonts->family;
        }
    }

    return apply_filters( 'kiddie_care_font_choices', $font_family_arr );
}



 ?>