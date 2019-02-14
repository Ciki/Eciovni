<?php declare(strict_types=1);

namespace OndrejBrejla\Eciovni;

use DateTime;

/**
 * DataImpl - part of Eciovni plugin for Nette Framework.
 *
 * @copyright  Copyright (c) 2009 Ondřej Brejla
 * @license    New BSD License
 * @link       http://github.com/OndrejBrejla/Eciovni
 */
class DataImpl implements Data
{

    /** @var string */
    private $title;

	/** @var ?string */
    private $caption;

    /** @var string */
    private $id;

    /** @var Participant */
    private $supplier;

    /** @var Participant */
    private $customer;

	/** @var ?string */
    private $variableSymbol;

	/** @var ?string */
    private $constantSymbol;

	/** @var ?string */
    private $specificSymbol;

    /** @var DateTime */
    private $expirationDate;

    /** @var DateTime */
    private $dateOfIssuance;

	/** @var ?DateTime */
    private $dateOfVatRevenueRecognition;

    /** @var Item[] */
    private $items = [];

    public function __construct(DataBuilder $dataBuilder) {
        $this->title = $dataBuilder->getTitle();
        $this->caption = $dataBuilder->getCaption();
        $this->id = $dataBuilder->getId();
        $this->supplier = $dataBuilder->getSupplier();
        $this->customer = $dataBuilder->getCustomer();
        $this->variableSymbol = $dataBuilder->getVariableSymbol();
        $this->constantSymbol = $dataBuilder->getConstantSymbol();
        $this->specificSymbol = $dataBuilder->getSpecificSymbol();
        $this->expirationDate = $dataBuilder->getExpirationDate();
        $this->dateOfIssuance = $dataBuilder->getDateOfIssuance();
        $this->dateOfVatRevenueRecognition = $dataBuilder->getDateOfVatRevenueRecognition();
        $this->items = $dataBuilder->getItems();
    }

    public function getTitle(): string
    {
        return $this->title;
    }

	public function getCaption(): ?string
	{
		return $this->caption;
	}

    public function getId(): string
    {
        return $this->id;
    }

    public function getSupplier(): Participant
    {
        return $this->supplier;
    }

    public function getCustomer(): Participant
    {
        return $this->customer;
    }

    public function getVariableSymbol(): ?string
    {
        return $this->variableSymbol;
    }

    public function getConstantSymbol(): ?string
    {
        return $this->constantSymbol;
    }

    public function getSpecificSymbol(): ?string
    {
        return $this->specificSymbol;
    }

    public function getExpirationDate(string $format = 'd.m.Y'): string
    {
        return $this->expirationDate->format($format);
    }

    public function getDateOfIssuance(string $format = 'd.m.Y'): string
    {
        return $this->dateOfIssuance->format($format);
    }

    public function getDateOfVatRevenueRecognition(string $format = 'd.m.Y'): string
    {
        return $this->dateOfVatRevenueRecognition === null ? '' : $this->dateOfVatRevenueRecognition->format($format);
    }

    /** @return Item[] */
    public function getItems(): array
    {
        return $this->items;
    }

}
