<div class="wrap">
    <h2>Emergency Alert Settings</h2>
    <form method="post" action="" style="max-width:850px;">

        <?php if ( $this->success ?? false ) : ?>
        <div class="notice notice-success">
            <p>Your settings have been saved.</p>
        </div>
        <?php endif; ?>
        
        <p>
            <label for="ea-status">
                <strong>Alert Status:</strong>
            </label>
        </p>
        <p>
            <label for="ea-status-on">
                <input type="radio" name="ea[status]" value="on" id="ea-status-on" <?php \checked( 'on', $status ); ?>>
                On
            </label>
            &nbsp;
            <label for="ea-status-off">
                <input type="radio" name="ea[status]" value="off" id="ea-status-off" <?php \checked( false, 'on' == $status ); ?>>
                Off
            </label>
        </p>

        <p>
            <label for="ea-status">
                <strong>Alert Persistence:</strong>
            </label>
        </p>
        <p>
            <label for="ea-persist-on">
                <input type="radio" value="on" id="ea-persist-on" name="ea[persist]" <?php \checked( 'off' == $persist, false ); ?>>
                Always show
            </label>
            &nbsp;
            <label for="ea-persist-off">
                <input type="radio" value="off" id="ea-persist-off" name="ea[persist]" <?php \checked( 'off', $persist ); ?>>
                Hide after close
            </label>
        </p>

        <hr>

        <p>
            <label for="ea-colors">
                <strong>Alert Colors:</strong>
            </label>
        </p>
        <p>
            <label for="ea-color">
                Text Color: 
                <input type="color" name="ea[color]" value="<?php echo \esc_attr( $color ); ?>" id="ea-color">
            </label>
            &nbsp;
            <label for="ea-bgcolor">
                Background Color: 
                <input type="color" name="ea[bgcolor]" value="<?php echo \esc_attr( $background ); ?>" id="ea-bgcolor">
            </label>
        </p>

        <p>
            <label for="ea-position">
                <strong>Alert Position:</strong>
            </label>
        </p>
        <p>
            <select id="ea-position" name="ea[position]">
                <?php foreach ( self::$positions_labels as $key => $label ) : ?>
                <option value="<?php echo \esc_attr( $key ); ?>"<?php selected( $key, $position ); ?>><?php echo \esc_html( $label ); ?></option>
                <?php endforeach; ?>
            </select> | 
            <em class="position-descriptions">
            <?php foreach ( self::$positions as $key => $desc ) : ?>
                <span class="position-desc" id="position-desc-<?php echo \esc_attr( $key ); ?>"><?php echo \esc_html( $desc ); ?></span>
                <?php endforeach; ?>
            </em>
        </p>

        <hr>

        <p>
            <label for="ea-js-adjust">
                <strong>Enable Javascript Position Adjustments:</strong>
                <br>
                <em>Our built-in Javascript logic can help clean up the design, but you may have a 
                more complex web design that you need to add custom CSS to make sure your alert
                looks good. If so, you may want to disable this feature. It is on by default.</em>
            </label>
        </p>
        <p>
            <label for="ea-js-adjust-on">
                <input type="radio" name="ea[js_adjust]" value="on" id="ea-js-adjust-on" <?php \checked( true, 'off' != $js_adjust ); ?>>
                On
            </label>
            &nbsp;
            <label for="ea-js-adjust-off">
                <input type="radio" name="ea[js_adjust]" value="off" id="ea-js-adjust-off" <?php \checked( 'off', $js_adjust ); ?>>
                Off
            </label>
        </p>

        <hr>

        <p>
            <label for="ea-content">
                <strong>Alert Content:</strong>
            </label>
        </p>
        <p>
            <?php
                \wp_editor( $content, 'wpm-ea-content', [
                    'textarea_name' => 'ea[content]',
                    'textarea_cols' => 20
                ] );
            ?>
        </p>
        <p>
            <label for="ea-reset-cookies">
                <input type="checkbox" id="ea-reset-cookies" name="ea[reset_cookies]" value="<?php echo \esc_attr( \date_i18n( 'U' ) ); ?>">
                Force the alert to appear for all users (resets for all users who have dismissed the alert).
            </label>
        </p>
        <p>
            <?php \wp_nonce_field( 'intent:save-settings', 'wpm-ea-nonce' ); ?>
            <input type="submit" class="button-primary" value="Save Settings">
        </p>
    </form>
</div>

<script>
jQuery(document).ready(function($){
    $('#ea-position').change(function(){
        console.log( $(this).val() );
        $('.position-descriptions .position-desc' ).hide();
        $('#position-desc-' + $(this).val() ).show();
    }).change();
});
</script>