<p class="legalpack-shortcodes-source"><?php
	_e( 'Insert shortcode:', LEGALPACK_SLUG );
	echo ' ';
	$s = array ();
	foreach ($shortcodes as $k => $v) {
		$s[] = '<a href="javascript:void(0);" data="' .
			esc_attr( $v ) . '" editor="'.$option->name().'">' . esc_html( $k ) . '</a>';
	}
	echo join( ', ', $s );
	?>
</p>