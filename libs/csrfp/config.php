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
		"GET" => 3, // custom error message
		"POST" => 3,
	),
	"errorRedirectionPage" => "",
	"customErrorMessage" => '<h2>CSRF validation failed</h2><p>Try refreshing the last page and re-submitting. If the error persists, please contact Bell Museum staff.</p>',
	"jsUrl" => "/js/csrfprotector.js",
	"tokenLength" => 12,
	"cookieConfig" => array(
		'path' => '/',
		//"domain" => '',
		'secure' => true,
		'expire' => 3600,
	),
	"disabledJavascriptMessage" => "This site attempts to protect users against <a href=\"https://owasp.org/www-community/attacks/csrf\">
		Cross-Site Request Forgeries </a> attacks. In order to do so, you must have JavaScript enabled in your web browser otherwise this site will fail to work correctly for you.
		 See details of your web browser for how to enable JavaScript.",
	"verifyGetFor" => array()
);
