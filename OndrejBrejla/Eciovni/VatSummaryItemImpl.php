<?php
declare(strict_types=1);

namespace OndrejBrejla\Eciovni;

use InvalidArgumentException;
use Money\Money;

/**
 * VatSummaryItemImpl - part of Eciovni plugin for Nette Framework.
 * @copyright  Copyright (c) 2009 Ondřej Brejla
 * @license    New BSD License
 * @link       http://github.com/OndrejBrejla/Eciovni
 */
class VatSummaryItemImpl implements VatSummaryItem
{
	/** @var string */
	private $description;

	/** @var Money */
	private $amountWithoutVat;

	/** @var Money */
	private $amountVat;

	/** @var Money */
	private $amountWithVat;


	public function __construct(string $description, Money $amountWithoutVat, Money $amountVat, Money $amountWithVat)
	{
		$this->checkAmounts($amountWithoutVat, $amountVat, $amountWithVat);
		$this->description = $description;
		$this->amountWithoutVat = $amountWithoutVat;
		$this->amountWithVat = $amountWithVat;
		$this->amountVat = $amountVat;
	}


	public function getDescription(): string
	{
		return $this->description;
	}


	public function getAmountWithoutVat(): Money
	{
		return $this->amountWithoutVat;
	}


	public function getAmountWithVat(): Money
	{
		return $this->amountWithVat;
	}


	public function getAmountVat(): Money
	{
		return $this->amountVat;
	}


	public function addAmounts(Money $amountWithoutVat, Money $amountVat, Money $amountWithVat): void
	{
		$this->checkAmounts($amountWithoutVat, $amountVat, $amountWithVat);
		$this->amountWithoutVat = $this->amountWithoutVat->add($amountWithoutVat);
		$this->amountVat = $this->amountVat->add($amountVat);
		$this->amountWithVat = $this->amountWithVat->add($amountWithVat);
	}


	private function checkAmounts(Money $amountWithoutVat, Money $amountVat, Money $amountWithVat): void
	{
		if (!$amountWithoutVat->add($amountVat)->equals($amountWithVat)) {
			throw new InvalidArgumentException('Amount without VAT + VAT !== Amount with VAT');
		}
	}


}