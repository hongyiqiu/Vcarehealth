<?php
/**
 * Active callback functions.
 *
 * @package Wisdom Academy
 */

function wisdom_academy_featured_slider_active( $control ) {
    if( $control->manager->get_setting( 'theme_options[enable_featured_slider_section]' )->value() == true ) {
        return true;
    }else{
        return false;
    }
}

function wisdom_academy_featured_slider_page( $control ) {
    $content_type = $control->manager->get_setting( 'theme_options[featured_slider_content_type]' )->value();
    return ( wisdom_academy_featured_slider_active( $control ) && ( 'featured_slider_page' == $content_type ) );
}

function wisdom_academy_featured_slider_post( $control ) {
    $content_type = $control->manager->get_setting( 'theme_options[featured_slider_content_type]' )->value();
    return ( wisdom_academy_featured_slider_active( $control ) && ( 'featured_slider_post' == $content_type ) );
}


function wisdom_academy_featured_services_active( $control ) {
    if( $control->manager->get_setting( 'theme_options[enable_featured_services_section]' )->value() == true ) {
        return true;
    }else{
        return false;
    }
}

function wisdom_academy_featured_services_page( $control ) {
    $content_type = $control->manager->get_setting( 'theme_options[featured_services_content_type]' )->value();
    return ( wisdom_academy_featured_services_active( $control ) && ( 'featured_services_page' == $content_type ) );
}

function wisdom_academy_featured_services_post( $control ) {
    $content_type = $control->manager->get_setting( 'theme_options[featured_services_content_type]' )->value();
    return ( wisdom_academy_featured_services_active( $control ) && ( 'featured_services_post' == $content_type ) );
}

function wisdom_academy_featured_classes_active( $control ) {
    if( $control->manager->get_setting( 'theme_options[enable_featured_classes_section]' )->value() == true ) {
        return true;
    }else{
        return false;
    }
}

function wisdom_academy_featured_classes_page( $control ) {
    $content_type = $control->manager->get_setting( 'theme_options[featured_classes_content_type]' )->value();
    return ( wisdom_academy_featured_classes_active( $control ) && ( 'featured_classes_page' == $content_type ) );
}

function wisdom_academy_featured_classes_post( $control ) {
    $content_type = $control->manager->get_setting( 'theme_options[featured_classes_content_type]' )->value();
    return ( wisdom_academy_featured_classes_active( $control ) && ( 'featured_classes_post' == $content_type ) );
}

function wisdom_academy_featured_gallery_active( $control ) {
    if( $control->manager->get_setting( 'theme_options[enable_featured_gallery_section]' )->value() == true ) {
        return true;
    }else{
        return false;
    }
}

function wisdom_academy_featured_gallery_page( $control ) {
    $content_type = $control->manager->get_setting( 'theme_options[featured_gallery_content_type]' )->value();
    return ( wisdom_academy_featured_gallery_active( $control ) && ( 'featured_gallery_page' == $content_type ) );
}

function wisdom_academy_featured_gallery_post( $control ) {
    $content_type = $control->manager->get_setting( 'theme_options[featured_gallery_content_type]' )->value();
    return ( wisdom_academy_featured_gallery_active( $control ) && ( 'featured_gallery_post' == $content_type ) );
}

function wisdom_academy_featured_team_active( $control ) {
    if( $control->manager->get_setting( 'theme_options[enable_featured_team_section]' )->value() == true ) {
        return true;
    }else{
        return false;
    }
}

function wisdom_academy_featured_team_page( $control ) {
    $content_type = $control->manager->get_setting( 'theme_options[featured_team_content_type]' )->value();
    return ( wisdom_academy_featured_team_active( $control ) && ( 'featured_team_page' == $content_type ) );
}

function wisdom_academy_featured_team_post( $control ) {
    $content_type = $control->manager->get_setting( 'theme_options[featured_team_content_type]' )->value();
    return ( wisdom_academy_featured_team_active( $control ) && ( 'featured_team_post' == $content_type ) );
}

function wisdom_academy_featured_posts_active( $control ) {
    if( $control->manager->get_setting( 'theme_options[enable_featured_posts_section]' )->value() == true ) {
        return true;
    }else{
        return false;
    }
}

/**
 * Active Callback for top bar section
 */
function wisdom_academy_contact_info_ac( $control ) {

    $show_contact_info = $control->manager->get_setting( 'theme_options[show_header_contact_info]')->value();
    $control_id        = $control->id;
         
    if ( $control_id == 'theme_options[header_location]' && $show_contact_info ) return true;
    if ( $control_id == 'theme_options[header_email]' && $show_contact_info ) return true;
    if ( $control_id == 'theme_options[header_phone]' && $show_contact_info ) return true;

    return false;
}

function wisdom_academy_social_links_active( $control ) {
    if( $control->manager->get_setting( 'theme_options[show_header_social_links]' )->value() == true ) {
        return true;
    }else{
        return false;
    }
}