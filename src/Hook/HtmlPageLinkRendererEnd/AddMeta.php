<?php

namespace BlueSpice\UserInfo\Hook\HtmlPageLinkRendererEnd;

use FormatJson;
use Title;
use User;
use HtmlArmor;
use BlueSpice\Hook\HtmlPageLinkRendererEnd;

class AddMeta extends HtmlPageLinkRendererEnd {

	/**
	 *
	 * @return bool
	 */
	protected function skipProcessing() {
		if ( $this->target->isExternal() ) {
			return true;
		}
		if ( $this->target->getNamespace() !== NS_USER ) {
			return true;
		}
		$title = Title::newFromLinkTarget( $this->target );
		if ( !$title ) {
			return true;
		}
		if ( $title->isSubpage() ) {
			return true;
		}
		return false;
	}

	/**
	 *
	 * @return bool
	 */
	protected function doProcess() {
		$user = User::newFromName( $this->target->getText() );

		if ( !$user ) {
			// in rare cases $this->target->getText() returns '127.0.0.1' which
			// results in 'false' in User::newFromName
			return true;
		}

		$text = HtmlArmor::getHtml( $this->text );
		if ( $user->getName() === $text ) {
			$userHelper = $this->getServices()->getService( 'BSUtilityFactory' )
				->getUserHelper( $user );

			$this->text = new HtmlArmor( $userHelper->getDisplayName() );
		}

		$factory = $this->getServices()->getService(
			'BSUserInfoMetaDataFactory'
		);
		$userInfo = [
			'username' => $user->getName(),
			'meta' => [],
		];
		foreach ( $factory->getAllKeys() as $name ) {
			$metaData = $factory->factory( $name, $user );
			if ( $metaData === false ) {
				continue;
			}
			if ( $metaData->isHidden() ) {
				continue;
			}
			$userInfo['meta'][$metaData->getName()] = $metaData;
		}
		$this->attribs['data-bs-userinfo'] = FormatJson::encode( $userInfo );
		return true;
	}

}
