<?php

namespace Smug\FrontendFormBundle\Constants\Config\Backend;

use Smug\FrontendFormBundle\Entity\Form\Form;

class FormFieldConstants
{
	const MAPPING = [
		'returnObject' => false,
		'mapValues' => [
			[
				'identifier' => 'form',
				'class' => Form::class
			]
		]
	];
}
