<?php
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly
/**
 * Moove_Controller File Doc Comment
 *
 * @category Moove_Controller
 * @package   moove-gdpr-tracking
 * @author    Gaspar Nemes
 */

/**
 * Moove_Controller Class Doc Comment
 *
 * @category Class
 * @package  Moove_Controller
 * @author   Gaspar Nemes
 */
class Moove_GDPR_Controller {
    /**
     * Construct function
     */
    public function __construct() {
        // add_action( 'wp_footer', array( &$this, 'moove_gdpr_cookie_popup' ) );
        add_action( 'wp_footer', array( &$this, 'moove_gdpr_cookie_popup_modal' ), 99 );
        add_action( 'admin_init', array( &$this, 'moove_gdpr_add_editor_styles' ) );
        add_action( 'wp_footer', array( &$this, 'moove_gdpr_cookie_popup_info' ) );
    }

    /**
     * Custom Editor CSS added to GDPR plugin WYSIWYG editors
     * @return void
     */
    public function moove_gdpr_add_editor_styles() {
        add_editor_style( moove_gdpr_get_plugin_directory_url() . 'dist/styles/custom-editor-style.css' );
    }

    /**
     * CSS minification for inlined CSS styles
     * @param  string $input Inlined styles
     * @return string        Minified styles
     */
    public function moove_gdpr_minify_css($input) {
        if(trim($input) === "") return $input;
        return preg_replace(
            array(
                // Remove comment(s)
                '#("(?:[^"\\\]++|\\\.)*+"|\'(?:[^\'\\\\]++|\\\.)*+\')|\/\*(?!\!)(?>.*?\*\/)|^\s*|\s*$#s',
                // Remove unused white-space(s)
                '#("(?:[^"\\\]++|\\\.)*+"|\'(?:[^\'\\\\]++|\\\.)*+\'|\/\*(?>.*?\*\/))|\s*+;\s*+(})\s*+|\s*+([*$~^|]?+=|[{};,>~+]|\s*+-(?![0-9\.])|!important\b)\s*+|([[(:])\s++|\s++([])])|\s++(:)\s*+(?!(?>[^{}"\']++|"(?:[^"\\\]++|\\\.)*+"|\'(?:[^\'\\\\]++|\\\.)*+\')*+{)|^\s++|\s++\z|(\s)\s+#si',
                // Replace `0(cm|em|ex|in|mm|pc|pt|px|vh|vw|%)` with `0`
                '#(?<=[\s:])(0)(cm|em|ex|in|mm|pc|pt|px|vh|vw|%)#si',
                // Replace `:0 0 0 0` with `:0`
                '#:(0\s+0|0\s+0\s+0\s+0)(?=[;\}]|\!important)#i',
                // Replace `background-position:0` with `background-position:0 0`
                '#(background-position):0(?=[;\}])#si',
                // Replace `0.6` with `.6`, but only when preceded by `:`, `,`, `-` or a white-space
                '#(?<=[\s:,\-])0+\.(\d+)#s',
                // Minify string value
                '#(\/\*(?>.*?\*\/))|(?<!content\:)([\'"])([a-z_][a-z0-9\-_]*?)\2(?=[\s\{\}\];,])#si',
                '#(\/\*(?>.*?\*\/))|(\burl\()([\'"])([^\s]+?)\3(\))#si',
                // Minify HEX color code
                '#(?<=[\s:,\-]\#)([a-f0-6]+)\1([a-f0-6]+)\2([a-f0-6]+)\3#i',
                // Replace `(border|outline):none` with `(border|outline):0`
                '#(?<=[\{;])(border|outline):none(?=[;\}\!])#',
                // Remove empty selector(s)
                '#(\/\*(?>.*?\*\/))|(^|[\{\}])(?:[^\s\{\}]+)\{\}#s'
            ),
            array(
                '$1',
                '$1$2$3$4$5$6$7',
                '$1',
                ':0',
                '$1:0 0',
                '.$1',
                '$1$3',
                '$1$2$4$5',
                '$1$2$3',
                '$1:0',
                '$1$2'
            ),
        $input);
    }

