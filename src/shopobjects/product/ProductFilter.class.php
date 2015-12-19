<?php
/**
 * This file represents the product filter class.
 *
 * @author David Pauli <contact@david-pauli.de>
 * @since 0.0.0
 */
namespace ep6;
/**
 * This is a product filter class to search products via the REST call "product".
 *
 * @author David Pauli <contact@david-pauli.de>
 * @since 0.0.0
 * @package ep6
 * @subpackage Shopobjects\Product
 * @example examples\createProductFilter.php Create and use the product filter.
 */
class ProductFilter {

	/** @var String The REST path to the filter ressource. */
	const RESTPATH = "products";

	/** @var String|null The localization of the product search result. */
	private static $LOCALE;

	/** @var String|null The currency of the product search result. */
	private static $CURRENCY;

	/** @var int The page of the product search result. */
	private static $PAGE = 1;

	/** @var int The number of results per page of the product search result. */
	private static $RESULTSPERPAGE = 10;

	/** @var String|null The sort direction of the product search result. */
	private static $DIRECTION;

	/** @var String The variable to sort the results of the product search result. */
	private static $SORT = "name";

	/** @var String|null The search string of the product search result. */
	private static $Q;

	/** @var String|null The category id of the product search result. */
	private static $CATEGORYID;

	/** @var String[] The product ids of the product search result. */
	private static $IDS = array();

	/**
	 * This is the constructor to prefill the product filter.
	 *
	 * @author David Pauli <contact@david-pauli.de>
	 * @since 0.0.1
	 * @api
	 * @param String[] $productFilterParameter The values of a product filter.
	 */
	public function __construct($productFilterParameter = array()) {

		if (InputValidator::isArray($productFilterParameter) &&
			!InputValidator::isEmptyArray($productFilterParameter)) {
			$this->setProductFilter($productFilterParameter);
		}
	}

	/**
	 * Fill the product filter with a array.
	 *
	 * @author David Pauli <contact@david-pauli.de>
	 * @since 0.0.1
	 * @api
	 * @param String[] $productFilterParameter The values of a product filter.
	 */
	public function setProductFilter($productFilterParameter) {

		if (!InputValidator::isArray($productFilterParameter) ||
			InputValidator::isEmptyArray($productFilterParameter)) {
			return;
		}

		foreach ($productFilterParameter as $key => $parameter) {
			if ($key == "locale") {
				$this->setLocale($parameter);
			}
			else if($key == "currency") {
				$this->setCurrency($parameter);
			}
			else if($key == "page") {
				$this->setPage($parameter);
			}
			else if($key == "resultsPerPage") {
				$this->setResultsPerPage($parameter);
			}
			else if($key == "direction") {
				$this->setDirection($parameter);
			}
			else if($key == "sort") {
				$this->setSort($parameter);
			}
			else if($key == "q") {
				$this->setQ($parameter);
			}
			else if($key == "categoryID") {
				$this->setCategoryID($parameter);
			}
			else {
				Logger::warning("Unknown attribute <i>" . $key . "</i> in product filter attribute.");
			}
		}
	}

	/**
	 * This function prints the filter in a NOTIFICATION message.
	 *
	 * @author David Pauli <contact@david-pauli.de>
	 * @since 0.0.0
	 * @api
	 */
	public function printFilter() {

		$message = array();
		if (!InputValidator::isEmpty(self::$LOCALE)) array_push($message, "Locale: " . self::$LOCALE);
		if (!InputValidator::isEmpty(self::$CURRENCY)) array_push($message, "Currency: " . self::$CURRENCY);
		if (!InputValidator::isEmpty(self::$PAGE)) array_push($message, "Page: " . self::$PAGE);
		if (!InputValidator::isEmpty(self::$RESULTSPERPAGE)) array_push($message, "Results per page: " . self::$RESULTSPERPAGE);
		if (!InputValidator::isEmpty(self::$DIRECTION)) array_push($message, "Direction: " . self::$DIRECTION);
		if (!InputValidator::isEmpty(self::$SORT)) array_push($message, "Sort: " . self::$SORT);
		if (!InputValidator::isEmpty(self::$Q)) array_push($message, "Search string: " . self::$Q);
		if (!InputValidator::isEmpty(self::$CATEGORYID)) array_push($message, "Category ID: " . self::$CATEGORYID);
		foreach (self::$IDS as $number => $id) {
			array_push($message, "Product id" . $number . ": " . $id);
		}
		Logger::force($message);
	}

