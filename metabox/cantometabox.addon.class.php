<?php

if(!class_exists('CTF_Addon')){
    return;
}
 
class CantoMetabox extends CTF_Addon{


    function __construct(){
        parent::__construct();

        $this->include_files();
        
        $this->add_js_tmlp_to_admin_footer();

        
    }
    
    public function print_window_js_var (){
        parent::print_window_js_var();
        ?>
        <script type="text/javascript">
            window.ctfmb_opts = {};
            window.ctfmb_values = {};
    	</script>
        <?php
    }
    
    function load_admin_js(){
        parent::load_admin_js();
        wp_enqueue_script( 'ctf-metabox', CTFMB_URL . 'assets/js/metabox.js', array('jquery', 'underscore', 'ctf-core-script'), '1.0', true );
    }

    private function include_files()
    {
    	require_once CTFMB_PATH .'register.metabox.class.php';
    }


    public static function add_metabox( $metabox = array() )
    {
    	if (!count($metabox) && empty($metabox)) {
    		return;
    	}
    	$metabox_obj = new CTF_RMB($metabox);

    	return $metabox_obj;
    }


    
}

$ctf_metabox = new CantoMetabox();