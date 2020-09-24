<?php


class Appointy_helper_functions
{
    public $appointy_installed, $appointy_calendar_privileges, $iFrameVal, $poweredby;

    public function __construct()
    {
        $this->appointy_installed = true;
        $this->appointy_calendar_privileges = 0;
        $this->iFrameVal = "https://demo.appointy.com/?isGadget=1";
        $this->poweredby = "<div style='font-size:11px;'>Powered by <a href='https://www.appointy.com/?isGadget=2&utm_source=wordpress&utm_medium=plugin&utm_campaign=wp-plugin' target = '_Blank' alt='Online Appointment Scheduling Software'>Appointy - Online Appointment Scheduling Software</a></div>";
    }

    function get_language_code_array(){
        $language['default'] = 'default';
        $language['bulgarian'] = 'bg-BG'; //
        $language['chinese'] = 'zh-CN';
        $language['chinese_(Traditional)'] = 'zh-Hant';
        $language['croatian'] = 'hr';
        $language['czech_(Republic)'] = 'cs';
        $language['danish'] = 'da-DK';
        $language['dutch'] = 'nl-NL';
        $language['english_(US)'] = 'en-US';
        $language['english_(UK)'] = 'en-GB';
        $language['english_(Australia)'] = 'en-AU';
        $language['estonian'] = 'et-EE';
        $language['french'] = 'fr-FR' ;
        $language['finnish'] = 'fi'; //
        $language['german'] = 'de-DE' ; //
        $language['greek'] = 'el-GR';
        $language['hungarian'] = 'hu-HU';
        $language['italian'] = 'it-IT' ; //
        $language['japanese'] = 'ja';
        $language['lithuanian'] = 'lt-LT';
        $language['latvian'] = 'lv-LV';
        $language['nynorsk'] = 'no'; //*
        $language['portuguese'] = 'pt'; //
        $language['portuguese_(Brazil)'] = 'pt-BR';
        $language['polish'] = 'pl-PL'; //
        $language['russian'] = 'ru-RU'; //
        $language['romanian'] = 'ro-RO'; //
        $language['spanish'] = 'es'; //
        $language['slovenian'] = 'sl-SI';
        $language['serbian_(Cyrilic)'] = 'sr-Cyrl-BA';
        $language['serbian_(Latin)'] = 'sr';
        $language['slovak'] = 'sk' ; //
        $language['swedish'] = 'sv-SE';
        $language['turkish'] = 'tr-TR';

        return $language;
    }

    public function get_language_code($language)
    {
        $languageCode = $this->get_language_code_array();

        $str = '/ChangeLanguage.aspx?lan=';
        // Return default if no key is exist
        $lanValue = isset($languageCode[$language]) ? $languageCode[$language] :'default';
        $lanValue = $str.$lanValue;
        return $lanValue;
    }

    function get_language_value_array(){
        $language['default'] = 'default';
        $language['bg-BG'] = 'bulgarian'; //
        $language['zh-CN'] = 'chinese';
        $language['zh-Hant'] = 'chinese_(Traditional)';
        $language['hr'] = 'croatian';
        $language['cs'] = 'czech_(Republic)';
        $language['da-DK'] = 'danish';
        $language['nl-NL'] = 'dutch';
        $language['en-US'] = 'english_(US)';
        $language['en-GB'] = 'english_(UK)';
        $language['en-AU'] = 'english_(Australia)';
        $language['et-EE'] = 'estonian';
        $language['fr-FR'] = 'french';
        $language['fi'] = 'finnish'; //
        $language['de-DE'] = 'german'; //
        $language['el-GR'] = 'greek';
        $language['hu-HU'] = 'hungarian';
        $language['it-IT'] = 'italian'; //
        $language['ja'] = 'japanese';
        $language['lt-LT'] = 'lithuanian';
        $language['lv-LV'] = 'latvian';
        $language['no'] = 'nynorsk'; //*
        $language['pt'] = 'portuguese'; //
        $language['pt-BR'] = 'portuguese_(Brazil)';
        $language['pl-PL'] = 'polish'; //
        $language['ru-RU'] = 'russian'; //
        $language['ro-RO'] = 'romanian'; //
        $language['es'] = 'spanish'; //
        $language['sl-SI'] = 'slovenian';
        $language['sr-Cyrl-BA'] = 'serbian_(Cyrilic)';
        $language['sr'] = 'serbian_(Latin)';
        $language['sk'] = 'slovak'; //
        $language['sv-SE'] = 'swedish';
        $language['tr-TR'] = 'turkish';

        return $language;
    }

    public function get_language_value($lan)
    {
        $language = $this->get_language_value_array();
        // Return default if no key is exist
        $lanValue = isset($language[$lan]) ? $language[$lan] :'default';
        return $lanValue;

    }

