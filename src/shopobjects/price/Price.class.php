<?php
/**
 * This file represents the price class.
 *
 * @author David Pauli <contact@david-pauli.de>
 * @since 0.0.0
 */
namespace ep6;
/**
 * This is the class for price objects.
 *
 * @author David Pauli <contact@david-pauli.de>
 * @since 0.0.0
 * @package ep6
 * @subpackage Shopobjects\Price
 */
class Price {
	
	/** @var float The amount of the price. */
	private $amount = 0.0;
	
	/** @var String The tax type of the price. */
	private $taxType = "";
	
	/** @var String The curreny of the price. */
	private $currency = "";
	
	/**
	 * This is the constructor of the price object.
	 *
	 * @api
	 * @author David Pauli <contact@david-pauli.de>
	 * @since 0.0.0
	 * @param float $amount The price value.
	 * @param String $currency The currency of the price.
	 * @param String $taxType The tax type, can be "GROSS" or "NET".
	 */
	public function __construct($amount, $currency, $taxType) {
		
		if (!InputValidator::isFloat($amount) && !InputValidator::isCurrency($currency) && !InputValidator::isTaxType($taxType)) {
			return;
		}
	}
}
?>