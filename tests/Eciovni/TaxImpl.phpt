<?php declare(strict_types=1);

namespace Tests\Eciovni;

use OndrejBrejla\Eciovni\TaxImpl;
use Tester\Assert;

require __DIR__ . '/../bootstrap.php';

$tax1 = TaxImpl::fromUpperDecimal(1.21);

$tax2 = TaxImpl::fromLowerDecimal(0.21);

$tax3 = TaxImpl::fromPercent(21);

Assert::same($tax1->inUpperDecimal(), $tax2->inUpperDecimal());
Assert::same($tax1->inUpperDecimal(), $tax3->inUpperDecimal());
Assert::same($tax2->inUpperDecimal(), $tax3->inUpperDecimal());

Assert::same(21., $tax1->inPercentage());
Assert::same(0.1736 , $tax1->asCoefficient());
