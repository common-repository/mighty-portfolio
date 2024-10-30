(function( exports, $, CTF ){

    CTF_Core.CTF_Metabox = CTF_Core.Opts.extend({
        initialize: function ( container, args ){
	    	this.inputArgs = args;
	    	this.container = container;
	    	this.containerObj = $('#ctf-metabox-'+container);;

	    	this.renderContent();
	    },
        getNameAttr: function ( type, id ){
            var nameAttrValue = this.container+'['+id+']';

            if ( 
                (type == 'checkbox') ||
                (type == 'checkbox_image') ||
                (type == 'checkbox_button') ||
                (type == 'font_style') ||
                (type == 'dimension')
                ) {
                nameAttrValue  = this.container+'['+id+'][]';
            } else if ( type == 'text_multi' ) {
                nameAttrValue  = this.container+'['+id+'][]';
                // this.inputArgs.btnext  = 'data-name="'+this.container+'['+id+'][]"';
            }

            return nameAttrValue;
        },
        getInputValue: function ( type, id, defValue ){
            var value = defValue;
            if ( this.containerObj.data('saved') ) {
                if ( ! _.isUndefined(ctfmb_values[this.container][id]) ) {
                    if ( _.isNull(ctfmb_values[this.container][id]) ) {
                        value = {};
                    } else {
                        value = ctfmb_values[this.container][id];
                    }
                }
            }

            return value;
        }
    });

    function ctf_init() {
        if ( typeof ctfmb_opts == 'undefined' ) {
            return;
        }


        if( ! _.isEmpty(ctfmb_opts) ){
            _.each(ctfmb_opts, function ( metabox, mb_id, mb_full ) {
                if ( typeof CTF_Core != 'undefined' && typeof CTF_Core.CTF_Metabox != 'undefined' ) {
                    var field_obj = new CTF_Core.CTF_Metabox( mb_id, metabox );
                }
            });
        }
    }

    ctf_init();
    
})( wp, jQuery, CTF_Core );