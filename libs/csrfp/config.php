<?php
/**
 * Configuration file for CSRF Protector
 * Necessary configurations are (library would throw exception otherwise)
 * ---- failedAuthAction
 * ---- jsUrl
 * ---- tokenLength
 */
return array(
	"CSRFP_TOKEN" => "",
	"failedAuthAction" => array(
		"GET" => 0,
		"POST" => 0,
	),
	"errorRedirectionPage" => "",
	"customErrorMessage" => "CSRF validation failed",
	"jsUrl" => "/js/csrfprotector.js",
	"tokenLength" => 12,
	"cookieConfig" => array(
		"path" => '/',
		//"domain" => '',
		"secure" => true,
		"expire" => '1800',
	),
	"disabledJavascriptMessage" => "This site attempts to protect users against <a href=\"https://owasp.org/www-community/attacks/csrf\">
		Cross-Site Request Forgeries </a> attacks. In order to do so, you must have JavaScript enabled in your web browser otherwise this site will fail to work correctly for you.
		 See details of your web browser for how to enable JavaScript.",
	"verifyGetFor" => array()
);
