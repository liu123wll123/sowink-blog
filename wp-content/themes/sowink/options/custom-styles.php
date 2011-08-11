<?php
	$option_fields[] = $background_img = THEME_PREFIX . "background_img";
	$option_fields[] = $background_fixed = THEME_PREFIX . "background_fixed";
	$option_fields[] = $background_color = THEME_PREFIX . "background_color";
	$option_fields[] = $background_vert = THEME_PREFIX . "background_vert";
	$option_fields[] = $background_horiz = THEME_PREFIX . "background_horiz";
	$option_fields[] = $background_repeat = THEME_PREFIX . "background_repeat";
	$option_fields[] = $footer_text_color = THEME_PREFIX . "footer_text_color";
	$option_fields[] = $footer_link_color = THEME_PREFIX . "footer_link_color";
	$option_fields[] = $footer_link_hover_color = THEME_PREFIX . "footer_link_hover_color";
	$option_fields[] = $enable_styles = THEME_PREFIX . "enable_styles";
?>

<div class="postbox">
    <h3>Custom Theme Styles</h3>
    
    <div class="inside">
    	<p>Use the options below to change the default theme styles. You can customize the background image and footer text colors to match your custom background.</p>
    	
    	<p>
    		<label for="<?php echo $enable_styles; ?>">
    		    <input class="checkbox" id="<?php echo $enable_styles; ?>" type="checkbox" name="<?php echo $enable_styles; ?>" value="true"<?php checked(TRUE, (bool) get_option($enable_styles)); ?> /> <?php _e("Enable Custom Styles"); ?>
    		</label>
    	</p>
    	
    	<p><strong>Custom Background Options:</strong></p>
    	
    	<input type="hidden" name="MAX_FILE_SIZE" value="3000000" />
    	
    	<label class="upload">
    		<p><input class="file" id="background_img_upload" type="file" name="<?php echo THEME_PREFIX; ?>background_img_upload" /></p>
    	</label>
    	
    	<?php if (get_option($background_img)) { ?>
    		<p>
    			<label for="<?php echo THEME_PREFIX; ?>delete_bg_img">
    				<input class="checkbox" id="<?php echo THEME_PREFIX; ?>delete_bg_img" type="checkbox" name="<?php echo THEME_PREFIX; ?>delete_bg_img" value="true" /> Delete Background Image...
    			</label>
    		</p>
    		<img class="image-preview" src="<?php echo get_option($background_img); ?>" alt="Background Preview" />
    	<?php } ?>
    	
    	<input type="hidden" name="<?php echo $background_img; ?>" value="<?php echo get_option($background_img); ?>" />
    	
    	<p>
			<label for="<?php echo $background_fixed; ?>">
		        <input class="checkbox" id="<?php echo $background_fixed; ?>" type="checkbox" name="<?php echo $background_fixed; ?>" value="true"<?php checked(TRUE, (bool) get_option($background_fixed)); ?> /> Fixed Background Position
		    </label>
		</p>
		
		<div class="table">
			<div class="row">
            	<div class="option">
                	<label class="config_level">
						<label>Background Color</label>
					</label>
				</div>
				
				<div class="option-select">	
					<script language="javascript">
					(function($){
						var initLayout = function() {
							$('#<?php echo $background_color; ?>').ColorPicker({
								onSubmit: function(hsb, hex, rgb, el) {
									$(el).val(hex);
									$(el).ColorPickerHide();
								},
								onBeforeShow: function () {
									$(this).ColorPickerSetColor(this.value);
								}
							})
							.bind('keyup', function(){
								$(this).ColorPickerSetColor(this.value);
							});
						};
						
						EYE.register(initLayout, 'init');
					})(jQuery)
					</script>
					
					#<input class="option-field-table" id="<?php echo $background_color; ?>" type="text" name="<?php echo $background_color; ?>" value="<?php echo get_option($background_color); ?>" />
				</div>
    		</div>
    		
    		<div class="row">
            	<div class="option">
                	<label class="config_level">
						<label>Background Vertical Alignment</label>
					</label>
				</div>

				<div class="option-select">	
					<?php $bgv = get_option(THEME_PREFIX . "background_vert"); ?>
				
					<select id="<?php echo $background_vert; ?>" name="<?php echo $background_vert; ?>">						
						<option value="top"<?php if ($bgv=="top") echo 'selected="selected"' ?>>Top</option>
						<option value="bottom"<?php if ($bgv=="bottom") echo 'selected="selected"' ?>>Bottom</option>
					</select>
				</div>
    		</div>
    		
    		<div class="row">
            	<div class="option">
                	<label class="config_level">
						<label>Background Horizontal Alignment</label>
					</label>
				</div>

				<div class="option-select">	
					<?php $bgh = get_option(THEME_PREFIX . "background_horiz"); ?>
				
					<select id="<?php echo $background_horiz; ?>" name="<?php echo $background_horiz; ?>">						
						<option value="left"<?php if ($bgh=="left") echo 'selected="selected"' ?>>Left</option>
						<option value="center"<?php if ($bgh=="center") echo 'selected="selected"' ?>>Center</option>
						<option value="right"<?php if ($bgh=="right") echo 'selected="selected"' ?>>Right</option>
					</select>
				</div>
    		</div>
    		
    		<div class="row">
            	<div class="option">
                	<label class="config_level">
						<label>Background Repeat</label>
					</label>
				</div>
				
				<div class="option-select">	
					<?php $bgr = get_option(THEME_PREFIX . "background_repeat"); ?>
				
					<select id="<?php echo $background_repeat; ?>" name="<?php echo $background_repeat; ?>">
						<option value="no-repeat"<?php if ($bgr=="no-repeat") echo 'selected="selected"' ?>>No Repeat</option>
						<option value="repeat-x"<?php if ($bgr=="repeat-x") echo 'selected="selected"' ?>>Repeat Horizontally</option>
						<option value="repeat-y"<?php if ($bgr=="repeat-y") echo 'selected="selected"' ?>>Repeat Vertically</option>
						<option value="repeat"<?php if ($bgr=="repeat") echo 'selected="selected"' ?>>Repeat Both</option>
					</select>
				</div>
    		</div>
    		
    		<div class="row">
    			<div class="option">
    		    	<label class="config_level">
    					<label>Footer Text Color</label>
    				</label>
    			</div>
    			
    			<div class="option-select">	
    				<script language="javascript">
    				(function($){
    					var initLayout = function() {
    						$('#<?php echo $footer_text_color; ?>').ColorPicker({
    							onSubmit: function(hsb, hex, rgb, el) {
    								$(el).val(hex);
    								$(el).ColorPickerHide();
    							},
    							onBeforeShow: function () {
    								$(this).ColorPickerSetColor(this.value);
    							}
    						})
    						.bind('keyup', function(){
    							$(this).ColorPickerSetColor(this.value);
    						});
    					};
    					
    					EYE.register(initLayout, 'init');
    				})(jQuery)
    				</script>
    				
    				#<input class="option-field-table" id="<?php echo $footer_text_color; ?>" type="text" name="<?php echo $footer_text_color; ?>" value="<?php echo get_option($footer_text_color); ?>" />
    			</div>
    		</div>
    		
    		<div class="row">
    			<div class="option">
    		    	<label class="config_level">
    					<label>Footer Link Color</label>
    				</label>
    			</div>
    			
    			<div class="option-select">	
    				<script language="javascript">
    				(function($){
    					var initLayout = function() {
    						$('#<?php echo $footer_link_color; ?>').ColorPicker({
    							onSubmit: function(hsb, hex, rgb, el) {
    								$(el).val(hex);
    								$(el).ColorPickerHide();
    							},
    							onBeforeShow: function () {
    								$(this).ColorPickerSetColor(this.value);
    							}
    						})
    						.bind('keyup', function(){
    							$(this).ColorPickerSetColor(this.value);
    						});
    					};
    					
    					EYE.register(initLayout, 'init');
    				})(jQuery)
    				</script>
    				
    				#<input class="option-field-table" id="<?php echo $footer_link_color; ?>" type="text" name="<?php echo $footer_link_color; ?>" value="<?php echo get_option($footer_link_color); ?>" />
    			</div>
    		</div>
    		
    		<div class="row last">
    			<div class="option">
    		    	<label class="config_level">
    					<label>Footer Link Hover Color</label>
    				</label>
    			</div>
    			
    			<div class="option-select">	
    				<script language="javascript">
    				(function($){
    					var initLayout = function() {
    						$('#<?php echo $footer_link_hover_color; ?>').ColorPicker({
    							onSubmit: function(hsb, hex, rgb, el) {
    								$(el).val(hex);
    								$(el).ColorPickerHide();
    							},
    							onBeforeShow: function () {
    								$(this).ColorPickerSetColor(this.value);
    							}
    						})
    						.bind('keyup', function(){
    							$(this).ColorPickerSetColor(this.value);
    						});
    					};
    					
    					EYE.register(initLayout, 'init');
    				})(jQuery)
    				</script>
    				
    				#<input class="option-field-table" id="<?php echo $footer_link_hover_color; ?>" type="text" name="<?php echo $footer_link_hover_color; ?>" value="<?php echo get_option($footer_link_hover_color); ?>" />
    			</div>
    		</div>
    		
    		<div class="clearfix"></div>
    	</div>

        <p class="submit">
			<input type="submit" class="button" value="Save Changes" />
		</p>
    </div> <!-- inside -->
</div> <!-- postbox -->
