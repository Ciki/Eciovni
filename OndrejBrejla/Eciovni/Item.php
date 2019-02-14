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

	/**
	 * Returns the value of taxes for all units.
	 */
	public function countTaxValue(): Money;

	/**
	 * Returns the value of unit without tax.
	 */
	public function countUntaxedUnitValue(): Money;

	/**
	 * Returns the final value of all taxed units.
	 */
	public function countFinalValue(): Money;
}