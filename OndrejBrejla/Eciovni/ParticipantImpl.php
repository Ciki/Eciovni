<?php

declare(strict_types=1);

namespace OndrejBrejla\Eciovni;

/**
 * ParticipantImpl - part of Eciovni plugin for Nette Framework.
 *
 * @copyright  Copyright (c) 2009 Ondřej Brejla
 * @license    New BSD License
 * @link       http://github.com/OndrejBrejla/Eciovni
 */
final class ParticipantImpl implements Participant
{
	private readonly string $name;

	private readonly string $street;

	private readonly string $houseNumber;

	private readonly string $city;

	private readonly string $zip;

	private readonly string $country;

	private ?string $in = null;

	private ?string $tin = null;

	private ?string $vatId = null;

	private readonly bool $vatPayer;

	private ?string $registryInfo = null;

	private ?string $accountNumber = null;


	public function __construct(ParticipantBuilder $participantBuilder)
	{
		$this->name = $participantBuilder->getName();
		$this->street = $participantBuilder->getStreet();
		$this->houseNumber = $participantBuilder->getHouseNumber();
		$this->city = $participantBuilder->getCity();
		$this->zip = $participantBuilder->getZip();
		$this->country = $participantBuilder->getCountry();
		$this->in = $participantBuilder->getIn();
		$this->tin = $participantBuilder->getTin();
		$this->vatId = $participantBuilder->getVatId();
		$this->vatPayer = $participantBuilder->isVatPayer();
		$this->registryInfo = $participantBuilder->getRegistryInfo();
		$this->accountNumber = $participantBuilder->getAccountNumber();
	}


	public function getName(): string
	{
		return $this->name;
	}


	public function getStreet(): string
	{
		return $this->street;
	}


	public function getHouseNumber(): string
	{
		return $this->houseNumber;
	}


	public function getCity(): string
	{
		return $this->city;
	}


	public function getZip(): string
	{
		return $this->zip;
	}


	public function getCountry(): string
	{
		return $this->country;
	}


	/**
	 * Returns the identification number of participant.
	 */
	public function getIn(): ?string
	{
		return $this->in;
	}


	/**
	 * Returns the tax identification number of participant.
	 */
	public function getTin(): ?string
	{
		return $this->tin;
	}


	public function getVatId(): ?string
	{
		return $this->vatId;
	}


	/**
	 * Tells whether a participant is a vat payer (TIN might not mean he actually IS a vat payer)
	 */
	public function isVatPayer(): bool
	{
		return $this->vatPayer;
	}


	public function getRegistryInfo(): ?string
	{
		return $this->registryInfo;
	}


	public function getAccountNumber(): ?string
	{
		return $this->accountNumber;
	}
}
