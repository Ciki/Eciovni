<?php
declare(strict_types=1);

namespace OndrejBrejla\Eciovni;

use DateTime;

/**
 * DataBuilder - part of Eciovni plugin for Nette Framework.
 *
 * @copyright  Copyright (c) 2009 Ondřej Brejla
 * @license    New BSD License
 * @link       http://github.com/OndrejBrejla/Eciovni
 */
class DataBuilder
{
	/** @var string */
	private $title;

	/** @var ?string */
	private $caption;

	/** @var string */
	private $id;

	/** @var ?string */
	private $signatureText;

	/** @var ?string */
	private $signatureImgSrc;

	/** @var ?string */
	private $supplierLogoImgSrc;

	/** @var Participant */
	private $supplier;

	/** @var Participant */
	private $customer;

	/** @var ?string */
	private $paymentType;

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
	private $dateOfDelivery;

	/** @var ?DateTime */
	private $dateOfVatRevenueRecognition;

	/** @var Item[] */
	private $items = [];


	public function __construct(string $id, string $title, Participant $supplier,
		Participant $customer, DateTime $expirationDate, DateTime $dateOfIssuance,
		array $items, string $paymentType)
	{
		$this->id = $id;
		$this->title = $title;
		$this->supplier = $supplier;
		$this->customer = $customer;
		$this->paymentType = $paymentType;
		$this->expirationDate = $expirationDate;
		$this->dateOfIssuance = $dateOfIssuance;
		$this->addItems($items);
	}


	/**
	 * Same as DataImpl methods declarations below
	 */
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


	public function getSignatureText(): ?string
	{
		return $this->signatureText;
	}


	public function getSignatureImgSrc(): ?string
	{
		return $this->signatureImgSrc;
	}


	public function getSupplierLogoImgSrc(): ?string
	{
		return $this->supplierLogoImgSrc;
	}


	public function getSupplier(): Participant
	{
		return $this->supplier;
	}


	public function getCustomer(): Participant
	{
		return $this->customer;
	}


	public function getPaymentType(): ?string
	{
		return $this->paymentType;
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


	public function getExpirationDate(): DateTime
	{
		return $this->expirationDate;
	}


	public function getDateOfIssuance(): DateTime
	{
		return $this->dateOfIssuance;
	}


	public function getDateOfDelivery(): ?DateTime
	{
		return $this->dateOfDelivery;
	}


	public function getDateOfVatRevenueRecognition(): ?DateTime
	{
		return $this->dateOfVatRevenueRecognition;
	}


	/** @return Item[] */
	public function getItems(): array
	{
		return $this->items;
	}


	public function build(): Data
	{
		return new DataImpl($this);
	}


	/**
	 * Same as DataImpl methods declarations above END
	 */
	public function setCaption(?string $caption): void
	{
		$this->caption = $caption;
	}


	public function setSignatureText(?string $text): self
	{
		$this->signatureText = $text;
		return $this;
	}


	public function setSignatureImgSrc(?string $src): self
	{
		$this->signatureImgSrc = $src;
		return $this;
	}


	public function setSupplierLogoImgSrc(?string $src): self
	{
		$this->supplierLogoImgSrc = $src;
		return $this;
	}


	/** @param Item[] $items */
	private function addItems(array $items): void
	{
		foreach ($items as $item) {
			$this->addItem($item);
		}
	}


	private function addItem(Item $item): void
	{
		$this->items[] = $item;
	}


	public function setVariableSymbol(?string $variableSymbol): self
	{
		$this->variableSymbol = $variableSymbol;
		return $this;
	}


	public function setConstantSymbol(?string $constantSymbol): self
	{
		$this->constantSymbol = $constantSymbol;
		return $this;
	}


	public function setSpecificSymbol(?string $specificSymbol): self
	{
		$this->specificSymbol = $specificSymbol;
		return $this;
	}


	public function setDateOfDelivery(?DateTime $dateOfDelivery): self
	{
		$this->dateOfDelivery = $dateOfDelivery;
		return $this;
	}


	public function setDateOfVatRevenueRecognition(?DateTime $dateOfTaxablePayment): self
	{
		$this->dateOfVatRevenueRecognition = $dateOfTaxablePayment;
		return $this;
	}


}