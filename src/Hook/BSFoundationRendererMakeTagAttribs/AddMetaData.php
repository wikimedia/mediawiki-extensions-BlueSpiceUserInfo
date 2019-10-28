<?php

namespace BlueSpice\UserInfo\Hook\BSFoundationRendererMakeTagAttribs;
use BlueSpice\Hook\BSFoundationRendererMakeTagAttribs;

class AddMetaData extends BSFoundationRendererMakeTagAttribs {
	protected function skipProcessing() {
		if( !$this->renderer instanceof \BlueSpice\Renderer\UserImage ) {
			return true;
		}
		return false;
	}

	protected function doProcess() {
		$user = $this->renderer->getUser();
		$factory = $this->getServices()->getService(
			'BSUserInfoMetaDataFactory'
		);
		$userInfo = [
			'username' => $user->getName(),
			'meta' => [],
		];
		foreach( $factory->getAllKeys() as $name ) {
			if( !$metaData = $factory->factory( $name, $user ) ) {
				continue;
			}
			if( $metaData->isHidden() ) {
				continue;
			}
			$userInfo['meta'][$metaData->getName()] = $metaData;
		}
		$this->attribs['data-bs-userinfo'] = \FormatJson::encode( $userInfo );
	}
}
