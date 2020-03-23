<?php
namespace WPMaintainer;

class Emergency_Alert {

    const VERSION_CSS = '2020-03-18';
    const VERSION_JS = '2020-03-18';

    const DEFAULT_BGCOLOR = '#FFFFE0';
    const DEFAULT_COLOR = '#000000';
    const DEFAULT_POSITION = 'top-absolute';

    private static $positions = [
        'top' => 'Sticky, always visible (may cover content until dismissed)',
        'top-absolute' => 'Above site header, does not cover site content',
        'bottom' => 'Sticky, always visible (may cover content until dismissed)',
        'bottom-absolute' => 'Above site header, does not cover site content',
        'lightbox' => 'Overlays the entire site; must be dismissed to access site',
    ];
    
    private static $positions_labels = [
        'top-absolute' => 'Top',
        'top' => 'Top – Fixed',
        'bottom-absolute' => 'Bottom',
        'bottom' => 'Bottom – Fixed',
        'lightbox' => 'Lightbox',
    ];

    public static $instance;

    public static function init()
    {
        null === self::$instance && self::$instance = new self();
        return self::$instance;
    }

    private function __construct()
    {
        \add_action( 'body_class', [ $this, 'body_class' ] );
        \add_action( 'wp_enqueue_scripts', [ $this, 'wp_enqeue_scripts' ] );
        \add_action( 'wp_head', [ $this, 'wp_head' ] );
        \add_action( 'wp_footer', [ $this, 'wp_footer' ] );

        // admin
        \add_action( 'admin_init', [ $this, 'admin_init' ] );
        \add_action( 'admin_menu', [ $this, 'admin_menu' ] );

        // ajax
        \add_action( 'wp_ajax_wpm-ea-suppress', [ $this, 'ajax_suppress_alert' ] );
        \add_action( 'wp_ajax_nopriv_wpm-ea-suppress', [ $this, 'ajax_suppress_alert' ] );
    }

    public function ajax_suppress_alert()
    {
        if ( !isset( $_GET['wpm-ea-nonce'] ) || !\wp_verify_nonce( $_GET['wpm-ea-nonce'], 'intent:suppress' ) )
            die;

        $alerts = self::get_suppressed_alerts();
        $current_hash = self::get_current_hash();
        
        if ( !\in_array( $current_hash, $alerts ) )
        {
            $alerts[] = $current_hash;
        }

        $alerts = \json_encode( $alerts );

        // currently only browser session supported
        $result = \setcookie( 'wpm-ea-suppressions', $alerts, 0, COOKIEPATH, COOKIE_DOMAIN, \is_ssl(), false );
        $_COOKIE['wpm-ea-suppressions'] = $alerts;

        echo \json_encode( $_COOKIE );
        die;
    }

    public static function get_suppressed_alerts()
    {
        $alerts = \stripslashes( $_COOKIE['wpm-ea-suppressions'] ) ?? '[]';
        $alerts = \json_decode( $alerts );
        return $alerts;
    }

    public static function get_current_hash()
    {
        if ( $hash = \get_option( 'wpm_ea_hash' ) )
            return $hash;

        return 'default';
    }

    public function admin_init()
    {
        if ( $_POST['wpm-ea-nonce'] ?? false )
        {
            if ( !\wp_verify_nonce( $_POST['wpm-ea-nonce'], 'intent:save-settings' ) )
            {
                return;
            }

            $clean = \stripslashes_deep( $_POST['ea'] );
            foreach ( $clean as $k => $v )
            {
                switch ( $k )
                {
                    case 'bgcolor' :
                    case 'color' :
                    case 'content' :
                    case 'persist' :
                    case 'position' :
                    case 'status' :
                        \update_option( 'wpm_ea_' . $k, $v );
                        break;
                }
            }

            // reset hash
            if ( $clean['reset_cookies'] ?? false )
            {
                \update_option( 'wpm_ea_hash', $clean['reset_cookies'] );
            }
            $this->success = true;
        }
    }

    public function wp_enqeue_scripts()
    {
        \wp_enqueue_style( 'wpm-ea', \plugins_url( 'assets/css/wpm-ea.css', \dirname( __FILE__ ) ), [], self::VERSION_CSS );
        \wp_enqueue_script( 'wpm-ea', \plugins_url( 'assets/js/wpm-ea.js', \dirname( __FILE__ ) ), [ 'jquery' ], self::VERSION_CSS );
    }

    public function wp_head()
    {
        include __DIR__ . '/views/js-hooks.php';
    }

    public function wp_footer()
    {
        if ( 'on' != \apply_filters( 'wpm_ea_status', \get_option( 'wpm_ea_status' ) ) ) return;

        $color = \get_option( 'wpm_ea_color' );
        $bgcolor = \get_option( 'wpm_ea_bgcolor' );
        $suppress = \get_option( 'wpm_ea_persist' ) == 'on' ? 'false' : 'true';

        if ( 'true' == $suppress )
        {
            $alerts = self::get_suppressed_alerts();
            if ( \in_array( self::get_current_hash(), $alerts ) )
            {
                return;
            }
        }

        switch ( \get_option( 'wpm_ea_position' ) )
        {
            case 'lightbox' :
                include __DIR__ . '/views/alert-lightbox.php';
                break;

            case 'bottom' :
                include __DIR__ . '/views/alert-footer-fixed.php';
                break;

            case 'bottom-absolute' :
                include __DIR__ . '/views/alert-footer-absolute.php';
                break;

            case 'top-absolute' :
                include __DIR__ . '/views/alert-header-absolute.php';
                break;

            case 'top' :
            default :
                include __DIR__ . '/views/alert-header-fixed.php';
                break;
        }
    }

    public function body_class( $classes )
    {
        if ( 'true' == $suppress )
        {
            $alerts = self::get_suppressed_alerts();
            if ( \in_array( self::get_current_hash(), $alerts ) )
            {
                return;
            }
        }
        
        if ( 'on' == \get_option( 'wpm_ea_status' ) )
        {
            $classes[] = 'wpm-ea-active';

            $position = \get_option( 'wpm_ea_position' );

            switch ( $position )
            {
                case 'top' :
                case 'top-absolute' :
                case 'bottom':
                case 'bottom-absolute':
                case 'lightbox':
                    $classes[] = 'wpm-ea-position-' . $position;
                    break;
            }
        }
        
        return $classes;
    }

    public function admin_menu()
    {
        \add_submenu_page( 'options-general.php', 'Emergency Alert', 'Emergency Alert', \apply_filters( 'wpm_ea_admin_capability', 'edit_users' ), 'wpm-ea-settings', [ $this, 'admin_settings' ] );
    }

    public function admin_settings()
    {

        $status = \get_option( 'wpm_ea_status' );
        
        $persist = \get_option( 'wpm_ea_persist' );
        if ( !$persist )
            $persist = 'on';

        $position = \get_option( 'wpm_ea_position' );
        if ( !$position )
            $position = self::DEFAULT_POSITION;

        $background = \get_option( 'wpm_ea_bgcolor' );
        if ( !$background )
            $background = self::DEFAULT_BGCOLOR;

        $color = \get_option( 'wpm_ea_color' );
        if ( !$color )
            $color = self::DEFAULT_COLOR;

        $js_adjust = \get_option( 'wpm_ea_js_adjust' );
        
        $content = \get_option( 'wpm_ea_content' );

        include __DIR__ . '/views/admin-settings.php';
    }
}

Emergency_Alert::init();
