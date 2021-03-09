<?php
/**
 * Copyright (c) 2014 Robin Appelman <icewind@owncloud.com>
 * This file is licensed under the Licensed under the MIT license:
 * http://opensource.org/licenses/MIT
 */

namespace Icewind\SMB\Exception;

class Exception extends \Exception {
	public static function unknown(?string $path, $error) {
		$message = 'Unknown error (' . $error . ')';
		if ($path) {
			$message .= ' for ' . $path;
		}

		return new Exception($message, is_string($error) ? 0 : $error);
	}

	public static function fromMap(array $exceptionMap, $error, ?string $path): Exception {
		if (isset($exceptionMap[$error])) {
			$exceptionClass = $exceptionMap[$error];
			if (is_numeric($error)) {
				return new $exceptionClass($path, $error);
			} else {
				return new $exceptionClass($path);
			}
		} else {
			return Exception::unknown($path, $error);
		}
	}
}
