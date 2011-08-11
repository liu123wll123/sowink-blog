<style type="text/css" media="screen">
<?php if (get_option(THEME_PREFIX . "enable_styles")) { ?>
body {
background:<?php if (get_option(THEME_PREFIX . "background_color")) { ?> #<?php echo get_option(THEME_PREFIX . "background_color"); ?><?php } ?><?php if (get_option(THEME_PREFIX . "background_img")) { ?> url(<?php echo get_option(THEME_PREFIX . "background_img"); ?>) <?php echo get_option(THEME_PREFIX . "background_vert"); ?> <?php echo get_option(THEME_PREFIX . "background_horiz"); ?> <?php echo get_option(THEME_PREFIX . "background_repeat"); ?><?php if (get_option(THEME_PREFIX . "background_fixed")) { ?> fixed<?php } ?><?php } ?>;
color: <?php if (get_option(THEME_PREFIX . "content_text_color")) { ?>#<?php echo get_option(THEME_PREFIX . "content_text_color"); ?><?php } ?>;
}

#footer, #footer h3 {
color: <?php if (get_option(THEME_PREFIX . "footer_text_color")) { ?>#<?php echo get_option(THEME_PREFIX . "footer_text_color"); ?><?php } ?>;
}

#footer a {
color: <?php if (get_option(THEME_PREFIX . "footer_link_color")) { ?>#<?php echo get_option(THEME_PREFIX . "footer_link_color"); ?><?php } ?>;
}

#footer a:hover {
color: <?php if (get_option(THEME_PREFIX . "footer_link_hover_color")) { ?>#<?php echo get_option(THEME_PREFIX . "footer_link_hover_color"); ?><?php } ?>;
}
<?php } ?>
</style>