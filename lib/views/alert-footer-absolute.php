<div class="wpm-ea-alert wpm-ea-alert-bottom-absolute" 
    id="wpm-ea-alert"
    data-suppress="<?php echo \esc_attr( $suppress ); ?>"
    data-suppress-url="<?php echo \admin_url( '/admin-ajax.php?action=wpm-ea-suppress&wpm-ea-nonce=' . \wp_create_nonce( 'intent:suppress' ) ); ?>"
    style="background-color: <?php echo \esc_attr( $bgcolor ); ?>;color: <?php echo \esc_attr( $color ); ?>"
>
    <div class="wpm-ea-alert-pad">
        <div class="wpm-ea-alert-bin">
            <?php echo \do_shortcode( \wpautop( \get_option( 'wpm_ea_content' ) ) ); ?>
            <div class="aligncenter"><p><a href="#" class="wpm-ea-trigger wpm-ea-button" style="color:<?php echo \esc_attr( $color ); ?>"><?php
                echo \apply_filters( 'wpm_ea_trigger_label', 'CLOSE' );
            ?></a>
        </div>
    </div>
</div>