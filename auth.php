<?php

/**
 * @author Jean Pierre Ducassou
 * @license http://www.gnu.org/copyleft/gpl.html GNU Public License
 * @package moodle multiauth
 *
 * Authentication Plugin: Authentication throught SOAP webservice
 *
 */

if (!defined('MOODLE_INTERNAL')) {
    die('Direct access to this script is forbidden.');    ///  It must be included from a Moodle page
}

require_once($CFG->libdir.'/authlib.php');
require_once(dirname(__FILE__) . '/lib/nusoap.php');

/**
 * Plugin for SOAP authentication.
 */
class auth_plugin_soap extends auth_plugin_base {

    /**
     * Constructor.
     */
    function auth_plugin_soap() {
        $this->authtype = 'soap';
        $this->roleauth = 'auth_soap';
        $this->errorlogtag = '[AUTH SOAP] ';
        $this->pluginconfig = 'auth/soap';
        $this->config = get_config($this->pluginconfig);

        if(empty($this->config->encoding)) {
            $this->config->encoding = 'utf-8';
        }
    }

    /**
     * Returns true if the username and password work or don't exist and false
     * if the user exists and the password is wrong.
     *
     * @param string $username The username
     * @param string $password The password
     * @return bool Authentication success or failure.
     */
    function user_login ($username, $password) {
        global $CFG, $DB;

        if (!$username or !$password) {    // Don't allow blank usernames or passwords
            return false;
        }

        $textlib = textlib_get_instance();
        $extusername = $textlib->convert($username, 'utf-8', $this->config->encoding);
        $extpassword = $textlib->convert($password, 'utf-8', $this->config->encoding);

        // SOAP client creation
        $client = new nusoap_client($this->config->url, true);
        $err = $client->getError();
        if ($err) {
            error_log($err);
            return false;
        }

        $client->soap_defencoding = $this->config->encoding;

        $params = array();
        $params[$this->config->username_field] = $extusername;
        $params[$this->config->password_field] = $extpassword;

        $params['ou']= 'Academics';
        $params['sistema'] = 'koha';
        $params['claveHash'] = '0P1a2s3s4w5o6r7d8PaabrcadLeDfAgPh';

        $result = $client->call($this->config->method_name, $params);
        $err = $client->getError();
        if ($err) {
             error_log($err);
            return false;
        }

        return $result[$this->config->result_name] == 'true';

    }

    /**
     * Updates the user's password.
     *
     * called when the user password is updated.
     *
     * @param  object  $user        User table object
     * @param  string  $newpassword Plaintext password
     * @return boolean result
     *
     */
    function user_update_password($user, $newpassword) {
/*
        $user = get_complete_user_data('id', $user->id);
        return update_internal_user_password($user, $newpassword);
*/
    }

    function prevent_local_passwords() {
        return false;
    }

    /**
     * Returns true if this authentication plugin is 'internal'.
     *
     * @return bool
     */
    function is_internal() {
        return true;
    }

    /**
     * Returns true if this authentication plugin can change the user's
     * password.
     *
     * @return bool
     */
    function can_change_password() {
        return false;
    }

    /**
     * Returns the URL for changing the user's pw, or empty if the default can
     * be used.
     *
     * @return moodle_url
     */
    function change_password_url() {
        return null;
    }

    /**
     * Returns true if plugin allows resetting of internal password.
     *
     * @return bool
     */
    function can_reset_password() {
        return false;
    }

    /**
     * Prints a form for configuring this authentication plugin.
     *
     * This function is called from admin/auth.php, and outputs a full page with
     * a form for configuring this plugin.
     *
     * @param array $page An object containing all the data for this page.
     */
    function config_form($config, $err, $user_fields) {
        include "config.html";
    }

    /**
     * Processes and stores configuration data for this authentication plugin.
     */
    function process_config($config) {
        // Save settings
        foreach ($config as $key => $value)
            set_config($key, trim($config->$key), $this->pluginconfig);
        return true;
    }

}


