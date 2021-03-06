<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       Appointy.com
 * @since      3.0.1
 *
 * @package    Appointy_appointment_scheduler
 * @subpackage Appointy_appointment_scheduler/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Appointy_appointment_scheduler
 * @subpackage Appointy_appointment_scheduler/admin
 * @author     Appointy <lav@appointy.com>
 * @author     Appointy <shikhar.v@appointy.com>
 */
class Appointy_appointment_scheduler_Admin
{

    /**
     * The ID of this plugin.
     *
     * @since    3.0.1
     * @access   private
     * @var      string $plugin_name The ID of this plugin.
     */
    private $plugin_name;

    /**
     * The version of this plugin.
     *
     * @since    3.0.1
     * @access   private
     * @var      string $version The current version of this plugin.
     */
    private $version;


    /**
     * Helper functions required for data needed by admin plugin
     *
     * @since   3.0.1
     * @var     object $helper The helper functions required
     */
    private $helper;

    /**
     * Initialize the class and set its properties.
     *
     * @param string $plugin_name The name of this plugin.
     * @param string $version The version of this plugin.
     * @param object $helper The helper functions required
     * @since    3.0.1
     */
    public function __construct($plugin_name, $version, $helper)
    {
        $this->plugin_name = $plugin_name;
        $this->version = $version;
        $this->helper = $helper;
    }

    /**
     * Register the stylesheets for the admin area.
     *
     * @since    3.0.1
     */
    public function enqueue_styles()
    {
        wp_enqueue_style($this->plugin_name, plugin_dir_url(__FILE__) . 'css/appointy-appointment-scheduler-admin.css', array(), $this->version, 'all');
    }

    /**
     * Adds admin menu and loads the admin page
     *
     * @since    3.0.1
     */
    public function appointy_calendar_config_page()
    {
        if (function_exists('add_menu_page')) {
            add_menu_page('Appointy Calendar 2', 'Appointy Calendar', 'manage_options', __FILE__, array($this, 'appointy_calendar_main_page'));
        }
    }

    function appointy_calendar_main_page()
    {

        // check for appointy calendar table else create it
        if (!$this->helper->appointy_calendar_installed()) {
            $this->helper->set_appointy_installed($this->helper->appointy_calendar_install());
        }

        if (!$this->helper->get_appointy_installed()) {
            echo "PLUGIN NOT CORRECTLY INSTALLED, PLEASE CHECK ALL INSTALL PROCEDURE!";
            return;
        }
        ?>

        <!--  content of admin menu page  -->
        <div class="wrap">

            <?php

            $this->setup();

            if (isset($_POST["set"]) AND $_POST["set"] == "Update") {
                $this->handle_form_submit();
            }

            if (isset($_GET["uninstall"]) and $_GET["uninstall"] == "true") {
                $this->uninstall_plugin();
                return;
            }

            // Check for language in full page code
            $sel_lang_option_value = $this->helper->get_language_value($this->helper->get_language_code_from_fpc($this->helper->get_iframe_val()));
            $page_url = esc_url_raw($_SERVER["PHP_SELF"] . "?page=appointy-appointment-scheduler%2Fadmin%2Fclass-appointy-appointment-scheduler-admin.php"); // sanitize url
			$uninstall_url = $page_url."&uninstall=true";
			
            ?>

            <div id="margin-bottom"><h2>Appointy Calendar</h2></div>
            <div>
                <div id="float-left">
                    <?php
                    if (function_exists('esc_url') && function_exists('plugins_url')) {
                        echo '<img src="' . esc_url(plugins_url('img/singlePageCalendar.gif', __FILE__)) . '" >';
                    }
                    ?>
                    <br/><br/>

                    <span class="content-left">
                        <p><b>Don't have an account on Appointy?</b></p>
                        <a href="https://business.appointy.com/account/register?isgadget=2&utm_source=wordpress&utm_medium=plugin&utm_campaign=wp-plugin"
                           target="_blank"
                           class="button">&nbsp;&nbsp;Register Now. It's Free &raquo;&nbsp;&nbsp;</a><br/>
                        <br/>
                    </span>
                </div>

                <div class="content-left">

                    <form action="<?php echo esc_url($page_url); ?>" method="POST">
                        <p>
                            <b class="color-deep-blue">STEP &raquo; 1 Enter your Appointy Calendar Code(URL)</b>
                            <br/>
                            <span class="content-font">Don't have appointy username? Click here to register free.</span>
                            <br/>
                            <span class="content-font">Change "demo.appointy.com" to "{yourusername}.appointy.com"
                                  <br/>
                                  where {yourusername} is your username on Appointy.com <br/>
                              </span>
                            <br/>
                            <textarea type="text" name="code" rows="3"
                                      cols="60"><?php echo esc_url($this->helper->get_iframe_val()) ?></textarea>
                        </p>
                        <p>
                            Select language your customer speak
                            <br/>
                            <select name="language-selected">
                                <?php
                                echo $this->helper->create_language_selection($sel_lang_option_value);
                                ?>
                            </select>
                            <br/>
                            <small class="color-grey">
                                By default, the calendar would render in the above selected language. Go to settings in
                                Appointy admin area to add multiple languages.
                            </small>
                        </p>
                        <p>
                            <input type="submit" name="set" value="Update"/>
                        </p>
                    </form>

                    <p>
                        <b class="color-deep-blue">STEP &raquo; 2 Create a new page. </b>
                        <br/>
                        Goto &quot;<b>Write</b>&quot; --&gt; &quot;<b>Write Page</b>&quot;. Enter
                        a<b> Title</b> e.g. &quot;Schedule an appointment&quot; (This would be shown as a link
                        on your page. So make sure you chose the right title) and in <b>Page Content </b>write
                        {APPOINTY} (including brackets). See preview. <br/><br/>Note: If it overlaps your sidebar then
                        create a new template from your theme without sidebar and use it for Appointy page. <a
                                href=https://blog.appointy.com/tip/solution-appointy-wordpress-plugin-overlays-sidebar
                                target=_blank>Click here</a> to see step by step instructions.
                    </p>
                    <p>
                        <b class="color-deep-blue">
                            STEP &raquo; 3 You are done. Now manage Appointments and clients from admin area easily.
                        </b>
                        <br/>
                        You are all done. Now test your blog. Appointy is easy to use and your clients would love
                        scheduling with you. If you want to change your business hours, block days or times, add staff
                        or service, approve appointment etc then click the link below and login to your powerful admin
                        area on Appointy. <br/>
                        <br/>
                        <a href=<?php echo esc_url($this->helper->appointy_get_admin_url()); ?> target="_blank" class="button">&nbsp;&nbsp;
                            Goto Admin Area &raquo;&nbsp;&nbsp;</a>
                    </p>
                    <p>
                        <br/>
                        <p>
                            Uninstall Appointy Plugin: <a href=<?php echo esc_url($uninstall_url)?>>UNINSTALL</a>
                        </p>
                        <br/>
                        <br/>
                    </p>
                </div>
            </div>
        </div>

        <div id="float-clear"></div>

        <?php

    }

