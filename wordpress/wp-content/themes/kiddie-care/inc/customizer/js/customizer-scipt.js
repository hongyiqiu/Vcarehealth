
( function( $, api ) {

	    // upsell 
    api.sectionConstructor['kiddie-care-upsell'] = api.Section.extend( {
        // No events for this type of section.
        attachEvents: function () {},
        // Always make the section active.
        isContextuallyActive: function () {
            return true;
        }
    } );
    
} )( jQuery, wp.customize );
/**
* Custom Js for image select in customizer
*
* @package kiddie-care
*/
 jQuery(document).ready(function($) {
    // $('#kiddie-care-img-container li label img').click(function(){    	
    //     $('#kiddie-care-img-container li').each(function(){
    //         $(this).find('img').removeClass ('kiddie-care-radio-img-selected') ;
    //     });
    //     $(this).addClass ('kiddie-care-radio-img-selected') ;
    // }); 

    //Switch Control
    $('body').on('click', '.onoffswitch', function(){
        var $this = $(this);
        if($this.hasClass('switch-on')){
            $(this).removeClass('switch-on');
            $this.next('input').val( false ).trigger('change')
        }else{
            $(this).addClass('switch-on');
            $this.next('input').val( true ).trigger('change')
        }
    });

    $( document ).on( 'click', '.customize_multi_add_field', kiddie_care_customize_multi_add_field )
        .on( 'change', '.customize_multi_single_field', kiddie_care_customize_multi_single_field )
        .on( 'click', '.customize_multi_remove_field', kiddie_care_customize_multi_remove_field )

    /********* Multi Input Custom control ***********/
    $( '.customize_multi_input' ).each(function() {
        var $this = $( this );
        var multi_saved_value = $this.find( '.customize_multi_value_field' ).val();
        if (multi_saved_value.length > 0) {
            var multi_saved_values = multi_saved_value.split( "|" );
            $this.find( '.customize_multi_fields' ).empty();
            var $control = $this.parents( '.customize_multi_input' );
            $.each(multi_saved_values, function( index, value ) {
                $this.find( '.customize_multi_fields' ).append( '<div class="set"><input type="text" value="' + value + '" class="customize_multi_single_field" /><span class="customize_multi_remove_field"><span class="dashicons dashicons-no-alt"></span></span></div>' );
            });
        }
    });
    $('#customize-control-theme_options-layout_options_blog #kiddie-care-img-container li label img').click(function(){      
        $('#customize-control-theme_options-layout_options_blog #kiddie-care-img-container li').each(function(){
            $(this).find('img').removeClass ('kiddie-care-radio-img-selected') ;
        });
        $(this).addClass ('kiddie-care-radio-img-selected') ;
    });  

    $('#customize-control-theme_options-layout_options_archive #kiddie-care-img-container li label img').click(function(){       
        $('#customize-control-theme_options-layout_options_archive #kiddie-care-img-container li').each(function(){
            $(this).find('img').removeClass ('kiddie-care-radio-img-selected') ;
        });
        $(this).addClass ('kiddie-care-radio-img-selected') ;
    });  

    $('#customize-control-theme_options-layout_options_page #kiddie-care-img-container li label img').click(function(){      
        $('#customize-control-theme_options-layout_options_page #kiddie-care-img-container li').each(function(){
            $(this).find('img').removeClass ('kiddie-care-radio-img-selected') ;
        });
        $(this).addClass ('kiddie-care-radio-img-selected') ;
    });  

    $('#customize-control-theme_options-layout_options_single #kiddie-care-img-container li label img').click(function(){        
        $('#customize-control-theme_options-layout_options_single #kiddie-care-img-container li').each(function(){
            $(this).find('img').removeClass ('kiddie-care-radio-img-selected') ;
        });
        $(this).addClass ('kiddie-care-radio-img-selected') ;
    });    

    function kiddie_care_customize_multi_add_field(e) {
        var $this = $( e.currentTarget );
        e.preventDefault();
            var $control = $this.parents( '.customize_multi_input' );
            $control.find( '.customize_multi_fields' ).append( '<div class="set"><input type="text" value="" class="customize_multi_single_field" /><span class="customize_multi_remove_field"><span class="dashicons dashicons-no-alt"></span></span></div>' );
            kiddie_care_customize_multi_write( $control );
    }

    function kiddie_care_customize_multi_single_field() {
        var $control = $( this ).parents( '.customize_multi_input' );
        kiddie_care_customize_multi_write( $control );
    }

    function kiddie_care_customize_multi_remove_field(e) {
        e.preventDefault();
        var $this = $( this );
        var $control = $this.parents( '.customize_multi_input' );
        $this.parent().remove();
        kiddie_care_customize_multi_write( $control );
    }

    function kiddie_care_customize_multi_write( $element) {
        var customize_multi_val = '';
        $element.find( '.customize_multi_fields .customize_multi_single_field' ).each(function() {
            customize_multi_val += $( this ).val() + '|';
        });
        $element.find( '.customize_multi_value_field' ).val( customize_multi_val.slice( 0, -1 ) ).change();
    }       
});                   

