<?php

namespace BlueSpice\UserInfo\Hook\BSFoundationRendererMakeTagAttribs;

use FormatJson;
use BlueSpice\Renderer\UserImage;
use BlueSpice\Hook\BSFoundationRendererMakeTagAttribs;

class AddMetaData extends BSFoundationRendererMakeTagAttribs {
	/**
	 *
	 * @return bool
	 */
	protected function skipProcessing() {
		if ( !$this->renderer instanceof UserImage ) {
			return true;
		}
		return false;
	}

	/**
	 *
	 * @return bool
	 */
	protected function doProcess() {
		$user = $this->renderer->getUser();
		$factory = $this->getServices()->getService(
			'BSUserInfoMetaDataFactory'
		);
		$userInfo = [
			'username' => $user->getName(),
			'meta' => [],
		];
		foreach ( $factory->getAllKeys() as $name ) {
			$metaData = $factory->factory( $name, $user );
			if ( !$metaData || $metaData->isHidden() ) {
				continue;
			}
			$userInfo['meta'][$metaData->getName()] = $metaData;
		}
		$this->attribs['data-bs-userinfo'] = FormatJson::encode( $userInfo );
		return true;
	}
}