    /**
     * Inline styles based on the colours selected in the options page
     */
    public function get_minified_styles( $primary_colour, $secondary_colour, $button_bg, $button_hover_bg, $button_font ) {
        ob_start();
        ?>

        #moove_gdpr_save_popup_settings_button {
            background-color: <?php echo $button_bg; ?> !important;
            color: <?php echo $button_font; ?> !important;
        }
        #moove_gdpr_save_popup_settings_button:hover {
            background-color: <?php echo $button_hover_bg; ?> !important;
        }

        #moove_gdpr_cookie_info_bar .moove-gdpr-info-bar-container .moove-gdpr-info-bar-content a.mgbutton,
        #moove_gdpr_cookie_info_bar .moove-gdpr-info-bar-container .moove-gdpr-info-bar-content button.mgbutton {
            background-color: <?php echo $primary_colour; ?> !important;
        }
        #moove_gdpr_cookie_modal .moove-gdpr-modal-content .moove-gdpr-modal-footer-content .moove-gdpr-button-holder a.mgbutton,
        #moove_gdpr_cookie_modal .moove-gdpr-modal-content .moove-gdpr-modal-footer-content .moove-gdpr-button-holder button.mgbutton {
            background-color: <?php echo $primary_colour; ?> !important;
            border-color: <?php echo $primary_colour; ?> !important;
        }

        #moove_gdpr_cookie_modal .moove-gdpr-modal-content .moove-gdpr-modal-footer-content .moove-gdpr-button-holder a.mgbutton:hover,
        #moove_gdpr_cookie_modal .moove-gdpr-modal-content .moove-gdpr-modal-footer-content .moove-gdpr-button-holder button.mgbutton:hover {
            background-color: #fff !important;
            color: <?php echo $primary_colour; ?> !important;
        }

        #moove_gdpr_cookie_modal .moove-gdpr-modal-content .moove-gdpr-modal-close i {
            background-color: <?php echo $primary_colour; ?> !important;
            border: 1px solid <?php echo $primary_colour; ?> !important;
        }
        #moove_gdpr_cookie_modal .gdpr-acc-link {
            line-height: 0;
            font-size: 0;
            color: transparent;
        }

        #moove_gdpr_cookie_modal .moove-gdpr-modal-content .moove-gdpr-modal-close:hover i,
        #moove_gdpr_cookie_modal .moove-gdpr-modal-content .moove-gdpr-modal-left-content #moove-gdpr-menu li a,
        #moove_gdpr_cookie_modal .moove-gdpr-modal-content .moove-gdpr-modal-left-content #moove-gdpr-menu li button,
        #moove_gdpr_cookie_modal .moove-gdpr-modal-content .moove-gdpr-modal-left-content #moove-gdpr-menu li button i,
        #moove_gdpr_cookie_modal .moove-gdpr-modal-content .moove-gdpr-modal-left-content #moove-gdpr-menu li a i,
        #moove_gdpr_cookie_modal .moove-gdpr-modal-content .moove-gdpr-tab-main .moove-gdpr-tab-main-conent a:hover,
        #moove_gdpr_cookie_info_bar.moove-gdpr-dark-scheme .moove-gdpr-info-bar-container .moove-gdpr-info-bar-content a.mgbutton:hover,
        #moove_gdpr_cookie_info_bar.moove-gdpr-dark-scheme .moove-gdpr-info-bar-container .moove-gdpr-info-bar-content button.mgbutton:hover,
        #moove_gdpr_cookie_info_bar.moove-gdpr-dark-scheme .moove-gdpr-info-bar-container .moove-gdpr-info-bar-content a:hover,
        #moove_gdpr_cookie_info_bar.moove-gdpr-dark-scheme .moove-gdpr-info-bar-container .moove-gdpr-info-bar-content button:hover,
        #moove_gdpr_cookie_info_bar.moove-gdpr-dark-scheme .moove-gdpr-info-bar-container .moove-gdpr-info-bar-content span.change-settings-button:hover {
            color: <?php echo $primary_colour; ?> !important;
        }

        #moove_gdpr_cookie_modal .moove-gdpr-modal-content .moove-gdpr-modal-left-content #moove-gdpr-menu li.menu-item-selected a,
        #moove_gdpr_cookie_modal .moove-gdpr-modal-content .moove-gdpr-modal-left-content #moove-gdpr-menu li.menu-item-selected button {
            color: <?php echo $secondary_colour; ?> !important;
        }
        #moove_gdpr_cookie_modal .moove-gdpr-modal-content .moove-gdpr-modal-left-content #moove-gdpr-menu li.menu-item-selected a i,
        #moove_gdpr_cookie_modal .moove-gdpr-modal-content .moove-gdpr-modal-left-content #moove-gdpr-menu li.menu-item-selected button i {
            color: <?php echo $secondary_colour; ?> !important;
        }
        #moove_gdpr_cookie_modal.lity-hide {
            display: none;
        }

        <?php
        $input = apply_filters( 'moove_gdpr_inline_styles', ob_get_clean(), $primary_colour, $secondary_colour, $button_bg, $button_hover_bg, $button_font );
        $gdpr_controller = new Moove_GDPR_Controller();
        return $gdpr_controller->moove_gdpr_minify_css( $input );
    }

    /**
     * GDPR Modal Main content
     * @return void
     */
    public function moove_gdpr_cookie_popup_modal() {
        $gdpr_default_content = new Moove_GDPR_Content();
        $option_name    = $gdpr_default_content->moove_gdpr_get_option_name();
        $modal_options  = get_option( $option_name );
        $wpml_lang      = $gdpr_default_content->moove_gdpr_get_wpml_lang();
        $layout         = isset( $modal_options['moove_gdpr_plugin_layout'] ) ? $modal_options['moove_gdpr_plugin_layout'] : 'v1';
        $modal_theme    = 'moove_gdpr_modal_theme_' . $layout;
        $strictly       = isset( $modal_options['moove_gdpr_strictly_necessary_cookies_functionality'] ) && intval( $modal_options['moove_gdpr_strictly_necessary_cookies_functionality'] ) ? intval( $modal_options['moove_gdpr_strictly_necessary_cookies_functionality'] ) : 1;

        // BRANDING CONTENT
        ob_start(); ?>
        <div class="moove-gdpr-branding-cnt">
            <?php
                $moove_actions_cnt = new Moove_GDPR_Actions();
                $disabled       = isset( $modal_options['moove_gdpr_modal_powered_by_disable'] ) && intval( $modal_options['moove_gdpr_modal_powered_by_disable'] === 1 ) ? true : false;
                if ( ! $disabled ) :
                    echo apply_filters( 'moove_gdpr_footer_branding_text', $moove_actions_cnt->moove_gdpr_footer_branding_content() );
                endif;
            ?>
        </div>
        <!--  .moove-gdpr-branding -->
        <?php $branding_text = ob_get_clean(); ?>

        <?php
        // LOGO CONTENT
        ob_start();
        ?>
        <div class="moove-gdpr-company-logo-holder">
            <?php
                $logo_url   = isset( $modal_options['moove_gdpr_company_logo'] ) && $modal_options['moove_gdpr_company_logo'] ? $modal_options['moove_gdpr_company_logo'] :  plugin_dir_url( dirname( __FILE__ ) ) . 'dist/images/moove-logo.png';
            ?>
            <img src="<?php echo $logo_url ?>" alt="" class="img-responsive" />
        </div>
        <!--  .moove-gdpr-company-logo-holder -->
        <?php
        $logo_content = ob_get_clean();

        ob_start(); ?>
        <?php if ( isset( $modal_options['moove_gdpr_floating_button_enable'] ) && intval( $modal_options['moove_gdpr_floating_button_enable'] ) === 1 ) : ?>
            <button data-href="#moove_gdpr_cookie_modal" id="moove_gdpr_save_popup_settings_button" style='display: none; <?php echo isset( $modal_options['moove_gdpr_floating_button_position'] ) ? $modal_options['moove_gdpr_floating_button_position'] : ''; ?>'>
                <span class="moove_gdpr_icon"><i class="moovegdpr-advanced"></i></span>
                <span class="moove_gdpr_text"><?php echo ( isset( $modal_options['moove_gdpr_floating_button_label'.$wpml_lang] ) && $modal_options['moove_gdpr_floating_button_label'.$wpml_lang] ) ? $modal_options['moove_gdpr_floating_button_label'.$wpml_lang] : __('Change cookie settings','moove-gdpr'); ?></span>
            </button>
        <?php endif; ?>


        <style>
            <?php
            $primary_colour     = isset( $modal_options['moove_gdpr_brand_colour'] ) && $modal_options['moove_gdpr_brand_colour'] ? $modal_options['moove_gdpr_brand_colour'] : '#0C4DA2';
            $secondary_colour   = isset( $modal_options['moove_gdpr_brand_secondary_colour'] ) && $modal_options['moove_gdpr_brand_secondary_colour'] ? $modal_options['moove_gdpr_brand_secondary_colour'] : '#000000';
            $button_bg          = isset( $modal_options['moove_gdpr_floating_button_background_colour'] ) && $modal_options['moove_gdpr_floating_button_background_colour'] ? $modal_options['moove_gdpr_floating_button_background_colour'] : '#373737';
            $button_hover_bg    = isset( $modal_options['moove_gdpr_floating_button_hover_background_colour'] ) && $modal_options['moove_gdpr_floating_button_hover_background_colour'] ? $modal_options['moove_gdpr_floating_button_hover_background_colour'] : '#000000';
            $button_font        = isset( $modal_options['moove_gdpr_floating_button_font_colour'] ) && $modal_options['moove_gdpr_floating_button_font_colour'] ? $modal_options['moove_gdpr_floating_button_font_colour'] : '#ffffff';
            $moove_gdpr_cnt = new Moove_GDPR_Controller();
            echo $moove_gdpr_cnt->get_minified_styles( $primary_colour, $secondary_colour, $button_bg, $button_hover_bg, $button_font  );
            ?>
        </style>

        <div id="moove_gdpr_cookie_modal" class="lity-hide">
            <div class="moove-gdpr-modal-content moove-clearfix logo-position-<?php echo isset( $modal_options['moove_gdpr_logo_position'] ) ? $modal_options['moove_gdpr_logo_position'] : 'left'; ?> <?php echo $modal_theme; ?>">
                <a href="#" class="moove-gdpr-modal-close" rel="nofollow"><i class="moovegdpr-arrow-close"></i></a>
                <div class="moove-gdpr-modal-left-content">
                    <?php echo $layout === 'v1' ? $logo_content : ''; ?>
                    <ul id="moove-gdpr-menu">
                        <?php
                            $nav_label  = isset( $modal_options['moove_gdpr_privacy_overview_tab_title'.$wpml_lang] ) && $modal_options['moove_gdpr_privacy_overview_tab_title'.$wpml_lang] ? $modal_options['moove_gdpr_privacy_overview_tab_title'.$wpml_lang] : __('Privacy Overview','moove-gdpr');
                        ?>
                        <li class="menu-item-on menu-item-privacy_overview menu-item-selected">
                            <button data-href="#privacy_overview" class="moove-gdpr-tab-nav"><i class="moovegdpr-privacy-overview"></i> <span><?php echo $nav_label; ?></span></button>
                        </li>

                        <?php
                            $nav_label  = isset( $modal_options['moove_gdpr_strictly_necessary_cookies_tab_title'.$wpml_lang] ) && $modal_options['moove_gdpr_strictly_necessary_cookies_tab_title'.$wpml_lang] ? $modal_options['moove_gdpr_strictly_necessary_cookies_tab_title'.$wpml_lang] : __('Strictly Necessary Cookies','moove-gdpr');
                        ?>
                        <?php if ( $strictly !== 3 ) : ?>
                            <li class="menu-item-strict-necesarry-cookies menu-item-off">
                                <button data-href="#strict-necesarry-cookies" class="moove-gdpr-tab-nav"><i class="moovegdpr-strict-necessary"></i> <span><?php echo $nav_label; ?></span></button>
                            </li>
                        <?php endif; ?>


                        <?php
                            $enabled_3rd_party_cookies    = isset( $modal_options['moove_gdpr_third_party_cookies_enable'] ) && intval( $modal_options['moove_gdpr_third_party_cookies_enable'] ) === 1 ? true : false;
                            $nav_label  = isset( $modal_options['moove_gdpr_performance_cookies_tab_title'.$wpml_lang] ) && $modal_options['moove_gdpr_performance_cookies_tab_title'.$wpml_lang] ? $modal_options['moove_gdpr_performance_cookies_tab_title'.$wpml_lang] : __('3rd Party Cookies','moove-gdpr');
                        ?>
                        <?php if ( $enabled_3rd_party_cookies ) : ?>
                            <li class="menu-item-off menu-item-third_party_cookies">
                                <button data-href="#third_party_cookies" class="moove-gdpr-tab-nav"><i class="moovegdpr-3rd-party"></i> <span><?php echo $nav_label; ?></span></button>
                            </li>
                        <?php endif; ?>

                        <?php
                            $enabled_advanced_cookies    = isset( $modal_options['moove_gdpr_advanced_cookies_enable'] ) && intval( $modal_options['moove_gdpr_advanced_cookies_enable'] ) === 1 ? true : false;
                            $nav_label  = isset( $modal_options['moove_gdpr_advanced_cookies_tab_title'.$wpml_lang] ) && $modal_options['moove_gdpr_advanced_cookies_tab_title'.$wpml_lang] ? $modal_options['moove_gdpr_advanced_cookies_tab_title'.$wpml_lang] : __('Additional Cookies','moove-gdpr');
                        ?>
                        <?php if ( $enabled_advanced_cookies ) : ?>
                            <li class="menu-item-advanced-cookies menu-item-off">
                                <button data-href="#advanced-cookies" class="moove-gdpr-tab-nav"><i class="moovegdpr-advanced"></i> <span><?php echo $nav_label; ?></span></button>
                            </li>
                        <?php endif; ?>

                        <?php

                            $enabled_cookie_policy    = isset( $modal_options['moove_gdpr_cookie_policy_enable'] ) && intval( $modal_options['moove_gdpr_cookie_policy_enable'] ) === 1 ? true : false;

                            $nav_label  = isset( $modal_options['moove_gdpr_cookie_policy_tab_nav_label'.$wpml_lang] ) && $modal_options['moove_gdpr_cookie_policy_tab_nav_label'.$wpml_lang] ? $modal_options['moove_gdpr_cookie_policy_tab_nav_label'.$wpml_lang] : __('Cookie Policy','moove-gdpr');

                        ?>
                        <?php if ( $enabled_cookie_policy ) : ?>
                            <li class="menu-item-moreinfo menu-item-off">
                                <button data-href="#cookie_policy_modal" class="moove-gdpr-tab-nav" rel="nofollow"><i class="moovegdpr-policy"></i> <span><?php echo $nav_label; ?></span></button>
                            </li>
                        <?php endif; ?>
                    </ul>

                <?php echo $layout === 'v1' ? $branding_text : ''; ?>
                </div>
                <!--  .moove-gdpr-modal-left-content -->
                <?php
                    $tab_title  = isset( $modal_options['moove_gdpr_privacy_overview_tab_title'.$wpml_lang] ) && $modal_options['moove_gdpr_privacy_overview_tab_title'.$wpml_lang] ? $modal_options['moove_gdpr_privacy_overview_tab_title'.$wpml_lang] : __('Privacy Overview','moove-gdpr');
                    $tab_content  = isset( $modal_options['moove_gdpr_privacy_overview_tab_content'.$wpml_lang] ) && $modal_options['moove_gdpr_privacy_overview_tab_content'.$wpml_lang] ? $modal_options['moove_gdpr_privacy_overview_tab_content'.$wpml_lang] : $gdpr_default_content->moove_gdpr_get_privacy_overview_content();
                ?>
                <div class="moove-gdpr-modal-right-content">
                    <div class="moove-gdpr-modal-title">

                        <?php if ( $layout === 'v2' ) : ?>
                            <div>
                                <h3 class="tab-title"><?php echo $tab_title; ?></h3>
                            </div>
                        <?php endif; ?>
                        <?php echo $layout === 'v2' ? $logo_content : ''; ?>
                    </div>
                    <!-- .moove-gdpr-modal-ritle -->
                    <div class="main-modal-content">

                        <div class="moove-gdpr-tab-content">
                            <div id="privacy_overview" class="moove-gdpr-tab-main">
                                <?php if ( $layout === 'v1' ) : ?>
                                    <h3 class="tab-title"><?php echo $tab_title; ?></h3>
                                <?php endif; ?>
                                <div class="moove-gdpr-tab-main-conent">
                                    <?php echo wpautop( $tab_content ); ?>
                                </div>
                                <!--  .moove-gdpr-tab-main-conent -->
                            </div>

                            <?php if ( $strictly !== 3 ) : ?>
                                <div id="strict-necesarry-cookies" class="moove-gdpr-tab-main" style="display:none">
                                    <?php
                                        $tab_title  = isset( $modal_options['moove_gdpr_strictly_necessary_cookies_tab_title'.$wpml_lang] ) && $modal_options['moove_gdpr_strictly_necessary_cookies_tab_title'.$wpml_lang] ? $modal_options['moove_gdpr_strictly_necessary_cookies_tab_title'.$wpml_lang] : __('Strictly Necessary Cookies','moove-gdpr');
                                        $tab_content  = isset( $modal_options['moove_gdpr_strict_necessary_cookies_tab_content'.$wpml_lang] ) && $modal_options['moove_gdpr_strict_necessary_cookies_tab_content'.$wpml_lang] ? $modal_options['moove_gdpr_strict_necessary_cookies_tab_content'.$wpml_lang] : $gdpr_default_content->moove_gdpr_get_strict_necessary_content();
                                    ?>
                                    <h3 class="tab-title"><?php echo $tab_title; ?></h3>
                                    <div class="moove-gdpr-tab-main-conent">
                                        <?php echo wpautop( $tab_content ); ?>
                                        <?php
                                            $warning_message = isset( $modal_options['moove_gdpr_strictly_necessary_cookies_warning'.$wpml_lang] ) && $modal_options['moove_gdpr_strictly_necessary_cookies_warning'.$wpml_lang] ? $modal_options['moove_gdpr_strictly_necessary_cookies_warning'.$wpml_lang] : $gdpr_default_content->moove_gdpr_get_strict_necessary_warning();
                                        ?>
                                        <?php
                                            if ( $layout === 'v2' && $warning_message ) :
                                                echo wpautop( $warning_message );
                                            endif;
                                        ?>
                                        <div class="moove-gdpr-status-bar <?php echo $strictly !== 1 ? 'gdpr-checkbox-disabled checkbox-selected' : ''; ?>">
                                            <form>
                                                <fieldset>
                                                    <label class="switch">
                                                        <span class='gdpr-acc-link'>disable</span>
                                                        <input type="checkbox" <?php echo $strictly !== 1 ? 'disabled checked="checked" ' : ''; ?> value="check" id="moove_gdpr_strict_cookies">
                                                        <span class="slider round" data-text-enable="<?php echo isset( $modal_options['moove_gdpr_modal_enabled_checkbox_label'.$wpml_lang] ) && $modal_options['moove_gdpr_modal_enabled_checkbox_label'.$wpml_lang] ? $modal_options['moove_gdpr_modal_enabled_checkbox_label'.$wpml_lang] : __('Enabled','moove-gdpr'); ?>" data-text-disabled="<?php echo isset( $modal_options['moove_gdpr_modal_disabled_checkbox_label'.$wpml_lang] ) && $modal_options['moove_gdpr_modal_disabled_checkbox_label'.$wpml_lang] ? $modal_options['moove_gdpr_modal_disabled_checkbox_label'.$wpml_lang] : __('Disabled','moove-gdpr'); ?>"></span>
                                                    </label>
                                                </fieldset>
                                            </form>
                                        </div>
                                        <!-- .moove-gdpr-status-bar -->
                                        <?php if ( $layout === 'v1' && $warning_message ) : ?>
                                            <div class="moove-gdpr-tab-main-conent moove-gdpr-strict-warning-message" style="margin-top: 10px;">
                                                <?php echo wpautop( $warning_message ); ?>
                                            </div>
                                            <!--  .moove-gdpr-tab-main-conent -->
                                            <?php endif; ?>
                                        <?php endif; ?>
                                    </div>
                                    <!--  .moove-gdpr-tab-main-conent -->
                                </div>

                            <?php if ( $enabled_3rd_party_cookies ) : ?>
                                <?php
                                    $tab_title  = isset( $modal_options['moove_gdpr_performance_cookies_tab_title'.$wpml_lang] ) && $modal_options['moove_gdpr_performance_cookies_tab_title'.$wpml_lang] ? $modal_options['moove_gdpr_performance_cookies_tab_title'.$wpml_lang] : __('3rd Party Cookies','moove-gdpr');
                                    $tab_content  = isset( $modal_options['moove_gdpr_performance_cookies_tab_content'.$wpml_lang] ) && $modal_options['moove_gdpr_performance_cookies_tab_content'.$wpml_lang] ? $modal_options['moove_gdpr_performance_cookies_tab_content'.$wpml_lang] : $gdpr_default_content->moove_gdpr_get_third_party_content();
                                ?>
                                <div id="third_party_cookies" class="moove-gdpr-tab-main" style="display:none">
                                    <h3 class="tab-title"><?php echo $tab_title; ?></h3>
                                    <div class="moove-gdpr-tab-main-conent">
                                        <?php echo wpautop( $tab_content ); ?>
                                        <div class="moove-gdpr-status-bar">
                                            <form>
                                                <fieldset class="<?php echo $strictly !== 1 ? 'fl-strenabled' : 'fl-disabled'; ?>">
                                                    <label class="switch">
                                                        <span class='gdpr-acc-link'>disable</span>
                                                        <input type="checkbox" value="check" id="moove_gdpr_performance_cookies" <?php echo $strictly !== 1 ? '' : 'disabled'; ?>>
                                                        <span class="slider round" data-text-enable="<?php echo isset( $modal_options['moove_gdpr_modal_enabled_checkbox_label'.$wpml_lang] ) && $modal_options['moove_gdpr_modal_enabled_checkbox_label'.$wpml_lang] ? $modal_options['moove_gdpr_modal_enabled_checkbox_label'.$wpml_lang] : __('Enabled','moove-gdpr'); ?>" data-text-disabled="<?php echo isset( $modal_options['moove_gdpr_modal_disabled_checkbox_label'.$wpml_lang] ) && $modal_options['moove_gdpr_modal_disabled_checkbox_label'.$wpml_lang] ? $modal_options['moove_gdpr_modal_disabled_checkbox_label'.$wpml_lang] : __('Disabled','moove-gdpr'); ?>"></span>
                                                    </label>
                                                </fieldset>
                                            </form>
                                        </div>
                                        <!-- .moove-gdpr-status-bar -->
                                        <?php
                                        $warning_message = isset( $modal_options['moove_gdpr_modal_strictly_secondary_notice'.$wpml_lang] ) && $modal_options['moove_gdpr_modal_strictly_secondary_notice'.$wpml_lang] ? $modal_options['moove_gdpr_modal_strictly_secondary_notice'.$wpml_lang] : $gdpr_default_content->moove_gdpr_get_secondary_notice();
                                        if ( $warning_message  ) :
                                            ?>
                                            <div class="moove-gdpr-tab-main-conent moove-gdpr-strict-secondary-warning-message" style="margin-top: 10px; display: none;">
                                                <?php echo wpautop( $warning_message ); ?>
                                            </div>
                                            <!--  .moove-gdpr-tab-main-conent -->
                                        <?php endif; ?>
                                    </div>
                                    <!--  .moove-gdpr-tab-main-conent -->
                                </div>
                            <?php endif; ?>

                            <?php if ( $enabled_advanced_cookies ) : ?>
                                <div id="advanced-cookies" class="moove-gdpr-tab-main" style="display:none">
                                    <?php
                                        $tab_title  = isset( $modal_options['moove_gdpr_advanced_cookies_tab_title'.$wpml_lang] ) && $modal_options['moove_gdpr_advanced_cookies_tab_title'.$wpml_lang] ? $modal_options['moove_gdpr_advanced_cookies_tab_title'.$wpml_lang] : __('Additional Cookies'.$wpml_lang,'moove-gdpr');
                                        $tab_content  = isset( $modal_options['moove_gdpr_advanced_cookies_tab_content'.$wpml_lang] ) && $modal_options['moove_gdpr_advanced_cookies_tab_content'.$wpml_lang] ? $modal_options['moove_gdpr_advanced_cookies_tab_content'.$wpml_lang] : $gdpr_default_content->moove_gdpr_get_advanced_cookies_content();
                                    ?>
                                    <h3 class="tab-title"><?php echo $tab_title; ?></h3>
                                    <div class="moove-gdpr-tab-main-conent">
                                        <?php echo wpautop( $tab_content ); ?>
                                        <div class="moove-gdpr-status-bar">
                                            <form>
                                                <fieldset class="<?php echo $strictly !== 1 ? 'fl-strenabled' : 'fl-disabled'; ?>">
                                                    <label class="switch">
                                                        <span class='gdpr-acc-link'>disable</span>
                                                        <input type="checkbox" value="check" id="moove_gdpr_advanced_cookies" <?php echo $strictly !== 1 ? '' : 'disabled'; ?>>
                                                        <span class="slider round" data-text-enable="<?php echo isset( $modal_options['moove_gdpr_modal_enabled_checkbox_label'.$wpml_lang] ) && $modal_options['moove_gdpr_modal_enabled_checkbox_label'.$wpml_lang] ? $modal_options['moove_gdpr_modal_enabled_checkbox_label'.$wpml_lang] : __('Enabled','moove-gdpr'); ?>" data-text-disabled="<?php echo isset( $modal_options['moove_gdpr_modal_disabled_checkbox_label'.$wpml_lang] ) && $modal_options['moove_gdpr_modal_disabled_checkbox_label'.$wpml_lang] ? $modal_options['moove_gdpr_modal_disabled_checkbox_label'.$wpml_lang] : __('Disabled','moove-gdpr'); ?>"></span>
                                                    </label>
                                                </fieldset>
                                            </form>
                                        </div>
                                        <!-- .moove-gdpr-status-bar -->
                                    <?php
                                    $warning_message = isset( $modal_options['moove_gdpr_modal_strictly_secondary_notice'.$wpml_lang] ) && $modal_options['moove_gdpr_modal_strictly_secondary_notice'.$wpml_lang] ? $modal_options['moove_gdpr_modal_strictly_secondary_notice'.$wpml_lang] : $gdpr_default_content->moove_gdpr_get_secondary_notice();
                                    if ( $warning_message  ) :
                                    ?>
                                        <div class="moove-gdpr-tab-main-conent moove-gdpr-strict-secondary-warning-message" style="margin-top: 10px; display: none;">
                                            <?php echo wpautop( $warning_message ); ?>
                                        </div>
                                        <!--  .moove-gdpr-tab-main-conent -->
                                    <?php endif; ?>
                                    </div>
                                    <!--  .moove-gdpr-tab-main-conent -->
                                </div>
                            <?php endif; ?>

                            <?php if ( $enabled_cookie_policy ) : ?>
                                <?php
                                    $tab_title  = isset( $modal_options['moove_gdpr_cookie_policy_tab_nav_label'.$wpml_lang] ) && $modal_options['moove_gdpr_cookie_policy_tab_nav_label'.$wpml_lang] ? $modal_options['moove_gdpr_cookie_policy_tab_nav_label'.$wpml_lang] : __('3rd Party Cookies','moove-gdpr');
                                    $tab_content  = isset( $modal_options['moove_gdpr_cookies_policy_tab_content'.$wpml_lang] ) && $modal_options['moove_gdpr_cookies_policy_tab_content'.$wpml_lang] ? $modal_options['moove_gdpr_cookies_policy_tab_content'.$wpml_lang] : $gdpr_default_content->moove_gdpr_get_cookie_policy_content();
                                ?>
                                <div id="cookie_policy_modal" class="moove-gdpr-tab-main" style="display:none">
                                    <h3 class="tab-title"><?php echo $tab_title; ?></h3>
                                    <div class="moove-gdpr-tab-main-conent">
                                        <?php echo wpautop( $tab_content ); ?>
                                    </div>
                                    <!--  .moove-gdpr-tab-main-conent -->
                                </div>
                            <?php endif; ?>
                        </div>
                        <!--  .moove-gdpr-tab-content -->
                    </div>
                    <!--  .main-modal-content -->
                    <div class="moove-gdpr-modal-footer-content">
                        <div class="moove-gdpr-button-holder">
                            <?php
                                $allow_label = isset( $modal_options['moove_gdpr_modal_allow_button_label'.$wpml_lang] ) && $modal_options['moove_gdpr_modal_allow_button_label'.$wpml_lang] ? $modal_options['moove_gdpr_modal_allow_button_label'.$wpml_lang] : __('Enable All','moove-gdpr');
                                $save_settings = isset( $modal_options['moove_gdpr_modal_save_button_label'.$wpml_lang] ) && $modal_options['moove_gdpr_modal_save_button_label'.$wpml_lang] ? $modal_options['moove_gdpr_modal_save_button_label'.$wpml_lang] : __('Save Settings','moove-gdpr');
                            ?>
                            <button class="mgbutton moove-gdpr-modal-allow-all button-visible" rel="nofollow"><?php echo $allow_label; ?></button>
                            <button class="mgbutton moove-gdpr-modal-save-settings button-visible" rel="nofollow"><?php echo $save_settings; ?></button>
                        </div>
                        <!--  .moove-gdpr-button-holder -->
                        <?php echo $layout === 'v2' ? $branding_text : ''; ?>
                    </div>
                    <!--  .moove-gdpr-modal-footer-content -->
                </div>
                <!--  .moove-gdpr-modal-right-content -->

                <div class="moove-clearfix"></div>

            </div>
            <!--  .moove-gdpr-modal-content -->
        </div>
        <!-- #moove_gdpr_cookie_modal  -->
        <?php echo ob_get_clean();
    }

    /**
     * GDPR Cookie info bar with settings icon
     * @return void
     */
    public function moove_gdpr_cookie_popup_info() {
        $gdpr_default_content = new Moove_GDPR_Content();
        $option_name    = $gdpr_default_content->moove_gdpr_get_option_name();
        $modal_options  = get_option( $option_name );
        $modal_scheme   = isset( $modal_options['moove_gdpr_colour_scheme'] ) ? ( ( intval( $modal_options['moove_gdpr_colour_scheme'] ) === 1 || intval( $modal_options['moove_gdpr_colour_scheme'] ) === 2 ) ? intval( $modal_options['moove_gdpr_colour_scheme'] ) : 1 ) : 1;

        $scheme_class = $modal_scheme === 2 ? 'moove-gdpr-light-scheme' : 'moove-gdpr-dark-scheme';
        $wpml_lang      = $gdpr_default_content->moove_gdpr_get_wpml_lang();
        ob_start(); ?>
        <div id="moove_gdpr_cookie_info_bar" class="moove-gdpr-info-bar-hidden moove-gdpr-align-center <?php echo $scheme_class; ?>">
            <div class="moove-gdpr-info-bar-container">

                <div class="moove-gdpr-info-bar-content">
                    <div class="moove-gdpr-cookie-notice">
                        <?php
                        $_content = '<p>'.__('We are using cookies to give you the best experience on our website.','moove-gdpr').'</p>'.
                        '<p>'.__('You can find out more about which cookies we are using or switch them off in [setting]settings[/setting].','moove-gdpr').'</p>';
                        $content = isset( $modal_options['moove_gdpr_info_bar_content'.$wpml_lang] ) && $modal_options['moove_gdpr_info_bar_content'.$wpml_lang] ? $modal_options['moove_gdpr_info_bar_content'.$wpml_lang] : $_content;
                        $content = str_replace('[setting]', '<span data-href="#moove_gdpr_cookie_modal" class="change-settings-button">', $content);
                        $content = str_replace('[/setting]', '</span>', $content);
                        echo $content;
                        ?>
                    </div>
                    <!--  .moove-gdpr-cookie-notice -->
                    <div class="moove-gdpr-button-holder">
                        <button class="mgbutton moove-gdpr-infobar-allow-all" rel="nofollow"><?php echo isset( $modal_options['moove_gdpr_infobar_accept_button_label'.$wpml_lang] ) && $modal_options['moove_gdpr_infobar_accept_button_label'.$wpml_lang] ? $modal_options['moove_gdpr_infobar_accept_button_label'.$wpml_lang] : __('Accept','moove-gdpr'); ?></button>
                    </div>
                    <!--  .button-container -->
                </div>
            </div>

        </div>
        <!-- #moove_gdpr_cookie_info_bar  -->
        <?php
        echo ob_get_clean();
    }

    /**
     * AJAX function to display the allowed scripts from the plugin settings page
     * @return void
     */
    public function moove_gdpr_get_scripts() {
        $strict         = intval( $_POST['strict'] ) && intval( $_POST['strict'] ) === 1 ? true : false;
        $thirdparty     = intval( $_POST['thirdparty'] ) && intval( $_POST['thirdparty'] ) === 1 ? true : false;
        $advanced       = intval( $_POST['advanced'] ) && intval( $_POST['advanced'] ) === 1 ? true : false;
        $return_scripts = '';
        $gdpr_default_content = new Moove_GDPR_Content();
        $option_name    = $gdpr_default_content->moove_gdpr_get_option_name();
        $modal_options  = get_option( $option_name );

        $third_party_scripts = array();
        $scripts_array  = array();
        if ( $thirdparty ) :

            ob_start();
            $third_party_scripts    = isset( $modal_options['moove_gdpr_third_party_header_scripts'] ) && $modal_options['moove_gdpr_third_party_header_scripts'] ? maybe_unserialize( $modal_options['moove_gdpr_third_party_header_scripts'] ) : '';
            $third_party_scripts    = apply_filters( 'moove_gdpr_third_party_header_assets', $third_party_scripts );
            echo $third_party_scripts;
            $scripts_array['header']    .= ob_get_clean();

            ob_start();
            $third_party_scripts    = isset( $modal_options['moove_gdpr_third_party_body_scripts'] ) && $modal_options['moove_gdpr_third_party_body_scripts'] ? maybe_unserialize( $modal_options['moove_gdpr_third_party_body_scripts'] ) : '';
            $third_party_scripts    = apply_filters( 'moove_gdpr_third_party_body_assets', $third_party_scripts );
            echo $third_party_scripts;
            $scripts_array['body']    .= ob_get_clean();


            ob_start();
            $third_party_scripts    = isset( $modal_options['moove_gdpr_third_party_footer_scripts'] ) && $modal_options['moove_gdpr_third_party_footer_scripts'] ? maybe_unserialize( $modal_options['moove_gdpr_third_party_footer_scripts'] ) : '';
            $third_party_scripts    = apply_filters( 'moove_gdpr_third_party_footer_assets', $third_party_scripts );
            echo $third_party_scripts;
            $scripts_array['footer']    .= ob_get_clean();

        endif;

        if ( $advanced ) :
            ob_start();
            $advanced_scripts    = isset( $modal_options['moove_gdpr_advanced_cookies_header_scripts'] ) && $modal_options['moove_gdpr_advanced_cookies_header_scripts'] ? maybe_unserialize( $modal_options['moove_gdpr_advanced_cookies_header_scripts'] ) : '';
            $advanced_scripts    = apply_filters( 'moove_gdpr_advanced_cookies_header_assets', $advanced_scripts );
            echo $advanced_scripts;
            $scripts_array['header']    .= ob_get_clean();

            ob_start();
            $advanced_scripts    = isset( $modal_options['moove_gdpr_advanced_cookies_body_scripts'] ) && $modal_options['moove_gdpr_advanced_cookies_body_scripts'] ? maybe_unserialize( $modal_options['moove_gdpr_advanced_cookies_body_scripts'] ) : '';
            $advanced_scripts    = apply_filters( 'moove_gdpr_advanced_cookies_body_assets', $advanced_scripts );
            echo $advanced_scripts;
            $scripts_array['body']    .= ob_get_clean();


            ob_start();
            $advanced_scripts    = isset( $modal_options['moove_gdpr_advanced_cookies_footer_scripts'] ) && $modal_options['moove_gdpr_advanced_cookies_footer_scripts'] ? maybe_unserialize( $modal_options['moove_gdpr_advanced_cookies_footer_scripts'] ) : '';
            $advanced_scripts    = apply_filters( 'moove_gdpr_advanced_cookies_footer_assets', $advanced_scripts );
            echo $advanced_scripts;
            $scripts_array['footer']    .= ob_get_clean();

        endif;

        echo json_encode( $scripts_array );
        die();
    }

    public static function moove_gdpr_remove_php_cookies() {
        $urlparts   = parse_url( site_url('/') );
        $domain     = preg_replace('/www\./i', '', $urlparts['host']);
        if ( isset( $_COOKIE ) && is_array( $_COOKIE ) && $domain ) :
            foreach ( $_COOKIE as $key => $value ) {

                if ( $key == 'language' || $key=='currency' ) {
                    setcookie( $key, null, -1, '/', 'www.' . $domain );
                } elseif ( $key=='_ga' || $key=='_gid' || $key=='_gat' || $key == '_gat_gtag_UA_whatever_1' ) {
                    setcookie( $key, null, -1, '/', '.' . $domain );
                } else {
                    foreach ( $_COOKIE as $key => $value ) {
                        unset( $_COOKIE[$key] );
                        if ( $key=='language'  || $key=='currency' ) {
                            setcookie( $key, null, -1, '/', 'www.' . $domain );
                        } elseif ( $key=='_ga' || $key=='_gid' || $key=='_gat' || $key == '_gat_gtag_UA_whatever_1' ) {
                            setcookie($key, null, -1, '/', '.' . $domain );
                        } else {
                            setcookie($key, null, -1, '/');
                        }
                    }
                }
            }
        endif;
    }

}
new Moove_GDPR_Controller();
