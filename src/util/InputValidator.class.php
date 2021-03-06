<?php
/**
 * This file represents the input validator class.
 *
 * @author David Pauli <contact@david-pauli.de>
 * @since 0.0.0
 */
namespace ep6;
/**
 * This class, used by a static way, checks whether a value is valid.
 *
 * @author David Pauli <contact@david-pauli.de>
 * @since 0.0.0
 * @since 0.1.0 Add function to add float values.
 * @package ep6
 * @subpackage Util
 * @example examples\useValidator.php Test input values with the static Validator object.
 */
class InputValidator {

	/**
	 * Checks whether a parameter is a host.
	 *
	 * @author David Pauli <contact@david-pauli.de>
	 * @since 0.0.0
	 * @api
	 * @param String $parameter String to check.
	 * @return boolean True if the string is a host, false if not.
	 */
	public static function isHost($parameter) {

		return self::isMatchRegex($parameter, "/^([a-zA-Z0-9]([a-zA-Z0-9\\-]{0,61}[a-zA-Z0-9])?\\.)+[a-zA-Z]{2,6}/", "host")
			&& !self::isEmpty($parameter);
	}

	/**
	 * Checks whether a parameter is a shop.
	 *
	 * @author David Pauli <contact@david-pauli.de>
	 * @since 0.0.0
	 * @api
	 * @param String $parameter String to check.
	 * @return boolean True if the string is a shop, false if not.
	 */
	public static function isShop($parameter) {

		return !self::isEmpty($parameter);
	}

	/**
	 * Checks whether a parameter is a OAuth authentification token.
	 * TODO: Finalize this function.
	 *
	 * @author David Pauli <contact@david-pauli.de>
	 * @since 0.0.0
	 * @api
	 * @param String $parameter String to check.
	 * @return boolean True if the string is a OAuth authentification token, false if not.
	 */
	public static function isAuthToken($parameter) {

		return !self::isEmpty($parameter);
	}

	/**
	 * Checks whether a parameter is a localization string.
	 *
	 * @author David Pauli <contact@david-pauli.de>
	 * @since 0.0.0
	 * @api
	 * @param String $parameter String to check.
	 * @return boolean True if the string is a localization string, false if not.
	 */
	public static function isLocale($parameter) {

		return self::isMatchRegex($parameter, "/^[a-z]{2,4}_[A-Z]{2,3}$/", "Locale")
			&& !self::isEmpty($parameter);
	}

	/**
	 * Checks whether a parameter is a currency string.
	 *
	 * @author David Pauli <contact@david-pauli.de>
	 * @since 0.0.0
	 * @api
	 * @param String $parameter String to check.
	 * @return boolean True if the string is a currency string, false if not.
	 */
	public static function isCurrency($parameter) {

		return self::isMatchRegex($parameter, "/^[A-Z]{3}$/", "Currency")
			&& !self::isEmpty($parameter);
	}

	/**
	 * Checks whether a parameter is a HTTP request method.
	 *
	 * @author David Pauli <contact@david-pauli.de>
	 * @since 0.0.0
	 * @since 0.1.0 Use HTTPRequestMethod enum.
	 * @api
	 * @param String $parameter String to check.
	 * @return boolean True if the string is a HTTP request method, false if not.
	 */
	public static function isRequestMethod($parameter) {

		return self::isMatchRegex($parameter, "/^(GET|POST|PUT|DELETE|PATCH)/", "HTTP request method")
			&& !self::isEmpty($parameter);
	}

	/**
	 * Checks whether a parameter is an output ressource.
	 *
	 * @author David Pauli <contact@david-pauli.de>
	 * @since 0.0.0
	 * @since 0.1.0 Use LogOutput enum.
	 * @api
	 * @param String $parameter String to check.
	 * @return boolean True if the string is an output ressource, false if not.
	 */
	public static function isOutputRessource($parameter) {

		return self::isMatchRegex($parameter, "/^(SCREEN)/", "output ressource")
			&& !self::isEmpty($parameter);
	}

	/**
	 * Checks whether a parameter is a log level.
	 *
	 * @author David Pauli <contact@david-pauli.de>
	 * @since 0.0.0
	 * @since 0.1.0 Use LogLevel enum.
	 * @api
	 * @param String $parameter String to check.
	 * @return boolean True if the string is a log level, false if not.
	 */
	public static function isLogLevel($parameter) {

		return self::isMatchRegex($parameter, "/^(NOTIFICATION|WARNING|ERROR|NONE)/", "log level")
			&& !self::isEmpty($parameter);
	}

	/**
	 * Checks whether a parameter is a REST command.
	 *
	 * @author David Pauli <contact@david-pauli.de>
	 * @since 0.0.0
	 * @api
	 * @param String $parameter String to check.
	 * @return boolean True if the string is a REST command, false if not.
	 */
	public static function isRESTCommand($parameter) {

		return !self::isEmpty($parameter);
	}

	/**
	 * Checks whether a parameter is a JSON string.
	 *
	 * @author David Pauli <contact@david-pauli.de>
	 * @since 0.0.0
	 * @api
	 * @param String $parameter String to check.
	 * @return boolean True if the string is a JSON string, false if not.
	 */
	public static function isJSON($parameter) {
		return !is_null(json_decode($parameter))
			&& !self::isEmpty($parameter);
	}

