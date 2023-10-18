<?php

declare(strict_types=1);

namespace OndrejBrejla\Eciovni;

/**
 * TaxImpl - part of Eciovni plugin for Nette Framework.
 *
 * @copyright  Copyright (c) 2009 Ondřej Brejla
 * @license    New BSD License
 * @link       http://github.com/OndrejBrejla/Eciovni
 */
final class TaxImpl implements Tax
{
	private readonly float $coefficient;


	private function __construct(private readonly float $percentage)
	{
		$this->coefficient = round($percentage / (100 + $percentage), 4);
	}


	/**
	 * Creates new Tax from a percent value.
	 */
	public static function fromPercent(float $percent): Tax
	{
		return new TaxImpl($percent);
	}


	/**
	 * Creates new Tax from a lower decimal value.
	 * I.e. value must be '0.22' for a tax of '22%'.
	 */
	public static function fromLowerDecimal(float $lowerDecimal): Tax
	{
		return new TaxImpl($lowerDecimal * 100);
	}


	/**
	 * Creates new Tax from a upper decimal value.
	 * I.e. value must be '1.22' for a tax of '22%'.
	 */
	public static function fromUpperDecimal(float $upperDecimal): Tax
	{
		return new TaxImpl($upperDecimal * 100 - 100);
	}


	public function inPercentage(): float
	{
		return $this->percentage;
	}


	/**
	 * Returns tax in a lower decimal format.
	 * I.e. '0.22' for '22%'.
	 */
	public function inLowerDecimal(): float
	{
		return $this->percentage / 100;
	}


	/**
	 * Returns tax in a upper decimal format.
	 * I.e. '1.22' for '22%'.
	 */
	public function inUpperDecimal(): float
	{
		return 1 + ($this->percentage / 100);
	}


	public function asCoefficient(): float
	{
		return $this->coefficient;
	}
}
