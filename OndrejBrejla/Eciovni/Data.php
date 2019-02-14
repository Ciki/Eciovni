<?php
declare(strict_types=1);

namespace OndrejBrejla\Eciovni;

/**
 * Data - part of Eciovni plugin for Nette Framework.
 *
 * @copyright  Copyright (c) 2009 Ondřej Brejla
 * @license    New BSD License
 * @link       http://github.com/OndrejBrejla/Eciovni
 */
interface Data
{

	/**
	 * Returns the invoice title.
	 */
	public function getTitle(): string;

	public function getCaption(): ?string;

	/**
	 * Returns the invoice id.
	 */
	public function getId(): string;

	public function getSupplier(): Participant;

	public function getCustomer(): Participant;

	public function getPaymentType(): ?string;

	public function getVariableSymbol(): ?string;

	public function getConstantSymbol(): ?string;

	public function getSpecificSymbol(): ?string;

	public function getExpirationDate(string $format = 'd.m.Y'): string;

	public function getDateOfIssuance(string $format = 'd.m.Y'): string;

	public function getDateOfDelivery(string $format = 'd.m.Y'): string;

	public function getDateOfVatRevenueRecognition(string $format = 'd.m.Y'): string;

	/** @return Item[] */
	public function getItems(): array;
}