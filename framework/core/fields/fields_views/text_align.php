	<#
		var nameAttr = '';
	
		if( typeof isAddon == 'undefined' ){
			nameAttr = 'name="ctf_radio_input_'+data.id+'"';
		}
	#>
	<div class="ctf-input-field ctf-input-field-radio-button ctf-input-field-text-align  clearfix">
		
		<# if( _.isEmpty(data.choices['left']) || data.choices['left'] == 1 ){ #>
		<label>
			<input type="radio" value="left" {{{ data.link }}} {{{ nameAttr }}} <# if ( 'left' === data.value ) { #>checked="checked"<# } #> > 
			<span class="ctf-input-radio-button"><i class="fa fa-align-left"></i></span>
		</label>
		<# } #>
		<# if( _.isEmpty(data.choices['center']) || data.choices['center'] == 1 ){ #>
		<label>
			<input type="radio" value="center" {{{ data.link }}} {{{ nameAttr }}} <# if ( 'center' === data.value ) { #>checked="checked"<# } #> > 
			<span class="ctf-input-radio-button"><i class="fa fa-align-center"></i></span>
		</label>
		<# } #>
		<# if( _.isEmpty(data.choices['right']) || data.choices['right'] == 1 ){ #>
		<label>
			<input type="radio" value="right" {{{ data.link }}} {{{ nameAttr }}} <# if ( 'right' === data.value ) { #>checked="checked"<# } #> > 
			<span class="ctf-input-radio-button"><i class="fa fa-align-right"></i></span>
		</label>
		<# } #>
		<# if( _.isEmpty(data.choices['justify']) || data.choices['justify'] == 1 ){ #>
		<label>
			<input type="radio" value="justify" {{{ data.link }}} {{{ nameAttr }}} <# if ( 'justify' === data.value ) { #>checked="checked"<# } #> > 
			<span class="ctf-input-radio-button"><i class="fa fa-align-justify"></i></span>
		</label>
		<# } #>

	</div>