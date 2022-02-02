<?php
declare(strict_types=1);

namespace OndrejBrejla\Eciovni;

use Nette\Application\LinkGenerator;
use Nette\Application\UI\ITemplateFactory;
use Nette\Localization\Translator;

/**
 * @author Pavel Jurásek
 */
class EciovniFactory
{
	/** @var ITemplateFactory */
	private $templateFactory;

	/** @var LinkGenerator */
	private $linkGenerator;

	/** @var Translator */
	private $translator;


	public function __construct(ITemplateFactory $templateFactory,
		LinkGenerator $linkGenerator, ?Translator $translator = null)
	{
		$this->templateFactory = $templateFactory;
		$this->linkGenerator = $linkGenerator;
		$this->setTranslator($translator);
	}


	public function setTranslator(?Translator $translator = null): void
	{
		$this->translator = $translator;
	}


	public function create(?Data $data = null): Eciovni
	{
		return new Eciovni($data, $this->templateFactory, $this->linkGenerator, $this->translator);
	}


}