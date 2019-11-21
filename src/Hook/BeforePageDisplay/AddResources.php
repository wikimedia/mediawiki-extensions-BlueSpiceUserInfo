<?php

namespace BlueSpice\UserInfo\Hook\BeforePageDisplay;

use BlueSpice\Hook\BeforePageDisplay;

class AddResources extends BeforePageDisplay {

	protected function doProcess() {
		$this->out->addModuleStyles( 'ext.bluespice.userinfo.styles' );
		$this->out->addModules( 'ext.bluespice.userinfo' );
		return true;
	}
}
