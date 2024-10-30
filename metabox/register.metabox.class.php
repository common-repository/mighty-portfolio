<?php
/**
* 
*/
class CTF_RMB
{

    private $metabox = array();
	private $_metabox_nonce = '';
    private $dimension_ids = array();
    private $image_ids = array();
    private $image_multi_ids = array();
    private $google_font_ids = array();
	
	function __construct( $metabox )
	{
		$this->metabox = $metabox;
        $this->_metabox_nonce = $metabox['id'].'_nonce';

        $this->set_dimension_input_ids( $metabox['options'] );
        
        $this->set_image_input_ids( $metabox['options'] );
        
        $this->set_multi_image_input_ids( $metabox['options'] );
        
        $this->set_google_font_input_ids( $metabox['options'] );


		add_action( 'add_meta_boxes', array($this, 'ctf_register_metabox') );
		add_action( 'save_post', array($this, 'ctf_save_metabox_data') );
	}

	public function ctf_register_metabox()
    {
    	add_meta_box( $this->metabox['id'], $this->metabox['title'], array($this,'ctf_cantometabox_callback'), $this->metabox['post_type'] );
    }

    public function ctf_cantometabox_callback( $post )
    {
    	if (isset($this->metabox['options']) && !empty($this->metabox['options'])){

            wp_nonce_field( $this->_metabox_nonce.'_box', $this->_metabox_nonce );

            $values = get_post_meta( $post->ID, $this->metabox['id'], true );
    		?>
    		<div class="ctf-mb_container ctf-fc" id="ctf-metabox-<?php echo $this->metabox['id']; ?>" data-saved="<?php echo ($this->is_saved() ? 1 : 0); ?>"></div>
    		<script type="text/javascript">
                window.ctfmb_opts['<?php echo $this->metabox['id']; ?>'] = <?php echo json_encode($this->metabox['options']); ?>;
    			window.ctfmb_values['<?php echo $this->metabox['id']; ?>'] = <?php echo json_encode($values); ?>;
    		</script>
    		<?php
    	}
    }
    
    function ctf_save_metabox_data( $post_id ) {

        // Check if our nonce is set.
        if ( ! isset( $_POST[$this->_metabox_nonce] ) ) {
            return $post_id;
        }

        $nonce = $_POST[$this->_metabox_nonce];

        // Verify that the nonce is valid.
        if ( ! wp_verify_nonce( $nonce, $this->_metabox_nonce.'_box' ) ) {
            return $post_id;
        }

        // If this is an autosave, our form has not been submitted,
        //     so we don't want to do anything.
        if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
            return $post_id;
        }

        // Check the user's permissions.
        if ( 'page' == $_POST['post_type'] ) {

            if ( ! current_user_can( 'edit_page', $post_id ) ) {
                return $post_id;
            }
    
        } else {

            if ( ! current_user_can( 'edit_post', $post_id ) ) {
                return $post_id;
            }
        }

        /* OK, its safe for us to save the data now. */
        // Sanitize the user input.
    	$metabox_data = $_POST[$this->metabox['id']];

        if (count($this->dimension_ids)) {
            foreach ( $this->dimension_ids as $dimension_id ) {
                $dvals = $metabox_data[$dimension_id];
                $metabox_data[$dimension_id] = $dvals[0].$dvals[1];
            }
        }
        
        if (count($this->image_ids)) {
            foreach ( $this->image_ids as $image_id ) {
                $dvals = $metabox_data[$image_id];
                
                if( !empty($dvals) ){
                    $metabox_data[$image_id] = json_decode( stripslashes($dvals), true);
                } else {
                    $metabox_data[$image_id] = array();
                }
                
            }
        }
        
        if (count($this->image_multi_ids)) {
            foreach ( $this->image_multi_ids as $image_id ) {
                $dvals = $metabox_data[$image_id];
                
                
                
                if( !empty($dvals) ){
                    $jsonval = json_decode( stripslashes($dvals), true);
                    
                    if (!is_array($jsonval)) {
                        $jsonval = json_decode( stripslashes($jsonval), true);
                    }
                    
                    $metabox_data[$image_id] = $jsonval;
                } else {
                    $metabox_data[$image_id] = array();
                }
                
            }
        }
        
        if (count($this->google_font_ids)) {
            foreach ( $this->google_font_ids as $google_font_id ) {
                $dvals = $metabox_data[$google_font_id];
                
                
                
                if( !empty($dvals) ){
                    $jsonval = json_decode( stripslashes($dvals), true);
                    
                    
                    if (!is_array($jsonval)) {
                        $jsonval = json_decode( stripslashes($jsonval), true);
                    }
                    
                    $metabox_data[$google_font_id] = $jsonval;
                } else {
                    $metabox_data[$google_font_id] = array();
                }
                
            }
        }
        


        update_post_meta( $post_id, $this->metabox['id'], $metabox_data );
    }

    public function set_dimension_input_ids( $options )
    {
        if (count($options)) {
            foreach ($options as $option) {
                if ( $option['type'] == 'dimension' ) {
                    $this->dimension_ids[] = $option['id'];
                }
            }
        }
        
    }
    
    public function set_image_input_ids( $options )
    {
        if (count($options)) {
            foreach ($options as $option) {
                if ( $option['type'] == 'image' ) {
                    $this->image_ids[] = $option['id'];
                }
            }
        }
        
    }
    
    public function set_multi_image_input_ids( $options )
    {
        if (count($options)) {
            foreach ($options as $option) {
                if ( $option['type'] == 'image_multi' ) {
                    $this->image_multi_ids[] = $option['id'];
                }
            }
        }
        
    }
    
    public function set_google_font_input_ids( $options )
    {
        if (count($options)) {
            foreach ($options as $option) {
                if ( $option['type'] == 'google_font' ) {
                    $this->google_font_ids[] = $option['id'];
                }
            }
        }
        
    }
    
    public function is_saved()
    {
    	$post = get_post();
    	
    	$value = get_post_meta( $post->ID, $this->metabox['id'] );
    	
    	
    	if ( ( array() !== $value ) ){
			return true;
		}
		
		return false;
    }
}