<?php

declare(strict_types=1);

namespace OndrejBrejla\Eciovni;

use Nette\Application\LinkGenerator;
use Nette\Application\UI\TemplateFactory;
use Nette\Localization\Translator;

final class EciovniFactory
{
	public function __construct(
		private readonly TemplateFactory $templateFactory,
		private readonly LinkGenerator $linkGenerator,
		private ?Translator $translator = null
	) {
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
