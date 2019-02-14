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

	/** @var int */
	private $units;

	/** @var boolean */
	private $unitValueIsTaxed;


	public function __construct(string $description, string $unitType, int $units,
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


	public function getUnits(): int
	{
		return $this->units;
	}


	/**
	 * Returns the discount value for all units.
	 */
	public function countDiscountValue(): Money
	{
		return $this->countUntaxedUnitValue()->multiply($this->getUnits())->multiply($this->discountPercent / 100);
	}


	/**
	 * Returns the value of taxes for all units.
	 */
	public function countTaxValue(): Money
	{
		return $this->countTaxedUnitValue()->subtract($this->countUntaxedUnitValue(true))->multiply($this->getUnits());
	}


	/**
	 * Returns the taxed (& possibly discounted) value of one unit.
	 */
	private function countTaxedUnitValue(): Money
	{
		// need to use untaxedUnitValue even if isUnitValueTaxed=true as we need to apply discount first
		return $this->countUntaxedUnitValue(true)->multiply($this->getTax()->inUpperDecimal());
	}


	/**
	 * Returns the value of unit without tax, optionally with discount applied.
	 * @param bool $applyDiscount
	 */
	public function countUntaxedUnitValue(bool $applyDiscount = false): Money
	{
		$ret = $unitValue = $this->getUnitValue();
		if ($this->isUnitValueTaxed()) {
			$ret = $unitValue->subtract($unitValue->multiply($this->getTax()->asCoefficient()));
		}
		if ($applyDiscount) {
			$ret = $ret->multiply((100 - $this->discountPercent) / 100);
		}

		return $ret;
	}


	/**
	 * Returns the final value of all taxed units.
	 */
	public function countFinalValue(): Money
	{
		return $this->countTaxedUnitValue()->multiply($this->getUnits());
	}


}