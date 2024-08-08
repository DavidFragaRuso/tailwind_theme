<?php
/**
 * WP Customizer API example
 * https://raddy.co.uk/blog/wordpress-customizer-api-editable-sections-theme-development/
 */

 class Tailwind_Theme_Customizer {
    public function __construct() {
        add_action( 'customize_register', array( $this, 'register_customize_sections' ) );  
    }

    public function register_customize_sections( $wp_customize ) {
        /**
         * Add section for customize theme colors 
         */
        $this->colors_callout_section( $wp_customize );
        /*
        * Add Section for Social Networks data.
        */
        //$this->sn_callout_section( $wp_customize );
        /**
         * Add Organization Data for Schema
         */
        //$this->organization_callout_section( $wp_customize );
    }

    /**
     * Sanitize inputs (working examples)
     */
    public function sanitize_custom_option($input) {
        return ( $input === "No" ) ? "No" : "Yes";
    }
    //Deprecated
    //public function sanitize_custom_text($input) {
        //return filter_var($input, FILTER_SANITIZE_STRING);
    //}
    public function sanitize_custom_url($input) {
        return filter_var($input, FILTER_SANITIZE_URL);
    }
    public function sanitize_custom_email($input) {
        return filter_var($input, FILTER_SANITIZE_EMAIL);
    }
    public function sanitize_hex_color( $color ) {
        if ( '' === $color ) {
            return '';
        } 
        // 3 or 6 hex digits, or the empty string.
        if ( preg_match( '|^#([A-Fa-f0-9]{3}){1,2}$|', $color ) ) {
            return $color;
        }
    }

    private function colors_callout_section( $wp_customize ) {
        $wp_customize->add_section('theme-colors-callout-section', array(
            'title' => __(esc_html('Theme Colors', 'tailtheme')),
            //'priority' => 180,
            'description' => __('Choose your theme colors.', 'tailtheme'),
        ));

        //color
        $wp_customize->add_setting('primary-color-callout-display', array(
            'default' => '#ffffff',
            'sanitize_callback' => array( $this, 'sanitize_hex_color' )
        ));
        $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'primary-color-callout-display', array(
            'label' => __(esc_html('Primary color', 'tailtheme')),
            'section' => 'theme-colors-callout-section',
            'settings' => 'primary-color-callout-display',
            //'type' => 'text'
        )));
    }
 }