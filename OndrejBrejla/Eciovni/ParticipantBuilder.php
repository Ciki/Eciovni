<?php declare(strict_types=1);

namespace OndrejBrejla\Eciovni;

/**
 * ParticipantBuilder - part of Eciovni plugin for Nette Framework.
 * @copyright  Copyright (c) 2009 Ondřej Brejla
 * @license    New BSD License
 * @link       http://github.com/OndrejBrejla/Eciovni
 */
class ParticipantBuilder
{

    /** @var string */
    private $name;

    /** @var string */
    private $street;

    /** @var string */
    private $houseNumber;

    /** @var string */
    private $city;

    /** @var string */
    private $zip;

    /** @var string|null */
    private $in;

    /** @var string|null */
    private $tin;

    /** @var bool */
    private $vatPayer = false;

    /** @var string|null */
    private $accountNumber;

    public function __construct(string $name, string $street, string $houseNumber, string $city, string $zip) {
        $this->name = $name;
        $this->street = $street;
        $this->houseNumber = $houseNumber;
        $this->city = $city;
        $this->zip = $zip;
    }

    /**
     * Sets the identification number of participant.
     */
    public function setIn(?string $in): self
    {
        $this->in = $in;
        return $this;
    }

    /**
     * Sets the tax identification number of participant.
     */
    public function setTin(?string $tin): self {
        $this->tin = $tin;
        return $this;
    }

	public function setVatPayer(bool $vatPayer): self
	{
		$this->vatPayer = $vatPayer;
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

	/**
	 * Tells whether a participant is a vat payer (TIN might not mean he actually IS a vat payer)
	 */
	public function isVatPayer(): bool
	{
		return $this->vatPayer;
	}

    /**
     * Returns the account number of participant.
     */
    public function getAccountNumber(): ?string
    {
        return $this->accountNumber;
    }

    public function build(): Participant
    {
        return new ParticipantImpl($this);
    }

}
