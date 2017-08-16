<?php
/**
 * SSO Client
 *
 * @author  muhamad rifki
 */

require_once __DIR__.'/vendor/autoload.php';
require_once __DIR__.'/config.php';

// Enable debugging
phpCAS::setDebug();

// Enable verbose error messages. Disable in production!
phpCAS::setVerbose(true);

// Initialize phpCAS
phpCAS::client(CAS_VERSION_2_0, CAS_SERVER_HOST, CAS_SERVER_PORT, CAS_SERVER_URI);

// For quick testing you can disable SSL validation of the CAS server.
// THIS SETTING IS NOT RECOMMENDED FOR PRODUCTION.
// VALIDATING THE CAS SERVER IS CRUCIAL TO THE SECURITY OF THE CAS PROTOCOL!
phpCAS::setNoCasServerValidation();

class SSO
{
    public function __construct()
    {}

    /**
    * Authenticate the user.
    *
    * @return bool Authentication
    */
    public static function authenticate()
    {
        return phpCAS::forceAuthentication();
    }

    /**
    * Check if the user is already authenticated.
    *
    * @return bool Authentication
    */
    public static function checkAuth()
    {
        return phpCAS::checkAuthentication();
    }

    /**
    * Logout from SSO with URL redirection options
    * @return void
    */
    public static function logout($uri = '')
    {
        if (!empty($uri)) {
            $checkFirstUri = substr($uri, 0, 1);
            if ($checkFirstUri == '/') {
                $url = BASE_URL . $uri;
            }
            else {
                $url = BASE_URL .'/'. $uri;
            }
        }
        else {
            $url = BASE_URL;
        }

        phpCAS::logout(['service' => $url]);
    }

    /**
    * get user email address
    * @return string
    */
    public static function getUser()
    {
        if (self::checkAuth()) {
            return phpCAS::getUser();
        }
        return '';
    }
}
