<?php
/*
  Plugin Name: Checkout Address Autocomplete for WooCommerce
  Description: Allows your customers to autocomplete billing and shipping addresses on the checkout page using the Google Maps API.
  Author: eCreations
  Author URI: https://www.ecreations.net
  Plugin URI: https://www.ecreations.net
  Text Domain: checkout-address-autocomplete-for-woocommerce
  Version: 2.0.7
  Requires at least: 3.0.0
  Tested up to: 5.0.0
  WC requires at least: 3.0
  WC tested up to: 3.5.1
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

// Load plugin if WooCommerce plugin is activated, then check if API key has been saved

function ecr_addrac_init () {
    if (class_exists( 'WooCommerce' )) {
        if( get_option( 'ecr_addrac_key' ) ) {
            add_action('wp_footer', 'ecr_addrac_scripts');
        }else{
            add_action( 'admin_notices', 'ecr_addrac_missing_key_notice' );
        }
    }else{
        add_action( 'admin_notices', 'ecr_addrac_missing_wc_notice' );
    }
}
add_action( 'init', 'ecr_addrac_init' );

// Load Frontend Javascripts

function ecr_addrac_scripts() {
    if(is_checkout() || is_account_page()){
        if(get_option('ecr_force_enqueue_gmap')==true){
          wp_enqueue_script('google-autocomplete', 'https://maps.googleapis.com/maps/api/js?v=3&libraries=places&types=address'.ecr_addrac_language_param().'&key='.get_option( 'ecr_addrac_key' ));
          wp_enqueue_script('rp-autocomplete', plugin_dir_url( __FILE__ ) . 'autocomplete.js');
        }else{
            google_maps_script_loader();
        }
        $precise_warning = get_option('ecr_precise_address_warning');
        if($precise_warning === false || $precise_warning == '') {
            $precise_warning = 'disabled';
        }
        ?>
        <script type="text/javascript">
            var precise_address_alert = <?php echo json_encode($precise_warning); ?>;
        </script>
        <?php
    }
}

function ecr_addrac_language_param() {
    if($lang = get_option( 'ecr_addrac_lang' )) {
        $language = '&language='.$lang;
    } else {
        $language = '';
    }
    return apply_filters('checkout_adddress_autocomplete_language', $language);
}

function google_maps_script_loader() {
    global $wp_scripts; $gmapsenqueued = false;
    foreach ($wp_scripts->queue as $key) {
        if(array_key_exists($key, $wp_scripts->registered)) {
            $script = $wp_scripts->registered[$key];
            if (preg_match('#maps\.google(?:\w+)?\.com/maps/api/js#', $script->src)) {
                $gmapsenqueued = true;
            }
        }
    }

    if (!$gmapsenqueued) {
        wp_enqueue_script('google-autocomplete', 'https://maps.googleapis.com/maps/api/js?v=3&libraries=places&types=address'.ecr_addrac_language_param().'&key='.get_option( 'ecr_addrac_key' ));
    }
    wp_enqueue_script('rp-autocomplete', plugin_dir_url( __FILE__ ) . 'autocomplete.js');
}

// Admin Error Messages

function ecr_addrac_missing_wc_notice() {
    ?>
    <div class="error notice">
        <p><?php _e( 'You need to install and activate WooCommerce in order to use Checkout Address Autocomplete WooCommerce!', 'checkout-address-autocomplete-for-woocommerce' ); ?></p>
    </div>
    <?php
}

function ecr_addrac_missing_key_notice() {
    ?>
    <div class="update-nag notice">
        <p><?php _e( 'Please <a href="options-general.php?page=ecr_addrac">enter your Google Maps Javascript API Key</a> in order to use Checkout Address Autocomplete for WooCommerce!', 'checkout-address-autocomplete-for-woocommerce' ); ?></p>
    </div>
    <?php
}

// Admin Settings Menu

function ecr_addrac_menu(){
    add_options_page( 'Checkout Address Autocomplete for WooCommerce',
                    'Checkout Address Autocomplete', 
                    'manage_options', 
                    'ecr_addrac', 
                    'ecr_addrac_page', 
                    'dashicons-location', 
                    101 );
    add_action( 'admin_init', 'update_ecr_addrac' );
}
add_action( 'admin_menu', 'ecr_addrac_menu' );

// Admin Settings Page

function ecr_addrac_page(){
    ?>
    <div class="wrap">
        <h1>Checkout Address Autocomplete for WooCommerce</h1>
        <p>Paste your API key below and click "Save Changes" in order to enable the address autocomplete dropdown on the WooCommerce checkout page.</p>
        <p><a href="https://cloud.google.com/maps-platform/#get-started" target="_blank">Click here to get your "Places" API Key &raquo;</a></p>
        <p>Make sure to check the "Places" box.  If you don't already have a billing account on the Google Cloud Platform, you will need to set one up in order to get your API key.  The above link will guide you through it.</p>
        <form method="post" action="options.php">
            <?php settings_fields( 'ecr-addrac-settings' ); ?>
            <?php do_settings_sections( 'ecr-addrac-settings' ); ?>
            <table class="form-table">
                <tr valign="top">
                    <th scope="row">Google Maps Javascript<br />API Key:</th>
                    <td>
                        <input type="text" name="ecr_addrac_key" value="<?php echo get_option( 'ecr_addrac_key' ); ?>"/>
                    </td>
                </tr>
                <tr valign="top">
                    <th scope="row">Force Enqueue<br />Google Maps JS:</th>
                    <td>
                        <input type="checkbox" name="ecr_force_enqueue_gmap" value="true" <?php if(get_option('ecr_force_enqueue_gmap')==true)echo 'checked'; ?>/>
                        <p class="description">Some themes or plugins might cause false positives in our check to see if Google Maps javascript is already enqueued.<br />
                        If that happens and the Google Maps javascript doesn't get enqueued, check this box.  Otherwise, leave it unchecked.</p>
                    </td>
                </tr>
                <tr valign="top">
                    <th scope="row">Precise Street Address<br />Warning:</th>
                    <td>
                        <textarea name="ecr_precise_address_warning" rows="4" cols="50"><?php echo get_option( 'ecr_precise_address_warning' ); ?></textarea>
                        <p class="description">Warn customers with an alert if they select a street name without a precise address that includes the street number.<br />
                        Enter your alert text here.  Leave blank to disable this feature.<br />
                        For example, you could enter "The address you selected may not be a precise street address. Please make sure you include the street number."</p>
                    </td>
                </tr>
                <tr valign="top">
                    <th scope="row">Language:</th>
                    <td>
                        <select name="ecr_addrac_lang" value="<?php $lang = get_option( 'ecr_addrac_lang' ); echo $lang; ?>">
                            <option value="">- Auto -</option><option value="sq">ALBANIAN</option>
                            <?php $languages = array(
                                'sq' => 'ALBANIAN',
                                'ar' => 'ARABIC',
                                'eu' => 'BASQUE',
                                'be' => 'BELARUSIAN',
                                'bg' => 'BULGARIAN',
                                'my' => 'BURMESE',
                                'bn' => 'BENGALI',
                                'ca' => 'CATALAN',
                                'zh-CN' => 'CHINESE (SIMPLIFIED)',
                                'zh-TW' => 'CHINESE (TRADITIONAL)',
                                'hr' => 'CROATIAN',
                                'cs' => 'CZECH',
                                'da' => 'DANISH',
                                'nl' => 'DUTCH',
                                'en' => 'ENGLISH',
                                'en-AU' => 'ENGLISH (AUSTRALIAN)',
                                'en-GB' => 'ENGLISH (GREAT BRITAIN)',
                                'fa' => 'FARSI',
                                'fi' => 'FINNISH',
                                'fil' => 'FILIPINO',
                                'fr' => 'FRENCH',
                                'gl' => 'GALICIAN',
                                'de' => 'GERMAN',
                                'el' => 'GREEK',
                                'gu' => 'GUJARATI',
                                'iw' => 'HEBREW',
                                'hi' => 'HINDI',
                                'hu' => 'HUNGARIAN',
                                'id' => 'INDONESIAN',
                                'it' => 'ITALIAN',
                                'ja' => 'JAPANESE',
                                'kn' => 'KANNADA',
                                'kk' => 'KAZAKH',
                                'ko' => 'KOREAN',
                                'ky' => 'KYRGYZ',
                                'lt' => 'LITHUANIAN',
                                'lv' => 'LATVIAN',
                                'mk' => 'MACEDONIAN',
                                'ml' => 'MALAYALAM',
                                'mr' => 'MARATHI',
                                'no' => 'NORWEGIAN',
                                'pl' => 'POLISH',
                                'pt' => 'PORTUGUESE',
                                'pt-BR' => 'PORTUGUESE (BRAZIL)',
                                'pt-PT' => 'PORTUGUESE (PORTUGAL)',
                                'pa' => 'PUNJABI',
                                'ro' => 'ROMANIAN',
                                'ru' => 'RUSSIAN',
                                'sr' => 'SERBIAN',
                                'sk' => 'SLOVAK',
                                'sl' => 'SLOVENIAN',
                                'es' => 'SPANISH',
                                'sv' => 'SWEDISH',
                                'tl' => 'TAGALOG',
                                'ta' => 'TAMIL',
                                'te' => 'TELUGU',
                                'th' => 'THAI',
                                'tr' => 'TURKISH',
                                'uk' => 'UKRAINIAN',
                                'uz' => 'UZBEK',
                                'vi' => 'VIETNAMESE',                            
                            );
                            foreach($languages as $code => $label) {
                                echo '<option value="'.$code.'" ';
                                if($lang==$code) echo 'selected';
                                echo '>'.$label.'</option>';
                            } ?>
                        </select>
                    </td>
                </tr>
            </table>
            <?php submit_button(); ?>
        </form>
    </div>
    <?php
}

// Register Plugin Settings

function update_ecr_addrac() {
    register_setting( 'ecr-addrac-settings', 'ecr_addrac_key' );
    register_setting( 'ecr-addrac-settings', 'ecr_force_enqueue_gmap' );
    register_setting( 'ecr-addrac-settings', 'ecr_precise_address_warning' );
    register_setting( 'ecr-addrac-settings', 'ecr_addrac_lang' );
}
