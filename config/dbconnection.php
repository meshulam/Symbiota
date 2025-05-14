<?php
/* bellatlas: site-specific file, in upstream's .gitignore */
include_once('/etc/bellatlas/symbini_local.php');

class MySQLiConnectionFactory {
	private static function getServerDef($type) {
		if($type == 'readonly'){
			return array(
				'type' => 'readonly',
				'host' => $GLOBALS['DB_HOST'],
				'username' => $GLOBALS['DB_RO_USERNAME'],
				'password' => $GLOBALS['DB_RO_PASSWORD'],
				'database' => $GLOBALS['DB_DATABASE'],
				'port' => $GLOBALS['DB_PORT'],
				'ssl' => $GLOBALS['DB_SSL'],
			);
		}
		if($type == 'write'){
			return array(
				'type' => 'write',
				'host' => $GLOBALS['DB_HOST'],
				'username' => $GLOBALS['DB_RW_USERNAME'],
				'password' => $GLOBALS['DB_RW_PASSWORD'],
				'database' => $GLOBALS['DB_DATABASE'],
				'port' => $GLOBALS['DB_PORT'],
				'ssl' => $GLOBALS['DB_SSL'],
			);
		}
	}

	/**
	 * OIT MySQL default SQL_MODE: ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_ENGINE_SUBSTITUTION
	 *
	 * Symbiota assumes the following, which differ from the default in modern MySQL versions:
	 * - NO_ZERO_IN_DATE disabled, Symbiota relies on zero month/day semantics: https://github.com/Symbiota/Symbiota/issues/130
	 *   Note from MySQL docs (https://dev.mysql.com/doc/refman/8.4/en/sql-mode.html#sqlmode_no_zero_in_date):
	 *   "NO_ZERO_IN_DATE is deprecated. [...] You should expect it to be removed in a future MySQL release as a separate mode name and
	 *   its effect included in the effects of strict SQL mode."
	 * - ONLY_FULL_GROUP_BY disabled, Symbiota has many queries which don't conform to this requirement.
	 */
	static $SQL_MODE = 'STRICT_TRANS_TABLES,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_ENGINE_SUBSTITUTION';

	public static function getCon($type) {
		$server = self::getServerDef($type);

		// Disable MYSQLI_REPORT_STRICT, which is the default in PHP 8.1+.
		// Symbiota checks boolean result status instead of catching exceptions, so it's not compatible with the new default
		mysqli_report(MYSQLI_REPORT_ERROR);

		if ($server){
			$connection = mysqli_init();
			if($server['ssl']) {
				$caCertPath = $GLOBALS['CA_CERT_PATH'];

				$connection->options(MYSQLI_OPT_SSL_VERIFY_SERVER_CERT, true);
				$connection->ssl_set(NULL, NULL, $caCertPath, NULL, NULL);
			}
			if (!$connection->real_connect($server['host'], $server['username'], $server['password'], $server['database'], $server['port'])) {
				throw new Exception('error connecting to DB: '.mysqli_connect_errno().mysqli_connect_error());
			};
			if(!$connection->set_charset('utf8')){
				throw new Exception('Error loading character set utf8: '.$mysqli->error);
			}
			$connection->query("SET SESSION sql_mode = '" . MySQLiConnectionFactory::$SQL_MODE . "'");
			return $connection;
		}
	}
}
?>