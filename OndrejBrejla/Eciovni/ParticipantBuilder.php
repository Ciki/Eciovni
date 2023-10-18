<?php

declare(strict_types=1);

namespace OndrejBrejla\Eciovni;

/**
 * ParticipantBuilder - part of Eciovni plugin for Nette Framework.
 * @copyright  Copyright (c) 2009 Ondřej Brejla
 * @license    New BSD License
 * @link       http://github.com/OndrejBrejla/Eciovni
 */
final class ParticipantBuilder
{
	private ?string $in = null;

	private ?string $tin = null;

	private ?string $vatId = null;

	private bool $vatPayer = false;

	private ?string $registryInfo = null;

	private ?string $accountNumber = null;


	public function __construct(
		private readonly string $name,
		private readonly string $street,
		private readonly string $houseNumber,
		private readonly string $city,
		private readonly string $zip,
		private readonly string $country
	) {
	}


	public function setIn(?string $in): self
	{
		$this->in = $in;
		return $this;
	}


	public function setTin(?string $tin): self
	{
		$this->tin = $tin;
		return $this;
	}


	public function setVatId(?string $vatId): self
	{
		$this->vatId = $vatId;
		return $this;
	}


	public function setVatPayer(bool $vatPayer): self
	{
		$this->vatPayer = $vatPayer;
		return $this;
	}


	public function setRegistryInfo(?string $info): self
	{
		$this->registryInfo = $info;
		return $this;
	}


	public function setAccountNumber(?string $accountNumber): self
	{
		$this->accountNumber = $accountNumber;
		return $this;
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


	public function getIn(): ?string
	{
		return $this->in;
	}


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


	public function build(): Participant
	{
		return new ParticipantImpl($this);
	}
}
