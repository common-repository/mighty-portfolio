<?php

if ( ! defined( 'ABSPATH' ) ) exit;

if ( ! defined( 'CTFMB_PATH' ) || ! defined( 'CTFMB_URL' ) ){
    return;
}

if ( ! class_exists('CTFMB') ) {
    

    class CTFMB
    {
    
        /**
         * @var         CTFMB $instance The one true CTFMB
         * @since       1.0.0
         */
        private static $instance;


        /**
         * Get active instance
         *
         * @access      public
         * @since       1.0.0
         * @return      object self::$instance The one true CTFMB
         */
        public static function instance() {
            if( !self::$instance ) {
                self::$instance = new CTFMB();
                self::$instance->includes();

                do_action( 'ctf_add_metabox' );
            }

            return self::$instance;
        }

        private function includes() {
            require_once CTFMB_PATH .'/cantometabox.addon.class.php';
        }
    }
}

if(!function_exists('CTF_MetaBox_Register_Addon')){
	function CTF_MetaBox_Register_Addon() {
		if( class_exists( 'CTF_Init' ) ) {
			return CTFMB::instance();
		}
	}
	
	add_action( 'plugins_loaded', 'CTF_MetaBox_Register_Addon' );
}
