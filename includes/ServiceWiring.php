<?php

use BlueSpice\ExtensionAttributeBasedRegistry;
use MediaWiki\MediaWikiServices;

// PHP unit does not understand code coverage for this file
// as the @covers annotation cannot cover a specific file
// This is fully tested in ServiceWiringTest.php
// @codeCoverageIgnoreStart

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

// @codeCoverageIgnoreEnd