    function setup()
    {
        global $wpdb;

        // check if database table exists
        $d1 = $wpdb->get_var($wpdb->prepare("SELECT * FROM ".$wpdb->prefix."appointy_calendar limit 1", array()));
        if ($d1 === null) {

            // create table
            $wpdb->query($wpdb->prepare("INSERT INTO ".$wpdb->prefix."appointy_calendar (code) VALUES (%s)", $this->helper->get_iframe_val()));

        } else {

            // select code from table
            $this->helper->set_iframe_val($wpdb->get_var($wpdb->prepare("SELECT code AS code FROM ".$wpdb->prefix."appointy_calendar LIMIT 1", array())));

            // update code or iFrameVal
            if (strpos($this->helper->get_iframe_val(), "http://") !== false) {
                $newCodeHttps = str_replace("http://", "https://", $this->helper->get_iframe_val());
                $wpdb->query($wpdb->prepare("UPDATE ".$wpdb->prefix."appointy_caledar SET code = %s", $newCodeHttps));
                $this->helper->set_iframe_val(str_replace("\\", "", $newCodeHttps));
            }
        }
    }

    function handle_form_submit()
    {
        global $wpdb;

        $code = esc_url_raw(trim($_POST["code"])); // sanitize input data(URL) to be stored in database

        // validate URL
        if ($this->helper->validate_appointy_calendar_code($code)) {

            $newCode = '';
            $language_selected = sanitize_text_field($_POST['language-selected']);
            if (isset($_POST['language-selected']) && $this->helper->validate_language($language_selected)) {
                $newCode = $this->helper->change_fpac_language($language_selected, $code);
            } else {
                $newCode = $code;
            }

            $wpdb->query($wpdb->prepare("UPDATE ".$wpdb->prefix."appointy_calendar set code = %s", $newCode));
            $this->helper->set_iframe_val(str_replace("\\", "", $newCode));
        }
    }

    function uninstall_plugin()
    {
        global $wpdb;

        $wpdb->query($wpdb->prepare("DROP TABLE IF EXISTS ".$wpdb->prefix."appointy_calendar", array()));

        delete_option('appointy_calendar_privileges'); //Removing option from database...

        $installed = $this->helper->appointy_calendar_installed();

        if (!$installed) {
            echo "PLUGIN UNINSTALLED. NOW DE-ACTIVATE PLUGIN.<br />";
            echo " <a href=plugins.php>CLICK HERE</a>";
            return;
        } else {
            echo "PROBLEMS WITH UNINSTALL FUNCTION.";
        }
    }
}