<?php
declare(strict_types=1);

namespace OndrejBrejla\Eciovni;

/**
 * Participant - part of Eciovni plugin for Nette Framework.
 *
 * @copyright  Copyright (c) 2009 Ondřej Brejla
 * @license    New BSD License
 * @link       http://github.com/OndrejBrejla/Eciovni
 */
interface Participant
{

    public function getName(): string;

    public function getStreet(): string;

    public function getHouseNumber(): string;

    public function getCity(): string;

    public function getZip(): string;

	public function getCountry(): string;

    /**
     * Returns the identification number of participant.
     */
    public function getIn(): ?string;

    /**
     * Returns the tax identification number of participant.
     */
    public function getTin(): ?string;

	public function getVatId(): ?string;

	/**
	 * Tells whether a participant is a vat payer (TIN might not mean he actually IS a vat payer)
	 */
    public function isVatPayer(): bool;

    public function getAccountNumber(): ?string;
}