<?php declare(strict_types=1);

namespace OndrejBrejla\Eciovni;

/**
 * ParticipantImpl - part of Eciovni plugin for Nette Framework.
 *
 * @copyright  Copyright (c) 2009 Ondřej Brejla
 * @license    New BSD License
 * @link       http://github.com/OndrejBrejla/Eciovni
 */
class ParticipantImpl implements Participant
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

    /** @var string */
    private $in;

	/** @var ?string */
    private $tin;

    /** @var bool */
    private $vatPayer;

	/** @var ?string */
    private $accountNumber;

    public function __construct(ParticipantBuilder $participantBuilder) {
        $this->name = $participantBuilder->getName();
        $this->street = $participantBuilder->getStreet();
        $this->houseNumber = $participantBuilder->getHouseNumber();
        $this->city = $participantBuilder->getCity();
        $this->zip = $participantBuilder->getZip();
        $this->in = $participantBuilder->getIn();
        $this->tin = $participantBuilder->getTin();
        $this->vatPayer = $participantBuilder->isVatPayer();
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

    public function getAccountNumber(): ?string
    {
        return $this->accountNumber;
    }

}
