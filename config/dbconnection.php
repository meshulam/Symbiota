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

	public static function getCon($type) {
		$server = self::getServerDef($type);

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
			return $connection;
		}
	}
}
?>