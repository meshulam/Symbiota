<?php

/**
 * Wrapper for s3cmd CLI tool
 * mbaenrm class
 */
class S3Cmd
{
	/** equivalent to builtin copy(), but for an s3:// destination. */
	public static function copyTo($sourceFilePath, $destS3URI):bool{
		list($return_code, $stdout, $stderr) = self::run(array('put', '--acl-public', $sourceFilePath, $destS3URI));

		$success = ($return_code === 0);
		if (!$success) {
			echo("ERROR uploading, source:$sourceFilePath dest:$destS3URI stderr: $stderr, stdout: $stdout");
		}
		return $success;
	}

	/** equivalent to builtin file_exists() */
	public static function exists($s3URI):bool{
		list($return_code, $stdout, $stderr) = self::run(array('info', '--quiet', $s3URI));

		// exit code 12 for NoSuchKey
		return ($return_code === 0);
	}

	/** equivalent to builtin unlink() */
	public static function unlink($s3URI):bool{
		list($return_code, $stdout, $stderr) = self::run(array('del', $s3URI));
		return ($return_code === 0);
	}

	/**
	 * $args: array of strings, s3cmd subcommand and args
	 * returns: array($return_code, $stdout, $stderr)
	 */
	private static function run($args){
		$cmd = array(...self::baseCommand(), ...$args);
		$descriptors = array(1 => array('pipe', 'w'), 2 => array('pipe', 'w'));

		$proc = proc_open($cmd, $descriptors, $pipes);

		$stdout = stream_get_contents($pipes[1]);
		fclose($pipes[1]);

		$stderr = stream_get_contents($pipes[2]);
		fclose($pipes[2]);

		$return_code = (int)proc_close($proc);

		return array($return_code, $stdout, $stderr);
	}

	private static function baseCommand(){
		$accessKey = $GLOBALS['IMAGE_S3_ACCESS_KEY_ID'];
		$secretKey = $GLOBALS['IMAGE_S3_ACCESS_KEY_SECRET'];

		$cmd = array( '/usr/bin/s3cmd', "--access_key=$accessKey", "--secret_key=$secretKey" );
		if (!empty($GLOBALS['S3CMD_CONFIG_PATH'])) {
			$cmd[] = '--config=' . $GLOBALS['S3CMD_CONFIG_PATH'];
		}
		return $cmd;
	}
}