	/**
	 * Checks whether a parameter is an int with a range.
	 *
	 * @author David Pauli <contact@david-pauli.de>
	 * @since 0.0.0
	 * @api
	 * @param int $parameter Int to check.
	 * @param int|null $minimum The minimum allowed number, null if there is no minimum.
	 * @param int|null $maximum The maximum allowed number, null if there is no maximum.
	 * @return boolean True if the parameter is an int, false if not.
	 */
	public static function isRangedInt($parameter, $minimum = null, $maximum = null) {

		return self::isInt($parameter)
			&& (self::isInt($minimum) ? $parameter >= $minimum : true)
			&& (self::isInt($maximum) ? $parameter <= $maximum : true);
	}

	/**
	 * Checks whether a parameter is a float with a range.
	 *
	 * @author David Pauli <contact@david-pauli.de>
	 * @since 0.1.0
	 * @api
	 * @param float $parameter Float to check.
	 * @param float|null $minimum The minimum allowed number, null if there is no minimum.
	 * @param float|null $maximum The maximum allowed number, null if there is no maximum.
	 * @return boolean True if the parameter is an int, false if not.
	 */
	public static function isRangedFloat($parameter, $minimum = null, $maximum = null) {

		return self::isFloat($parameter)
			&& (self::isFloat($minimum) ? $parameter >= $minimum : true)
			&& (self::isFloat($maximum) ? $parameter <= $maximum : true);
	}

	/**
	 * Checks whether a parameter is a product sort direction.
	 *
	 * @author David Pauli <contact@david-pauli.de>
	 * @since 0.0.0
	 * @api
	 * @param String $parameter String to check.
	 * @return boolean True if the parameter is a product sort direction, false if not.
	 */
	public static function isProductDirection($parameter) {

		return self::isMatchRegex($parameter, "/^(asc|desc)$/", "products sort direction")
			&& !self::isEmpty($parameter);
	}

	/**
	 * Checks whether a parameter is a product sort parameter.
	 *
	 * @author David Pauli <contact@david-pauli.de>
	 * @since 0.0.0
	 * @api
	 * @param String $parameter String to check.
	 * @return boolean True if the parameter is a product sort parameter, false if not.
	 */
	public static function isProductSort($parameter) {

		return self::isMatchRegex($parameter, "/^(name|price)$/", "products sort parameter")
			&& !self::isEmpty($parameter);
	}

	/**
	 * Checks whether a parameter is a valid product id.
	 *
	 * @author David Pauli <contact@david-pauli.de>
	 * @since 0.0.0
	 * @api
	 * @param String $parameter String to check.
	 * @return boolean True if the parameter is a valid product id, false if not.
	 */
	public static function isProductId($parameter) {

		return !self::isEmpty($parameter);
	}

	/**
	 * Checks whether a parameter is a float.
	 *
	 * @author David Pauli <contact@david-pauli.de>
	 * @since 0.1.0
	 * @api
	 * @param float $parameter Float to check.
	 * @return boolean True if the parameter is a float, false if not.
	 */
	public static function isFloat($parameter) {

		return is_float($parameter) && !self::isEmpty($parameter);
	}

	/**
	 * Checks whether a parameter is an int.
	 *
	 * @author David Pauli <contact@david-pauli.de>
	 * @since 0.0.0
	 * @api
	 * @param int $parameter Int to check.
	 * @return boolean True if the parameter is an int, false if not.
	 */
	public static function isInt($parameter) {

		return is_int($parameter) && !self::isEmpty($parameter);
	}

	/**
	 * Checks whether a parameter is an array.
	 *
	 * @author David Pauli <contact@david-pauli.de>
	 * @since 0.0.0
	 * @api
	 * @param array $parameter Array to check.
	 * @return boolean True if the parameter is an array, false if not.
	 */
	public static function isArray($parameter) {

		return is_array($parameter) && !self::isEmpty($parameter);
	}

	/**
	 * Checks whether a paramter is empty or null.
	 *
	 * @author David Pauli <contact@david-pauli.de>
	 * @since 0.0.0
	 * @since 0.1.0 Test if the parameter is also the correct type.
	 * @api
	 * @param String $parameter String to check.
	 * @return boolean True if the parameter is empty or null, false if not.
	 */
	public static function isEmpty($parameter) {

		return (is_null($parameter) || ($parameter === ""));
	}

	/**
	 * Checks whether an array is empty or null.
	 *
	 * @author David Pauli <contact@david-pauli.de>
	 * @since 0.1.0
	 * @api
	 * @param mixed[] $parameter Array to check.
	 * @return boolean True if the array is empty or null, false if not.
	 */
	public static function isEmptyArray($parameter) {

		return (is_null($parameter) || empty($parameter));
	}

	/**
	 * Checks whether an array key is unset.
	 *
	 * @author David Pauli <contact@david-pauli.de>
	 * @since 0.1.0
	 * @api
	 * @param mixed[] $array Array to check.
	 * @param String $key Key to exists.
	 * @return boolean True if the array key is unset, false if not.
	 */
	public static function isEmptyArrayKey($array, $key) {

		return self::isEmptyArray($array) || !array_key_exists($key, $array);
	}

	/**
	 * Checks whether a parameter match a regex.
	 *
	 * @param String $parameter String to check.
	 * @param String $regex	 The regex to check.
	 * @param String $type The type which is validated.
	 * @return boolean True if the string validates, false if not.
	 */
	private static function isMatchRegex($parameter, $regex, $type) {

		if(!preg_match($regex, $parameter) &&
			!self::isEmpty($parameter)) {
			Logger::warning("<strong>InputValidator</strong> - This is not a <u>" . $type . "</u>: <i>" . $parameter . "</i>");
		}
		return preg_match($regex, $parameter);
	}

}
?>