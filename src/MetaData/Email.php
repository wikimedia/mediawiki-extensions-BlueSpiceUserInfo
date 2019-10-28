<?php
namespace BlueSpice\UserInfo\MetaData;
use BlueSpice\UserInfo\MetaData;

class Email extends MetaData {

	public function getLabel() {
		return \Message::newFromKey(
			"bs-userinfo-metadata-email"
		)->plain();
	}

	public function getValue() {
		return $this->user->getEmail();
	}

	/**
	 *
	 * @return bool
	 */
	public function isSubTitle() {
		return true;
	}

}
