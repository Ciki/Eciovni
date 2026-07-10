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
final class VatSummaryImpl implements VatSummary
{
	/**
	 * @param list<float> $vatRates
	 * @param list<Item> $items
	 */
	public function __construct(
		private readonly array $vatRates,
		private array $items
	) {
	}


	/**
	 * Buckets are keyed by the rate cast to string (whole-number rates coerce to int array keys,
	 * fractional ones stay numeric strings) - a raw float key would be truncated to int by PHP,
	 * silently merging distinct rates like 12.0 and 12.5 into one bucket (and deprecation-warning
	 * since PHP 8.1). The 'totals' key holds the grand total across all rates.
	 *
	 * @return array<int|string, VatSummaryItemImpl>
	 */
	public function getVatSummaryItems(): array
	{
		if ($this->items === []) {
			return [];
		}

		$currency = reset($this->items)->getUnitValue()->getCurrency();
		$zeroMoney = new Money(0, $currency);
		$vatSummaryItems = [];
		foreach ($this->vatRates as $rate) {
			$vatSummaryItems[(string) $rate] = new VatSummaryItemImpl($rate . '%', $zeroMoney, $zeroMoney, $zeroMoney);
		}
		$vatSummaryItems['totals'] = new VatSummaryItemImpl('Total', $zeroMoney, $zeroMoney, $zeroMoney);

		foreach ($this->items as $item) {
			$itemVatRate = $item->getTax()->inPercentage();
			if (!in_array($itemVatRate, $this->vatRates, true)) {
				throw new InvalidArgumentException("Item vat rate {$itemVatRate} is not defined within given '\$this->vatRates' parameters, given only: " . join(',', $this->vatRates));
			}
			$vatSummaryItems[(string) $itemVatRate]->addAmounts($item->countUntaxedFinalValue(), $item->countTaxValue(), $item->countFinalValue());
			$vatSummaryItems['totals']->addAmounts($item->countUntaxedFinalValue(), $item->countTaxValue(), $item->countFinalValue());
		}

		return $vatSummaryItems;
	}
}