	/**
	 * This function returns the hash code of the object to equals the object.
	 *
	 * @author David Pauli <contact@david-pauli.de>
	 * @since 0.0.0
	 * @api
	 * @return String Returns the hash code of the object.
	 */
	public function hashCode() {

		$message = self::$LOCALE
			. self::$CURRENCY
			. self::$PAGE
			. self::$RESULTSPERPAGE
			. self::$DIRECTION
			. self::$SORT
			. self::$Q
			. self::$CATEGORYID;
		foreach (self::$IDS as $id) {
			$message .= $id;
		}
		return hash("sha512", $message);
	}

	/**
	 * This function sets the localization.
	 *
	 * @author David Pauli <contact@david-pauli.de>
	 * @since 0.0.0
	 * @api
	 * @param String $locale The localiazion to filter.
	 * @return boolean True if setting the locale works, false if not.
	 */
	public function setLocale($locale) {
		if (!InputValidator::isLocale($locale)) {
			return false;
		}
		self::$LOCALE = $locale;
		return true;
	}

	/**
	 * This function gets the localization.
	 *
	 * @author David Pauli <contact@david-pauli.de>
	 * @since 0.0.0
	 * @api
	 * @return String The localization of this product filter.
	 */
	public function getLocale() {
		return self::$LOCALE;
	}

	/**
	 * This function sets the currency.
	 *
	 * @author David Pauli <contact@david-pauli.de>
	 * @since 0.0.0
	 * @api
	 * @param String $currency The currency to filter.
	 * @return boolean True if setting the currency works, false if not.
	 */
	public function setCurrency($currency) {
		if (!InputValidator::isCurrency($currency)) {
			return false;
		}
		self::$CURRENCY = $currency;
		return true;
	}

	/**
	 * This function gets the currency.
	 *
	 * @author David Pauli <contact@david-pauli.de>
	 * @since 0.0.0
	 * @api
	 * @return String The currency of this product filter.
	 */
	public function getCurrency() {
		return self::$CURRENCY;
	}

	/**
	 * This function sets the page to show.
	 *
	 * @author David Pauli <contact@david-pauli.de>
	 * @since 0.0.0
	 * @api
	 * @param int $page The page number to filter.
	 * @return boolean True if setting the page works, false if not.
	 */
	public function setPage($page) {
		if (!InputValidator::isRangedInt($page, 1)) {
			return false;
		}
		self::$PAGE = $page;
		return true;
	}

	/**
	 * This function gets the page.
	 *
	 * @author David Pauli <contact@david-pauli.de>
	 * @since 0.0.0
	 * @api
	 * @return int The page number of this product filter.
	 */
	public function getPage() {
		return self::$PAGE;
	}

	/**
	 * This function sets the results per page to show.
	 *
	 * @author David Pauli <contact@david-pauli.de>
	 * @since 0.0.0
	 * @api
	 * @param int $resultsPerPage The results per page to filter.
	 * @return boolean True if setting the results per page works, false if not.
	 */
	public function setResultsPerPage($resultsPerPage) {
		if (!InputValidator::isRangedInt($resultsPerPage, null, 100)) {
			return false;
		}
		self::$RESULTSPERPAGE = $resultsPerPage;
		return true;
	}

