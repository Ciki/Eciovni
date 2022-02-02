<?php
declare(strict_types=1);

namespace OndrejBrejla\Eciovni;

use Money\Money;

/**
 * ItemImpl - part of Eciovni plugin for Nette Framework.
 * @copyright  Copyright (c) 2009 Ondřej Brejla
 * @license    New BSD License
 * @link       http://github.com/OndrejBrejla/Eciovni
 */
class ItemImpl implements Item
{
	/** @var string */
	private $description;

	/** @var Tax */
	private $tax;

	/** @var float */
	private $discountPercent;

	/** @var Money */
	private $unitValue;

	/** @var string */
	private $unitType;

	/** @var float */
	private $units;

	/** @var boolean */
	private $unitValueIsTaxed;


	public function __construct(string $description, string $unitType, float $units,
		Money $unitValue, Tax $tax, float $discountPercent = 0.0,
		bool $unitValueIsTaxed = true)
	{
		$this->description = $description;
		$this->unitType = $unitType;
		$this->units = $units;
		$this->unitValue = $unitValue;
		$this->tax = $tax;
		$this->discountPercent = $discountPercent;
		$this->unitValueIsTaxed = $unitValueIsTaxed;
	}


	public function getDescription(): string
	{
		return $this->description;
	}


	public function getTax(): Tax
	{
		return $this->tax;
	}


	public function getDiscountPercent(): float
	{
		return $this->discountPercent;
	}


	/**
	 * Returns the value of one unit of the item.
	 */
	public function getUnitValue(): Money
	{
		return $this->unitValue;
	}


	public function getUnitType(): string
	{
		return $this->unitType;
	}


	public function isUnitValueTaxed(): bool
	{
		return $this->unitValueIsTaxed;
	}


	public function getUnits(): float
	{
		return $this->units;
	}


	/**
	 * Returns the value of unit without tax, optionally with discount applied.
	 * @param bool $applyDiscount true for information purposes only, it should NOT be used in calculations for total values
	 */
	public function countUntaxedUnitValue(bool $applyDiscount = false): Money
	{
		$ret = $unitValue = $this->getUnitValue();
		if ($this->isUnitValueTaxed()) {
			$tax = $unitValue->multiply($this->getTax()->asCoefficient());
			$ret = $unitValue->subtract($tax);
		}
		if ($applyDiscount) {
//			$discount = $ret->multiply($this->discountPercent / 100);
//			$ret = $ret->subtract($discount);
			$ret = $ret->multiply((100 - $this->discountPercent) / 100);
		}

		return $ret;
	}


	/**
	 * Returns the final value of all untaxed units.
	 */
	public function countUntaxedFinalValue(): Money
	{
		// we need to provide multiplier in one multiply() call as it rounds the output every time, we could lose some cents because of this
		$discountCoef = (100 - $this->discountPercent) / 100;
		return $this->countUntaxedUnitValue(false)->multiply($this->getUnits() * $discountCoef);
	}


	/**
	 * Returns the discount value for all units.
	 */
	public function countDiscountValue(): Money
	{
		return $this->countUntaxedUnitValue(false)->multiply($this->getUnits())
				->subtract($this->countUntaxedFinalValue());
	}


	/**
	 * Returns the value of taxes for all units.
	 */
	public function countTaxValue(): Money
	{
		return $this->countUntaxedFinalValue()->multiply($this->getTax()->inLowerDecimal());
	}


	/**
	 * Returns the final value of all taxed units.
	 */
	public function countFinalValue(): Money
	{
		return $this->countUntaxedFinalValue()->add($this->countTaxValue());
	}


}