    public function get_language_code_from_fpc($code){
        preg_match("/.appointy.com\/ChangeLanguage\.aspx\?lan\=(.*)\&isGadget=1/", $code, $output_array);
        $lanValue = '';
        if(count($output_array) > 1){
            $lanValue = $output_array[1];
        }
        return $lanValue;
    }

    public function change_fpac_language($language, $code)
    {
        $newCode = $code;
        $languageCode = $this->get_language_code($language);
        if(preg_match('(/ChangeLanguage.aspx)', $code))//.appointy.com\/\?isGadget=1
        {
            $code = preg_replace("/.appointy.com(.*)\&isGadget=1/", ".appointy.com/?isGadget=1", $code);
            $newCode = $code;
        }
        // if language is set to default then do nothing
        // because code is already reset in previous step
        if($language != "default"){
            $codestr = preg_split('(\.appointy\.com\/\?)', $code);
            $newCode = $codestr[0].'\.appointy\.com'.$languageCode.'\&'.$codestr[1];
        }
        return $newCode;
    }

    public function create_language_selection($selLang){
        // $language['default'] = 'default';
        // $temp = get_language_code_array();
        // array_push($language, $temp);
        $language = $this->get_language_code_array();
        $str = '';
        foreach ($language as $key => $value) {
            # code...
            $str .= "<option value='".$key."'". ($selLang == $key?"selected":"").">".ucfirst(str_replace('_',' ',$key)).'</option>';
        }
        return $str;
    }

    public function validate_language($language_selected) {

        $language_code = $this->get_language_code_array();
        if (isset($language_code[$language_selected])) {
            return true;
        } else {
            return false;
        }
    }

    public function validate_appointy_calendar_code($code) {

        if (wp_http_validate_url($code)) {
            $type1 = preg_match("/.appointy.com\/ChangeLanguage\.aspx\?lan\=(.*)\&isGadget=1/", $code);
            $type2 = preg_match("/.appointy.com\/\?isGadget=1/", $code);
            if ($type1 == 0 && $type2 == 0) { // if does not matches any valid code type
                return false;
            }
            return true;
        }

        return false;
    }

    public function appointy_calendar_code( $code )
    {
        if( strpos($code, "<iframe") === FALSE )
            return false;
        else
            return true;
    }

    public function appointy_get_admin_url()
    {
        $adminURL = preg_match("/https?:\/\/(.*).com/", $this->iFrameVal, $matches);
        if ($adminURL = true)
        {
            $adminURL = htmlentities($matches['0']);
            $adminURL = $adminURL .'/admin';
        }
        return $adminURL;
    }

    public function appointy_calendar_installed()
    {
        global $wpdb;

        $install = $wpdb->get_var($wpdb->prepare("SHOW TABLES LIKE %s", $wpdb->prefix."appointy_calendar"));
        if( $install === NULL )
            return false;
        else
            return true;
    }

    // creates appointy calendar table in to database
    // contains code for calender : iframe link
    public function appointy_calendar_install()
    {
        global $wpdb;

        $query = $wpdb->prepare("CREATE TABLE ".$wpdb->prefix."appointy_calendar (
			                            calendar_id INT(11) NOT NULL auto_increment,
			                            code TEXT NOT NULL,
			                            PRIMARY KEY( calendar_id )
		                            )
	                            ", array());

        $wpdb->query($query);

        //Using option for appointy calendar plugin!
        add_option( "appointy_calendar_privileges", "2" );

        if( !$this->appointy_calendar_installed() )
            return false;
        else
            return true;
    }

    public function get_appointy_code() {
        global $wpdb;

        $code = $wpdb->get_var( $wpdb->prepare("SELECT code AS code FROM ".$wpdb->prefix."appointy_calendar LIMIT 1", array()));
        return $code;
    }

    /**
     * @return mixed
     */
    public function get_appointy_installed()
    {
        return $this->appointy_installed;
    }

    /**
     * @param mixed $appointy_installed
     */
    public function set_appointy_installed($appointy_installed)
    {
        $this->appointy_installed = $appointy_installed;
    }

    /**
     * @return mixed
     */
    public function get_appointy_calendar_privileges()
    {
        return $this->appointy_calendar_privileges;
    }

    /**
     * @param mixed $appointy_calendar_privileges
     */
    public function set_appointy_calendar_privileges($appointy_calendar_privileges)
    {
        $this->appointy_calendar_privileges = $appointy_calendar_privileges;
    }

    /**
     * @return mixed
     */
    public function get_iframe_val()
    {
        return esc_url_raw($this->iFrameVal);
    }

    /**
     * @param mixed $iFrameVal
     */
    public function set_iframe_val($iFrameVal)
    {
        $this->iFrameVal = $iFrameVal;
    }

    /**
     * @return mixed
     */
    public function get_poweredby()
    {
        return $this->poweredby;
    }

    /**
     * @param mixed $poweredby
     */
    public function set_poweredby($poweredby)
    {
        $this->poweredby = $poweredby;
    }
}