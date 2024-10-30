				<#
					var optionsAttr = '';

					if ( typeof data.choices != 'undefined' && typeof data.choices != 'string' ){
						optionsAttr = 'data-options="'+window.btoa(JSON.stringify(data.choices))+'"';
					}
				#>

				<div class="ctf-input-field ctf-input-field-date">
					<input type="text" class="ctf-date-field" value="{{ data.value }}" {{{ optionsAttr }}}  {{{ data.link }}} >
				</div>