	/**
	 * This function gets the results per page.
	 *
	 * @author David Pauli <contact@david-pauli.de>
	 * @since 0.0.0
	 * @api
	 * @return int The results per page number of this product filter.
	 */
	public function getResultsPerPage() {
		return self::$RESULTSPERPAGE;
	}

	/**
	 * This function sets the direction to show.
	 *
	 * @author David Pauli <contact@david-pauli.de>
	 * @since 0.0.0
	 * @api
	 * @param String $direction The direction to filter.
	 * @return boolean True if setting the direction works, false if not.
	 */
	public function setDirection($direction) {
		if (!InputValidator::isProductDirection($direction)) {
			return false;
		}
		self::$DIRECTION = $direction;
		return true;
	}

	/**
	 * This function gets the direction.
	 *
	 * @author David Pauli <contact@david-pauli.de>
	 * @since 0.0.0
	 * @api
	 * @return String The direction of this product filter.
	 */
	public function getDirection() {
		return self::$DIRECTION;
	}

	/**
	 * This function sets the order parameter to show.
	 *
	 * @author David Pauli <contact@david-pauli.de>
	 * @since 0.0.0
	 * @api
	 * @param String $sort The sort parameter to filter.
	 * @return boolean True if setting the sort parameter works, false if not.
	 */
	public function setSort($sort) {
		if (!InputValidator::isProductSort($sort)) {
			return false;
		}
		self::$SORT = $sort;
		return true;
	}

	/**
	 * This function gets the sort.
	 *
	 * @author David Pauli <contact@david-pauli.de>
	 * @since 0.0.0
	 * @api
	 * @return String The sort of this product filter.
	 */
	public function getSort() {
		return self::$SORT;
	}

	/**
	 * This function sets the query search string to show.
	 *
	 * @author David Pauli <contact@david-pauli.de>
	 * @since 0.0.0
	 * @api
	 * @param String $q The query search string to filter.
	 * @return boolean True if setting the query search string works, false if not.
	 */
	public function setQ($q) {
		if (InputValidator::isEmpty($q)) {
			return false;
		}
		self::$Q = $q;
		return true;
	}

	/**
	 * This function gets the query search string.
	 *
	 * @author David Pauli <contact@david-pauli.de>
	 * @since 0.0.0
	 * @api
	 * @return String The query search string of this product filter.
	 */
	public function getQ() {
		return self::$Q;
	}

	/**
	 * This function sets the category ID to show.
	 *
	 * @author David Pauli <contact@david-pauli.de>
	 * @since 0.0.0
	 * @api
	 * @param String $categoryID	The category ID to filter.
	 * @return boolean True if setting the category ID string works, false if not.
	 */
	public function setCategoryID($categoryID) {
		if (InputValidator::isEmpty($categoryID)) {
			return false;
		}
		self::$CATEGORYID = $categoryID;
		return true;
	}

	/**
	 * This function gets the category ID string.
	 *
	 * @author David Pauli <contact@david-pauli.de>
	 * @since 0.0.0
	 * @api
	 * @return String The category ID string of this product filter.
	 */
	public function getCategoryID() {
		return self::$CATEGORYID;
	}

	/**
	 * This function add a product ID from filter.
	 *
	 * @author David Pauli <contact@david-pauli.de>
	 * @since 0.0.0
	 * @api
	 * @param String $productID The product ID to filter.
	 * @return boolean True if setting the product ID string works, false if not.
	 */
	public function setID($productID) {
		if (InputValidator::isEmpty($productID)
			|| count(self::$IDS) > 12
			|| in_array($productID, self::$IDS)) {
			return false;
		}
		array_push(self::$IDS, $productID);
		return true;
	}

