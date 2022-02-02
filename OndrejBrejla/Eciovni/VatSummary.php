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

	public function getVatSummaryItems(): /* VatSummaryItem[] */ array;
}