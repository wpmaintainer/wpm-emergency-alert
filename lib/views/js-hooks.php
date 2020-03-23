<script>
var wpmea = {
    "ajax_url" : "<?php \admin_url( '/admin-ajax.php' ); ?>",
    "adjustments" : <?php echo \apply_filters( 'wpm_ea_js_adjust', \get_option( 'wpm_ea_js_adjust' ) ) == 'on' ? 'true' : 'false'; ?>
}
</script>