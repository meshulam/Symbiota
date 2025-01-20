<?php
/* bellatlas: site-specific file, in upstream's .gitignore */
include_once('/etc/bellatlas/symbini_local.php');

class MySQLiConnectionFactory {
	/* In symbini_local.php:
	$DB_SERVERS = array(
		array(
			'type' => 'readonly',
			'host' => 'localhost',
			'username' => 'symbiota_ro',
			'password' => 'pw',
			'database' => 'symbiota',
			'port' => '3306',
			'charset' => 'utf8'
		),
		array(
			'type' => 'write',
			'host' => 'localhost',
			'username' => 'symbiota_rw',
			'password' => 'pw',
			'database' => 'symbiota',
			'port' => '3306',
			'charset' => 'utf8'
		),
	);
	*/

	public static function getCon($type) {
		// Figure out which connections are open, automatically opening any connections
		// which are failed or not yet opened but can be (re)established.
		global $DB_SERVERS;
		for ($i = 0, $n = count($DB_SERVERS); $i < $n; $i++) {
			$server = $DB_SERVERS[$i];
			if($server['type'] == $type){
				try{
					$connection = new mysqli($server['host'], $server['username'], $server['password'], $server['database'], $server['port']);
					if(isset($server['charset']) && $server['charset']) {
						if(!$connection->set_charset($server['charset'])){
							throw new Exception('Error loading character set '.$server['charset'].': '.$connection->error);
						}
					}
					return $connection;
				}
				catch(Exception $e){
					echo $e->getMessage();
					return null;
				}
			}
		}
	}
}
?>