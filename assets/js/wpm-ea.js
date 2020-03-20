jQuery(document).ready(function($){

    var alert_height = $( '.wpm-ea-alert' ).height();
    console.log( wpmea.adjustments );
    if ( wpmea.adjustments && $( '.wpm-ea-alert-bottom-absolute' ).size() > 0 )
    {
        var body_bottom_pad = $( 'body.wpm-ea-position-bottom-absolute' ).css( 'paddingBottom' ).replace( 'px', '' );
        var new_pad = alert_height + parseInt(body_bottom_pad);
        $( 'body.wpm-ea-position-bottom-absolute' ).css( 'paddingBottom', new_pad + 'px' );
    }

    if ( wpmea.adjustments && $( '.wpm-ea-alert-top-absolute' ).size() > 0 )
    {
        var body_top_margin = $( 'body.wpm-ea-position-top-absolute' ).css( 'marginTop' ).replace( 'px', '' );
        var new_margin = parseInt( body_top_margin ) + alert_height;
        if ( $( 'body' ).hasClass( 'admin-bar' ) ) new_margin += 42;
        $( 'body.wpm-ea-position-top-absolute' ).css( 'marginTop', new_margin + 'px' );
    }

    $( '.wpm-ea-trigger' ).click(function(){

        if ( $( '#wpm-ea-alert' ).data( 'suppress' ) === true )
        {
            var ajax_url = $( '#wpm-ea-alert' ).data( 'suppress-url' );
            $.get(ajax_url);
        }

        $('body').removeClass( 'wpm-ea-position-top wpm-ea-position-top-absolute wpm-ea-position-bottom wpm-ea-position-bottom-absolute wpm-ea-position-lightbox' );
        $( '#wpm-ea-alert,.wpm-ea-alert-overlay' ).fadeOut();

        return false;
    });
});