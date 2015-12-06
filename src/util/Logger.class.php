<?php
/**
 * This file represents the logger class.
 *
 * @author David Pauli <contact@david-pauli.de>
 * @since 0.0.0
 */
namespace ep6;
/**
 * This is a static object to log messages while executing.
 *
 * @author David Pauli <contact@david-pauli.de>
 * @since 0.0.0
 * @package ep6
 * @subpackage Util
 * @example examples\logMessages.php Use the Logger to log messages.
 */
class Logger {

	/** @var String The log level describes which error should be logged. */
	private static $LOGLEVEL = "NOTIFICATION";

	/** @var String The output value is set to configure where logging message is made. */
	private static $OUT = "SCREEN";

	/**
	 * This function prints notifications.
	 *
	 * @author David Pauli <contact@david-pauli.de>
	 * @since 0.0.0
	 * @api
	 * @param String message The message to print.
	 */
	public static function notify($message) {
		
		if (InputValidator::isEmpty($message)) {
			return;
		}
		if (self::$LOGLEVEL == "ERROR" || self::$LOGLEVEL == "WARNING") {
			return;
		}
		self::printMessage($message, "NOTIFICATION");
	}

	/**
	 * This function prints warnings.
	 *
	 * @author David Pauli <contact@david-pauli.de>
	 * @since 0.0.0
	 * @api
	 * @param String message The message to print.
	 */
	public static function warning($message) {
		
		if (InputValidator::isEmpty($message)) {
			return;
		}
		if (self::$LOGLEVEL == "ERROR") {
			return;
		}
		self::printMessage($message, "WARNING");
		self::printStacktrace();
	}

	/**
	 * This function prints errors.
	 *
	 * @author David Pauli <contact@david-pauli.de>
	 * @since 0.0.0
	 * @api
	 * @param String message The message to print.
	 */
	public static function error($message) {
		
		if (InputValidator::isEmpty($message)) {
			return;
		}
		self::printMessage($message, "ERROR");
		self::printStacktrace();
	}

	/**
	 * This function definitly prints the message.
	 *
	 * @author David Pauli <contact@david-pauli.de>
	 * @since 0.0.0
	 * @api
	 * @param String message The message to print.
	 */
	public static function force($message) {
		
		if (InputValidator::isEmpty($message)) {
			return;
		}
		self::printMessage($message);
	}

	/**
	 * This function finally prints the message.
	 *
	 * @author David Pauli <contact@david-pauli.de>
	 * @since 0.0.0
	 * @param String message The message to print.
	 * @param String level The message level.
	 */
	private static function printMessage($message, $level = "FORCE") {
		
		if (InputValidator::isEmpty($message) || self::$LOGLEVEL == "NONE") {
			return;
		}

		switch (self::$OUT) {
			case "SCREEN":
				echo "******************** " . $level . " ********************<br/>\n";
				if ($level == "ERROR") echo "<strong>AN ERROR OCCURED:</strong><br/>\n";
				if ($level == "WARNING") echo "<strong><u>WARNING:</u></strong> ";
				if (is_array($message)) {
					echo "<pre>\n";
					var_dump($message);
					echo "</pre><br/>\n";
				}
				else {
					echo $message . "<br/>\n";

				}
				break;
		}
	}

	/**
	 * This function prints the stacktrace.
	 *
	 * @author David Pauli <contact@david-pauli.de>
	 * @since 0.0.0
	 */
	private static function printStacktrace() {
		$stack = debug_backtrace();

		foreach ($stack as $stackentry) {
			echo "Function <strong>" . $stackentry['function'] . "</strong> ";
			echo "(" . join(", ", $stackentry['args']) . ") ";
			echo "called at <strong>" . $stackentry["file"] . "</strong> line " . $stackentry["line"] . "</br>";
		}
	}

	/**
	 * This function sets the log level.
	 * 
	 * The following elements are possible:
	 * <ul>
	 *   <li><strong>NOTIFICATION</strong> - Print all log messages.</li>
	 *   <li><strong>WARNING</strong> - Print warnings and more.</li>
	 *   <li><strong>ERROR</strong> - Print only errors.</li>
	 *   <li><strong>NONE</strong> - No log messages.</li>
	 * </ul>
	 *
	 * @author David Pauli <contact@david-pauli.de>
	 * @since 0.0.0
	 * @api
	 * @param String $level	The log level to set.
	 */
	public static function setLogLevel($level) {
		if (!InputValidator::isLogLevel($level)) {
			return;
		}
		self::$LOGLEVEL = $level;
	}

	/**
	 * This function sets the output ressource.
	 * 
	 * The following elements are possible.
	 * <ul>
	 *   <li><strong>SCREEN</strong> - Print on running display (e.h. browser).</li>
	 * </ul>
	 *
	 * @author David Pauli <contact@david-pauli.de>
	 * @since 0.0.0
	 * @api
	 * @param String $out The resource to output.
	 */
	public static function setOutput($out) {
		if (!InputValidator::isOutputRessource($out)) {
			return;
		}
		self::$OUT = $out;
	}
}

?>