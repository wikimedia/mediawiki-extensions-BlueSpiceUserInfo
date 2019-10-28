<?php
/**
 * MetaDataFactory class for BlueSpice
 *
 * This program is free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, version 3.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License along
 * with this program; if not, write to the Free Software Foundation, Inc.,
 * 51 Franklin Street, Fifth Floor, Boston, MA 02110-1301, USA.
 *
 * This file is part of BlueSpice MediaWiki
 * For further information visit http://bluespice.com
 *
 * @author     Patric Wirth <wirth@hallowelt.com>
 * @package    BlueSpiceUserInfo
 * @copyright  Copyright (C) 2016 Hallo Welt! GmbH, All rights reserved.
 * @license    http://www.gnu.org/copyleft/gpl.html GPL-3.0-only
 * @filesource
 */
namespace BlueSpice\UserInfo;
use BlueSpice\IRegistry;

class MetaDataFactory {

	/**
	 *
	 * @var IRegistry
	 */
	protected $registry = null;

	/**
	 *
	 * @var \Config
	 */
	protected $config = null;

	/**
	 *
	 * @param IRegistry $registry
	 * @param \Config $config
	 */
	public function __construct( $registry, $config ) {
		$this->registry = $registry;
		$this->config = $config;
	}

	/**
	 *
	 * @param string $name
	 * @return IMetaData|false The users MetaData or false if the user is
	 * not logged in
	 */
	public function factory( $name, \User $user = null ) {
		if( !$user instanceof \User ) {
			$user = \RequestContext::getMain();
		}
		if( $user->isAnon() ) {
			return false;
		}
		$callback = $this->registry->getValue( $name, false );
		\Hooks::run( 'BSUserInfoMetaDataFactoryCallback', [
			$name,
			$user,
			&$callback
		]);
		if( !$callback ) {
			throw new \MWException( "Invalid registry for $name" );
		}
		if( !is_callable( $callback ) ) {
			throw new \MWException( "$name not callable" );
		}
		$metaData = call_user_func_array( $callback, [
			$this->config,
			$name,
			$user,
			$this->isInitialHidden( $name )
		]);

		return $metaData;
	}

	/**
	 *
	 * @return array
	 */
	public function getAllKeys() {
		$keys = $this->registry->getAllKeys();
		\Hooks::run( 'BSUserInfoMetaDataFactoryAllKeys', [
			&$keys
		]);
		return $keys;
	}

	/**
	 *
	 * @return boolean
	 */
	protected function isInitialHidden( $name ) {
		return in_array( $name, $this->config->get( 'UserInfoHiddenMeta' ) );
	}

}
