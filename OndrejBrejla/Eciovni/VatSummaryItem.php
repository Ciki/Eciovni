<?php
declare(strict_types=1);

namespace OndrejBrejla\Eciovni;

use Money\Money;

/**
 * VatSummaryItem - part of Eciovni plugin for Nette Framework.
 * @copyright  Copyright (c) 2009 Ondřej Brejla
 * @license    New BSD License
 * @link       http://github.com/OndrejBrejla/Eciovni
 */
interface VatSummaryItem
{

	public function getDescription(): string;

	public function getAmountWithoutVat(): Money;

	public function getAmountWithVat(): Money;

	public function getAmountVat(): Money;

	public function addAmounts(Money $amountWithoutVat, Money $amountVat, Money $amountWithVat): void;
}