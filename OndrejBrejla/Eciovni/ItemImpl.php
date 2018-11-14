<?php declare(strict_types=1);

namespace OndrejBrejla\Eciovni;

use Money\Money;

/**
 * ItemImpl - part of Eciovni plugin for Nette Framework.
 * @copyright  Copyright (c) 2009 Ondřej Brejla
 * @license    New BSD License
 * @link       http://github.com/OndrejBrejla/Eciovni
 */
class ItemImpl implements Item
{

    /** @var string */
    private $description;

    /** @var Tax */
    private $tax;

    /** @var Money */
    private $unitValue;

    /** @var int */
    private $units;

    /** @var boolean */
    private $unitValueIsTaxed;

    public function __construct(string $description, int $units, Money $unitValue, Tax $tax, bool $unitValueIsTaxed = true)
    {
        $this->description = $description;
        $this->units = $units;
        $this->unitValue = $unitValue;
        $this->tax = $tax;
        $this->unitValueIsTaxed = $unitValueIsTaxed;
    }

    public function getDescription(): string
    {
        return $this->description;
    }

    public function getTax(): Tax
    {
        return $this->tax;
    }

    /**
     * Returns the value of one unit of the item.
     */
    public function getUnitValue(): Money
    {
        return $this->unitValue;
    }

    public function isUnitValueTaxed(): bool
    {
        return $this->unitValueIsTaxed;
    }

    public function getUnits(): int
    {
        return $this->units;
    }

    /**
     * Returns the value of taxes for all units.
     */
    public function countTaxValue(): Money
    {
        return $this->countTaxedUnitValue()->subtract($this->countUntaxedUnitValue())->multiply($this->getUnits());
    }

    /**
     * Returns the taxed value of one unit.
     */
    private function countTaxedUnitValue(): Money
    {
        if ($this->isUnitValueTaxed()) {
            return $this->getUnitValue();
        }

	    return $this->getUnitValue()->multiply($this->getTax()->inUpperDecimal());
    }

    /**
     * Returns the value of unit without tax.
     */
    public function countUntaxedUnitValue(): Money
    {
        if ($this->isUnitValueTaxed()) {
            return $this->getUnitValue()->subtract($this->getUnitValue()->multiply($this->getTax()->asCoefficient()));
        }

	    return $this->getUnitValue();
    }

    /**
     * Returns the final value of all taxed units.
     */
    public function countFinalValue(): Money
    {
        return $this->countTaxedUnitValue()->multiply($this->getUnits());
    }

}
