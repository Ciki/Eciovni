<?php
declare(strict_types=1);

namespace OndrejBrejla\Eciovni;

use Money\Money;

/**
 * Item - part of Eciovni plugin for Nette Framework.
 * @copyright  Copyright (c) 2009 Ondřej Brejla
 * @license    New BSD License
 * @link       http://github.com/OndrejBrejla/Eciovni
 */
interface Item
{

	public function getDescription(): string;

	public function getTax(): Tax;

	public function getUnitValue(): Money;

	public function getUnitType(): string;

	public function getUnits(): int;

	public function getDiscountPercent(): float;

	/**
	 * Returns the discount value for all units.
	 */
	public function countDiscountValue(): Money;

	/**
	 * Returns the value of taxes for all units.
	 */
	public function countTaxValue(): Money;

	/**
	 * Returns the value of unit without tax, optionally with discount applied.
	 */
	public function countUntaxedUnitValue(bool $applyDiscount = false): Money;

	/**
	 * Returns the final value of all taxed units.
	 */
	public function countFinalValue(): Money;
}