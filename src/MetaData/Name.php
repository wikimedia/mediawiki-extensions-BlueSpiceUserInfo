<?php

namespace BlueSpice\UserInfo\MetaData;

use Message;
use BlueSpice\UserInfo\MetaData;
use BlueSpice\Services;

class Name extends MetaData {

	/**
	 *
	 * @return Message
	 */
	public function getLabel() {
		return Message::newFromKey(
			"bs-userinfo-metadata-name"
		)->plain();
	}

	/**
	 *
	 * @return string
	 */
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
