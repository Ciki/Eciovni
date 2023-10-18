<?php

declare(strict_types=1);

namespace Tests\Eciovni;

use Money\Money;
use OndrejBrejla\Eciovni\ItemImpl;
use OndrejBrejla\Eciovni\TaxImpl;
use Tester\Assert;

require __DIR__ . '/../bootstrap.php';

$item = new ItemImpl('with tax', 'ks', 3, Money::CZK(9750), TaxImpl::fromPercent(21));

Assert::same('9750', $item->getUnitValue()->getAmount());
Assert::same('8058', $item->countUntaxedUnitValue()->getAmount());
Assert::same('24174', $item->countUntaxedFinalValue()->getAmount());
Assert::same('5077', $item->countTaxValue()->getAmount());
Assert::same('29251', $item->countFinalValue()->getAmount());
Assert::same('-1', $item->countFinalAdjustmentValue()->getAmount());


$item = new ItemImpl('with tax and discount', 'ks', 3, Money::CZK(9750), TaxImpl::fromPercent(21), 10);

Assert::same('9750', $item->getUnitValue()->getAmount());
Assert::same('8058', $item->countUntaxedUnitValue()->getAmount());
Assert::same('21757', $item->countUntaxedFinalValue()->getAmount());
Assert::same('4569', $item->countTaxValue()->getAmount());
Assert::same('26326', $item->countFinalValue()->getAmount());
Assert::same('-1', $item->countFinalAdjustmentValue()->getAmount());


$item = new ItemImpl('without tax', 'ks', 2, Money::CZK(6900), TaxImpl::fromPercent(15), 0, false);

Assert::same('6900', $item->getUnitValue()->getAmount());
Assert::same('6900', $item->countUntaxedUnitValue()->getAmount());
Assert::same('13800', $item->countUntaxedFinalValue()->getAmount());
Assert::same('2070', $item->countTaxValue()->getAmount());
Assert::same('15870', $item->countFinalValue()->getAmount());
Assert::same('0', $item->countFinalAdjustmentValue()->getAmount());
