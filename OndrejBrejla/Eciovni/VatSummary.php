<?php

declare(strict_types=1);

namespace OndrejBrejla\Eciovni;

/**
 * VatSummaryItem - part of Eciovni plugin for Nette Framework.
 * @copyright  Copyright (c) 2009 Ondřej Brejla
 * @license    New BSD License
 * @link       http://github.com/OndrejBrejla/Eciovni
 */
interface VatSummary
{
	/**
	 * @return array<int|float|string, VatSummaryItem>
	 */
	public function getVatSummaryItems(): array;
}
