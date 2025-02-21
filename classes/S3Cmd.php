<?php

/**
 * Wrapper for s3cmd CLI tool
 * mbaenrm class
 */
class S3Cmd
{
	/** equivalent to builtin copy(), but for an s3:// destination. */
	public static function copyTo($sourceFilePath, $destS3URI):bool{
		$output=null;
		$retval=null;
		$cmdArr = array( ...self::baseCommand(), '--acl-public',
			'put', escapeshellarg($sourceFilePath), escapeshellarg($destS3URI) );

		exec(implode(' ', $cmdArr), $output, $retval);
		$success = ($retval === 0);
		if (!$success) {
			echo('ERROR uploading '.implode(' ', $output));
		}
		return $success;
	}

	/** equivalent to builtin file_exists() */
	public static function exists($s3URI):bool{
		$output = null;
		$retval = null;
		$cmdArr = array( ...self::baseCommand(), '--quiet', 'info', escapeshellarg($s3URI) );

		exec(implode(' ', $cmdArr), $output, $retval);

		// exit code 12 for NoSuchKey
		return ($retval === 0);
	}

	private static function baseCommand(){
		$accessKey = $GLOBALS['IMAGE_S3_ACCESS_KEY_ID'];
		$secretKey = $GLOBALS['IMAGE_S3_ACCESS_KEY_SECRET'];

		$cmd = array( '/usr/bin/s3cmd', "--access_key=$accessKey", "--secret_key=$secretKey" );
		if (!empty($GLOBALS['S3CMD_CONFIG_PATH'])) {
			$cmd[] = escapeshellarg('--config=' . $GLOBALS['S3CMD_CONFIG_PATH']);
		}
		return $cmd;
	}
}