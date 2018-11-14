<?php declare(strict_types=1);

namespace OndrejBrejla\Eciovni;

use Money\Money;
use Mpdf\Mpdf;
use Nette\Application\LinkGenerator;
use Nette\Application\UI\ITemplateFactory;
use Nette\Bridges\ApplicationLatte\Template;

/**
 * Eciovni - plugin for Nette Framework for generating invoices using mPDF library.
 *
 * @copyright  Copyright (c) 2009 Ondřej Brejla
 * @license    New BSD License
 * @link       http://github.com/OndrejBrejla/Eciovni
 */
class Eciovni
{

    /** @var Data|null */
    private $data;

    /** @var Template */
    private $template;

    /** @var string */
    private $templatePath;

	public function __construct(?Data $data, ITemplateFactory $templateFactory, LinkGenerator $linkGenerator)
	{
		if ($data !== null) {
            $this->setData($data);
        }

        $this->templatePath = __DIR__ . '/Eciovni.latte';

		/** @var Template $template */
		$template = $templateFactory->createTemplate();

		$this->template = $template;
		$this->template->getLatte()->addProvider('uiControl', $linkGenerator);
	}

    public function setTemplatePath(string $templatePath): void
    {
        $this->templatePath = $templatePath;
    }

    /**
     * Exports Invoice template via passed mPDF.
     */
    public function exportToPdf(Mpdf $mpdf, ?string $name = null, ?string $dest = null): ?string
    {
        $this->generate($this->template);
        $mpdf->WriteHTML((string) $this->template);

        $result = null;
        if (($name !== '') && ($dest !== null)) {
            $result = $mpdf->Output($name, $dest);
        } elseif ($dest !== null) {
            $result = $mpdf->Output('', $dest);
        } else {
            $result = $mpdf->Output($name, $dest);
        }
        return $result;
    }

    public function render(): void
    {
        $this->processRender();
    }

    /**
     * Renderers the invoice to the defined template.
     */
    public function renderData(Data $data): void
    {
        $this->setData($data);
        $this->processRender();
    }

    /**
     * Renderers the invoice to the defined template.
     */
    private function processRender(): void
    {
        $this->generate($this->template);
        $this->template->render();
    }

    /**
     * Sets the data, but only if it hasn't been set already.
     */
    private function setData(Data $data): void
    {
        if ($this->data !== null) {
            throw new IllegalStateException('Data have already been set!');
        }

	    $this->data = $data;
    }

    /**
     * Generates the invoice to the defined template.
     */
    private function generate(Template $template): void
    {
        $template->setFile($this->templatePath);
        $template->getLatte()->addFilter('round', function($value, $precision = 2) {
            return number_format(round($value, $precision), $precision, ',', '');
        });

        $template->title = $this->data->getTitle();
        $template->caption = (string) $this->data->getCaption();
        $template->id = $this->data->getId();
        $template->items = $this->data->getItems();
        $this->generateSupplier($template);
        $this->generateCustomer($template);
        $this->generateDates($template);
        $this->generateSymbols($template);
        $this->generateFinalValues($template);
    }

    /**
     * Generates supplier data into template.
     */
    private function generateSupplier(Template $template): void
    {
        $supplier = $this->data->getSupplier();
        $template->supplierName = $supplier->getName();
        $template->supplierStreet = $supplier->getStreet();
        $template->supplierHouseNumber = $supplier->getHouseNumber();
        $template->supplierCity = $supplier->getCity();
        $template->supplierZip = $supplier->getZip();
        $template->supplierIn = $supplier->getIn();
        $template->supplierTin = $supplier->getTin();
        $template->supplierAccountNumber = $supplier->getAccountNumber();
    }

    /**
     * Generates customer data into template.
     */
    private function generateCustomer(Template $template): void
    {
        $customer = $this->data->getCustomer();
        $template->customerName = $customer->getName();
        $template->customerStreet = $customer->getStreet();
        $template->customerHouseNumber = $customer->getHouseNumber();
        $template->customerCity = $customer->getCity();
        $template->customerZip = $customer->getZip();
        $template->customerIn = $customer->getIn();
        $template->customerTin = $customer->getTin();
        $template->customerAccountNumber = $customer->getAccountNumber();
    }

    /**
     * Generates dates into template.
     */
    private function generateDates(Template $template): void
    {
        $template->dateOfIssuance = $this->data->getDateOfIssuance();
        $template->expirationDate = $this->data->getExpirationDate();
        $template->dateOfVatRevenueRecognition = $this->data->getDateOfVatRevenueRecognition();
    }

    /**
     * Generates symbols into template.
     */
    private function generateSymbols(Template $template): void
    {
        $template->variableSymbol = $this->data->getVariableSymbol();
        $template->specificSymbol = $this->data->getSpecificSymbol();
        $template->constantSymbol = $this->data->getConstantSymbol();
    }

    /**
     * Generates final values into template.
     */
    private function generateFinalValues(Template $template): void
    {
        $template->finalUntaxedValue = $this->countFinalUntaxedValue();
        $template->finalTaxValue = $this->countFinalTaxValue();
        $template->finalValue = $this->countFinalValues();
    }

    /**
     * Counts final untaxed value of all items.
     */
    private function countFinalUntaxedValue(): Money
    {
        $sum = null;

        foreach ($this->data->getItems() as $item) {
        	if ($sum === null) {
        		$sum = $item->countUntaxedUnitValue()->multiply($item->getUnits());
	        } else {
        		$sum = $sum->add($item->countUntaxedUnitValue()->multiply($item->getUnits()));
	        }
        }

        return $sum;
    }

    /**
     * Counts final tax value of all items.
     */
    private function countFinalTaxValue(): Money
    {
        $sum = null;

        foreach ($this->data->getItems() as $item) {
	        if ($sum === null) {
		        $sum = $item->countTaxValue();
	        } else {
		        $sum = $sum->add($item->countTaxValue());
	        }
        }

        return $sum;
    }

    /**
     * Counts final value of all items.
     */
    private function countFinalValues(): Money
    {
        $sum = null;

        foreach ($this->data->getItems() as $item) {
	        if ($sum === null) {
		        $sum = $item->countFinalValue();
	        } else {
		        $sum = $sum->add($item->countFinalValue());
	        }
        }

        return $sum;
    }

}
