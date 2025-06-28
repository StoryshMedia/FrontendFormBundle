<?php

namespace Smug\FrontendFormBundle\Constants\Views\Backend;

use Smug\Core\Service\Base\Interfaces\Backend\BackendDataConstantsInterface;
use Smug\FrontendFormBundle\Entity\Form\Form;

class FormConstants implements BackendDataConstantsInterface
{
	const LIST_DATA = [
		'config' => [
			'columns' => [
				[
					'identifier' => 'title',
					'type' => 'string'
				]
			],
			'type' => 'table',
			'model' => Form::class,
			'listConfig' => [
				'showLogo' => false,
				'url' => [
					'detail' => true,
					'add' => true
				],
				'paginatorModel' => 'forms',
				'deleteSelected' => true,
				'batchProcessing' => false,
				'paginationLimits' => [5, 10, 20, 50, 100]
			],
			'sortings' => [],
			'filters' => []
		]
	];

	const DETAIL_DATA = [
		'config' => [
			'model' => Form::class,
			'url' => [
				'save' => true
			]
		],
		'tabs' => [
			[
				'headline' => 'BASE_SETTINGS',
				'type' => 'standard',
				'rows' => [
					[
						'class' => 'grid grid-cols-1 md:grid-cols-2 gap-5 my-5',
						'fields' => ["title", "emailTemplate"]
					],
					[
						'class' => 'grid grid-cols-1 md:grid-cols-2 gap-5 my-5',
						'fields' => ["senderName", "senderEmail"]
					],
					[
						'class' => 'grid grid-cols-1 gap-5 my-5',
						'fields' => ["subject"]
					]
				]
			],
			[
				'headline' => 'FIELDS',
				'type' => 'standard',
				'icon' => 'IconSettings',
				'rows' => [
					[
						'class' => 'grid grid-cols-1',
						'fields' => ["fields"]
					]
				]
			],
			[
				'headline' => 'RESULTS',
				'type' => 'standard',
				'icon' => 'IconSettings',
				'rows' => [
					[
						'class' => 'grid grid-cols-1',
						'fields' => ["results"]
					]
				]
			]
		]
	];

	const ADD_DATA = [
		'config' => [
			'model' => Form::class,
			'url' => [
				'save' => true
			],
			'processEvent' => 'formAdded'
		],
		'tabs' => [
			[
				'headline' => 'BASE_SETTINGS',
				'type' => 'standard',
				'rows' => [
					[
						'class' => 'grid grid-cols-1 md:grid-cols-2 gap-5 my-5',
						'fields' => ["title", "emailTemplate"]
					],
					[
						'class' => 'grid grid-cols-1 md:grid-cols-2 gap-5 my-5',
						'fields' => ["senderName", "senderEmail"]
					],
					[
						'class' => 'grid grid-cols-1 gap-5 my-5',
						'fields' => ["subject"]
					]
				]
			]
		]
	];

	public static function getListConstants(): array
	{
		return self::LIST_DATA;
	}

	public static function getDetailConstants(): array
	{
		return self::DETAIL_DATA;
	}

	public static function getAddConstants(): array
	{
		return self::ADD_DATA;
	}

	public static function getReadingRights(): string
	{
		return '';
	}

	public static function getWritingRights(): string
	{
		return '';
	}
}
