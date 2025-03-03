<?php
/**
 * Hook handler base class for BlueSpice hook BSUserInfoMetaDataFactoryAllKeys
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
 * For further information visit https://bluespice.com
 *
 * @author     Patric Wirth
 * @package    BlueSpiceUserInfo
 * @copyright  Copyright (C) 2017 Hallo Welt! GmbH, All rights reserved.
 * @license    http://www.gnu.org/copyleft/gpl.html GPL-3.0-only
 * @filesource
 */
namespace BlueSpice\UserInfo\Hook;

use BlueSpice\Hook;
use MediaWiki\Config\Config;
use MediaWiki\Context\IContextSource;

abstract class BSUserInfoMetaDataFactoryAllKeys extends Hook {

	/**
	 *
	 * @var array
	 */
	protected $keys = null;

	/**
	 *
	 * @param array &$keys
	 * @return bool
	 */
	public static function callback( &$keys ) {
		$className = static::class;
		$hookHandler = new $className(
			null,
			null,
			$keys
		);
		return $hookHandler->process();
	}

	/**
	 *
	 * @param IContextSource $context
	 * @param Config $config
	 * @param array &$keys
	 */
	public function __construct( $context, $config, &$keys ) {
		parent::__construct( $context, $config );

		$this->keys = &$keys;
	}
}
