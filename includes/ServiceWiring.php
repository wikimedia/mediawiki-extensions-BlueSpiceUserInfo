<?php

use BlueSpice\ExtensionAttributeBasedRegistry;
use MediaWiki\MediaWikiServices;

return [

	'BSUserInfoMetaDataFactory' => static function ( MediaWikiServices $services ) {
		$registry = new ExtensionAttributeBasedRegistry(
			'BlueSpiceUserInfoMetaData'
		);
		return new \BlueSpice\UserInfo\MetaDataFactory(
			$registry,
			$services->getConfigFactory()->makeConfig( 'bsg' ),
			$services->getHookContainer()
		);
	},
];
