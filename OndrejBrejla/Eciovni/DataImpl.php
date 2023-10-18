<?php

declare(strict_types=1);

namespace OndrejBrejla\Eciovni;

use DateTimeImmutable;

/**
 * DataImpl - part of Eciovni plugin for Nette Framework.
 *
 * @copyright  Copyright (c) 2009 Ondřej Brejla
 * @license    New BSD License
 * @link       http://github.com/OndrejBrejla/Eciovni
 */
final class DataImpl implements Data
{
	private readonly string $title;

	private ?string $caption = null;

	private readonly string $id;

	private ?string $signatureText = null;

	private ?string $signatureImgSrc = null;

	private ?string $supplierLogoImgSrc = null;

	private readonly Participant $supplier;

	private readonly Participant $customer;

	private readonly Participant $recipient;

	private ?string $paymentType = null;

	private ?string $variableSymbol = null;

	private ?string $constantSymbol = null;

	private ?string $specificSymbol = null;

	private readonly DateTimeImmutable $dueDate;

	private readonly DateTimeImmutable $dateOfIssuance;

	private ?DateTimeImmutable $dateOfDelivery = null;

	private ?DateTimeImmutable $dateOfVatRevenueRecognition = null;

	/** @var list<Item> */
	private array $items = [];

	private ?VatSummaryImpl $vatSummary = null;


	public function __construct(DataBuilder $dataBuilder)
	{
		$this->title = $dataBuilder->getTitle();
		$this->caption = $dataBuilder->getCaption();
		$this->id = $dataBuilder->getId();
		$this->signatureText = $dataBuilder->getSignatureText();
		$this->signatureImgSrc = $dataBuilder->getSignatureImgSrc();
		$this->supplierLogoImgSrc = $dataBuilder->getSupplierLogoImgSrc();
		$this->supplier = $dataBuilder->getSupplier();
		$this->customer = $dataBuilder->getCustomer();
		$this->recipient = $dataBuilder->getRecipient();
		$this->paymentType = $dataBuilder->getPaymentType();
		$this->variableSymbol = $dataBuilder->getVariableSymbol();
		$this->constantSymbol = $dataBuilder->getConstantSymbol();
		$this->specificSymbol = $dataBuilder->getSpecificSymbol();
		$this->dueDate = $dataBuilder->getDueDate();
		$this->dateOfIssuance = $dataBuilder->getDateOfIssuance();
		$this->dateOfDelivery = $dataBuilder->getDateOfDelivery();
		$this->dateOfVatRevenueRecognition = $dataBuilder->getDateOfVatRevenueRecognition();
		$this->items = $dataBuilder->getItems();

		$vatRates = $dataBuilder->getVatRates();
		if ($vatRates) {
			$this->vatSummary = new VatSummaryImpl($vatRates, $this->items);
		}
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


	public function getDueDate(string $format = 'd.m.Y'): string
	{
		return $this->dueDate->format($format);
	}


	public function getDateOfIssuance(string $format = 'd.m.Y'): string
	{
		return $this->dateOfIssuance->format($format);
	}


	public function getDateOfDelivery(string $format = 'd.m.Y'): string
	{
		return $this->dateOfDelivery ? $this->dateOfDelivery->format($format) : '';
	}


	public function getDateOfVatRevenueRecognition(string $format = 'd.m.Y'): string
	{
		return $this->dateOfVatRevenueRecognition ? $this->dateOfVatRevenueRecognition->format($format) : '';
	}


	/**
	 * @return list<Item>
	 */
	public function getItems(): array
	{
		return $this->items;
	}


	public function getVatSummary(): ?VatSummary
	{
		return $this->vatSummary;
	}
}
