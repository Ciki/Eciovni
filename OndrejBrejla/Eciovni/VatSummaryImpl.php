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
class VatSummaryImpl implements VatSummary
{
	/** @var float[] */
	private $vatRates = [];

	/** @var Item[] */
	private $items = [];


	public function __construct(/* float[] */ array $vatRates, /* Item[] */ array $items)
	{
		$this->vatRates = $vatRates;
		$this->items = $items;
	}


	public function getVatSummaryItems(): /* VatSummaryItem[] */ array
	{
		if (empty($this->items)) {
			return [];
		}

		$currency = reset($this->items)->getUnitValue()->getCurrency();
		$zeroMoney = new Money(0, $currency);
		$vatSummaryItems = [];
		foreach ($this->vatRates as $rate) {
			$vatSummaryItems[$rate] = new VatSummaryItemImpl($rate . '%', $zeroMoney, $zeroMoney, $zeroMoney);
		}
		$vatSummaryItems['totals'] = new VatSummaryItemImpl('Total', $zeroMoney, $zeroMoney, $zeroMoney);

		foreach ($this->items as $item) {
			$itemVatRate = $item->getTax()->inPercentage();
			if (!in_array($itemVatRate, $this->vatRates, true)) {
				throw new InvalidArgumentException("Item vat rate $itemVatRate is not defined within given '\$this->vatRates' parameters, given only: " . join(',', $this->vatRates));
			}
			$vatSummaryItems[$itemVatRate]->addAmounts($item->countUntaxedFinalValue(), $item->countTaxValue(), $item->countFinalValue());
			$vatSummaryItems['totals']->addAmounts($item->countUntaxedFinalValue(), $item->countTaxValue(), $item->countFinalValue());
		}

		return $vatSummaryItems;
	}


}