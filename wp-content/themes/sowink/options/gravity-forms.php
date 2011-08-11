<?php
	$option_fields[] = $gravity_forms = THEME_PREFIX . "gravity_forms";
?>

<div class="postbox">
    <h3>Enable "Gravity Forms" Styles</h3>
    
    <div class="inside">
    	<p>Check the box below to enable Gravity Forms styling.</p>
		
		<p>
			<label for="<?php echo $gravity_forms; ?>">
		        <input class="checkbox" id="<?php echo $gravity_forms; ?>" type="checkbox" name="<?php echo $gravity_forms; ?>" value="true"<?php checked(TRUE, (bool) get_option($gravity_forms)); ?> /> <?php _e("Enable Gravity Forms Styles"); ?>
		    </label>
		</p>
		
		<p class="submit">
			<input type="submit" class="button" value="Save Changes" />
		</p>
    </div> <!-- inside -->
</div> <!-- postbox -->