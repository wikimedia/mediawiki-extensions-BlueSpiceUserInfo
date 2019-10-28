<?php

namespace BlueSpice\UserInfo\MetaData;

use BlueSpice\UserInfo\MetaData;
use BlueSpice\Services;

class Name extends MetaData {

	public function getLabel() {
		return \Message::newFromKey(
			"bs-userinfo-metadata-name"
		)->plain();
	}

	public function getValue() {
		$userHelper = Services::getInstance()->getBSUtilityFactory()
			->getUserHelper( $this->user );

		return $userHelper->getDisplayName();
	}

	/**
	 *
	 * @return bool
	 */
	public function isTitle() {
		return true;
	}

}
