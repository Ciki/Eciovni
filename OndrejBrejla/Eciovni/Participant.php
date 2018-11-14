<?php

namespace OndrejBrejla\Eciovni;

/**
 * Participant - part of Eciovni plugin for Nette Framework.
 *
 * @copyright  Copyright (c) 2009 Ondřej Brejla
 * @license    New BSD License
 * @link       http://github.com/OndrejBrejla/Eciovni
 */
interface Participant {

    /**
     * Returns the name of participant.
     *
     * @return string
     */
    public function getName();

    /**
     * Sets the street of participant.
     *
     * @param string $street
     * @return string
     */
    public function getStreet();

    /**
     * Returns the house number of participant.
     *
     * @return string
     */
    public function getHouseNumber();

    /**
     * Returns the city of participant.
     *
     * @return string
     */
    public function getCity();

    /**
     * Returns the zip of participant.
     *
     * @return string
     */
    public function getZip();

    /**
     * Returns the identification number of participant.
     *
     * @return string
     */
    public function getIn();

    /**
     * Returns the tax identification number of participant.
     *
     * @return string
     */
    public function getTin();

	/**
	 * Tells whether a participant is a vat payer (TIN might not mean he actually IS a vat payer)
	 *
	 * @return bool
	 */
    public function isVatPayer();

    /**
     * Returns the account number of participant.
     *
     * @return string
     */
    public function getAccountNumber();

}
