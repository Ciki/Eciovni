<?php

declare(strict_types=1);

namespace OndrejBrejla\Eciovni;

use DateTimeImmutable;

/**
 * DataBuilder - part of Eciovni plugin for Nette Framework.
 *
 * @copyright  Copyright (c) 2009 Ondřej Brejla
 * @license    New BSD License
 * @link       http://github.com/OndrejBrejla/Eciovni
 */
final class DataBuilder
{
	private ?string $caption = null;

	private ?string $signatureText = null;

	private ?string $signatureImgSrc = null;

	private ?string $supplierLogoImgSrc = null;

	private ?string $variableSymbol = null;

	private ?string $constantSymbol = null;

	private ?string $specificSymbol = null;

	private ?DateTimeImmutable $dateOfDelivery = null;

	private ?DateTimeImmutable $dateOfVatRevenueRecognition = null;

	/** @var list<Item> */
	private array $items = [];

	/** @var list<float> */
	private array $vatRates = [];


	/**
	 * @param list<Item> $items
	 */
	public function __construct(
		private readonly string $id,
		private readonly string $title,
		private readonly Participant $supplier,
		private readonly Participant $customer,
		private readonly Participant $recipient,
		private readonly DateTimeImmutable $dueDate,
		private readonly DateTimeImmutable $dateOfIssuance,
		array $items,
		private readonly ?string $paymentType
	) {
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


	public function getRecipient(): Participant
	{
		return $this->recipient;
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


	public function getDueDate(): DateTimeImmutable
	{
		return $this->dueDate;
	}


	public function getDateOfIssuance(): DateTimeImmutable
	{
		return $this->dateOfIssuance;
	}


	public function getDateOfDelivery(): ?DateTimeImmutable
	{
		return $this->dateOfDelivery;
	}


	public function getDateOfVatRevenueRecognition(): ?DateTimeImmutable
	{
		return $this->dateOfVatRevenueRecognition;
	}


	/**
	 * @return list<Item>
	 */
	public function getItems(): array
	{
		return $this->items;
	}


	/**
	 * @return list<float>
	 */
	public function getVatRates(): array
	{
		return $this->vatRates;
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


	/**
	 * @param list<Item> $items
	 */
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


	public function setDateOfDelivery(?DateTimeImmutable $dateOfDelivery): self
	{
		$this->dateOfDelivery = $dateOfDelivery;
		return $this;
	}


	public function setDateOfVatRevenueRecognition(?DateTimeImmutable $dateOfTaxablePayment): self
	{
		$this->dateOfVatRevenueRecognition = $dateOfTaxablePayment;
		return $this;
	}


	/**
	 * @param list<float> $vatRates
	 */
	public function setVatRates(array $vatRates): self
	{
		$this->vatRates = $vatRates;
		return $this;
	}
}
