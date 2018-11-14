<?php declare(strict_types=1);

namespace Tests\Eciovni;

use Money\Money;
use OndrejBrejla\Eciovni\ItemImpl;
use OndrejBrejla\Eciovni\TaxImpl;
use Tester\Assert;

require __DIR__ . '/../bootstrap.php';

$item = new ItemImpl('with tax', 3, Money::CZK(9750), TaxImpl::fromPercent(21));

Assert::same('9750', $item->getUnitValue()->getAmount());
Assert::same('5079', $item->countTaxValue()->getAmount());
Assert::same('8057', $item->countUntaxedUnitValue()->getAmount());
Assert::same('29250', $item->countFinalValue()->getAmount());

$item = new ItemImpl('without tax', 2, Money::CZK(6900), TaxImpl::fromPercent(15), false);

Assert::same('6900', $item->getUnitValue()->getAmount());
Assert::same('2070', $item->countTaxValue()->getAmount());
Assert::same('6900', $item->countUntaxedUnitValue()->getAmount());
Assert::same('15870', $item->countFinalValue()->getAmount());