	/**
	 * This function delete a product ID from filter.
	 *
	 * @author David Pauli <contact@david-pauli.de>
	 * @since 0.0.0
	 * @api
	 * @param String $productID	The product ID to unset from filter.
	 * @return boolean True if unsetting the product ID string works, false if not.
	 */
	public function unsetID($productID) {
		if (InputValidator::isEmpty($productID)
			|| !in_array($productID, self::$IDS)) {
			return false;
		}
		unset(self::$IDS[array_search($productID, self::$IDS)]);
		return true;
	}

	/**
	 * This function reset all product IDs from filter.
	 * @author David Pauli <contact@david-pauli.de>
	 * @since 0.0.0
	 * @api
	 */
	public function resetIDs() {
		self::$IDS = array();
	}

	/**
	 * This function reset all product IDs from filter.
	 * @author David Pauli <contact@david-pauli.de>
	 * @since 0.0.0
	 * @api
	 */
	public function resetFilter() {

		self::$LOCALE = null;
		self::$CURRENCY = null;
		self::$PAGE = 1;
		self::$RESULTSPERPAGE = 10;
		self::$DIRECTION = null;
		self::$SORT = "name";
		self::$Q = null;
		self::$CATEGORYID = null;
		self::$IDS = array();
	}

	/**
	 * This function returns the products by using the product filter.
	 *
	 * @author David Pauli <contact@david-pauli.de>
	 * @since 0.0.0
	 * @api
	 * @return Products[] Returns an array of products.
	 */
	public function getProducts() {

		$parameter = self::getParameter();

		// if request method is blocked
		if (!RESTClient::setRequestMethod(HTTPRequestMethod::GET)) {
			return;
		}

		$content = RESTClient::send(self::RESTPATH . "?" . $parameter);

		// if respond is empty
		if (InputValidator::isEmpty($content)) {
			return;
		}

		// if there is no results, page AND resultsPerPage element
		if (InputValidator::isEmptyArrayKey($content, "results") ||
			InputValidator::isEmptyArrayKey($content, "page") ||
			InputValidator::isEmptyArrayKey($content, "resultsPerPage")) {
		    Logger::error("Respond for " . self::RESTPATH . " can not be interpreted.");
			return;
		}

		$products = array();
		// is there any product found: load the products.
	 	if (!InputValidator::isEmptyArrayKey($content, "items") && (sizeof($content['items']) != 0)) {

			foreach ($content['items'] as $item) {

				// add the localization in the product array
				$item['locale'] = InputValidator::isLocale(self::$LOCALE) ? self::$LOCALE : Locales::getDefault();
				$product = new Product($item);
				array_push($products, $product);
			}
	 	}

		return $products;
	}

	/**
	 * This function returns the parameter as string.
	 *
	 * @author David Pauli <contact@david-pauli.de>
	 * @since 0.0.0
	 * @api
	 * @return String The parameter build with this product filter.
	 */
	private function getParameter() {

		$parameter = array();
		if (!InputValidator::isEmpty(self::$LOCALE)) array_push($parameter, "locale=" . self::$LOCALE);
		if (!InputValidator::isEmpty(self::$CURRENCY)) array_push($parameter, "currency=" . self::$CURRENCY);
		if (!InputValidator::isEmpty(self::$PAGE)) array_push($parameter, "page=" . self::$PAGE);
		if (!InputValidator::isEmpty(self::$RESULTSPERPAGE)) array_push($parameter, "resultsPerPage=" . self::$RESULTSPERPAGE);
		if (!InputValidator::isEmpty(self::$DIRECTION)) array_push($parameter, "direction=" . self::$DIRECTION);
		if (!InputValidator::isEmpty(self::$SORT)) array_push($parameter, "sort=" . self::$SORT);
		if (!InputValidator::isEmpty(self::$Q)) array_push($parameter, "q=" . self::$Q);
		if (!InputValidator::isEmpty(self::$CATEGORYID)) array_push($parameter, "categoryId=" . self::$CATEGORYID);
		foreach (self::$IDS as $number => $id) {
			array_push($parameter, "id=" . $id);
		}

		return implode("&", $parameter);
	}
}
?>