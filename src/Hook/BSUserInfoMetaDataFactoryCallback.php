<?php
/**
 * Hook handler base class for BlueSpice hook BSUserInfoMetaDataFactoryCallback
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
 * @copyright  Copyright (C) 2017 Hallo Welt! GmbH, All rights reserved.
 * @license    http://www.gnu.org/copyleft/gpl.html GPL-3.0-only
 * @filesource
 */
namespace BlueSpice\UserInfo\Hook;

use IContextSource;
use Config;
use User;
use BlueSpice\Hook;

abstract class BSUserInfoMetaDataFactoryCallback extends Hook {

	/**
	 *
	 * @var string
	 */
	protected $name = null;

	/**
	 *
	 * @var User
	 */
	protected $user = null;

	/**
	 *
	 * @var string
	 */
	protected $callback = null;

	/**
	 *
	 * @param string $name
	 * @param User $user
	 * @param string &$callback
	 * @return bool
	 */
	public static function callback( $name, $user, &$callback ) {
		$className = static::class;
		$hookHandler = new $className(
			null,
			null,
			$name,
			$user,
			$callback
		);
		return $hookHandler->process();
	}

	/**
	 *
	 * @param IContextSource $context
	 * @param Config $config
	 * @param string $name
	 * @param User $user
	 * @param string &$callback
	 */
	public function __construct( $context, $config, $name, $user, &$callback ) {
		parent::__construct( $context, $config );

		$this->name = $name;
		$this->user = $user;
		$this->callback = &$callback;
	}
}
