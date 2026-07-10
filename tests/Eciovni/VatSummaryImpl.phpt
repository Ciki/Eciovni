<?php

declare(strict_types=1);

/**
 * Distinct rates sharing an integer part (12.0 vs 12.5) must land in SEPARATE buckets.
 * A raw float array key is truncated to int by PHP (deprecation-warning since 8.1, silently
 * merging the buckets), so getVatSummaryItems() keys them by the rate cast to string.
 */

namespace Tests\Eciovni;

use Money\Money;
use OndrejBrejla\Eciovni\ItemImpl;
use OndrejBrejla\Eciovni\TaxImpl;
use OndrejBrejla\Eciovni\VatSummaryImpl;
use Tester\Assert;

require __DIR__ . '/../bootstrap.php';

// Escalate deprecations so a float->int key truncation fails the test outright
set_error_handler(static function (int $severity, string $message): never {
	throw new \ErrorException($message, 0, $severity);
}, E_DEPRECATED | E_USER_DEPRECATED);

$item = static fn(float $rate): ItemImpl => new ItemImpl('item', 'ks', 1, Money::EUR(10000), TaxImpl::fromPercent($rate), 0, false);

$summaryItems = (new VatSummaryImpl([12.0, 12.5, 21.0], [$item(12.0), $item(12.5)]))->getVatSummaryItems();

// whole-number rates coerce to int keys, fractional ones stay numeric strings
Assert::same([12, '12.5', 21, 'totals'], array_keys($summaryItems));

// each rate accumulates in its OWN bucket - no merge, no double representation
Assert::same('10000', $summaryItems[12]->getAmountWithoutVat()->getAmount());
Assert::same('1200', $summaryItems[12]->getAmountVat()->getAmount());
Assert::same('10000', $summaryItems['12.5']->getAmountWithoutVat()->getAmount());
Assert::same('1250', $summaryItems['12.5']->getAmountVat()->getAmount());
Assert::same('0', $summaryItems[21]->getAmountWithoutVat()->getAmount());
Assert::same('20000', $summaryItems['totals']->getAmountWithoutVat()->getAmount());
Assert::same('2450', $summaryItems['totals']->getAmountVat()->getAmount());

restore_error_handler();
