<?php
declare(strict_types = 1);

/**
 *   ____ _ _        _   _
 *  / __ (_) |      | | (_)
 * | /  \/_| |_ __ _| |_ _  ___  _ __
 * | |   | | __/ _` | __| |/ _ \| '_ \
 * | \__/\ | || (_| | |_| | (_) | | | |
 *  \____/_|\__\__,_|\__|_|\___/|_| |_|
 *
 * Citation, a virion for PocketMine-MP.
 * Copyright (c) 2018 JackMD  < https://github.com/JackMD/Citation >
 *
 * Discord: JackMD#3717
 * Twitter: JackMTaylor_
 *
 * This software is distributed under "GNU General Public License v3.0".
 * This license allows you to use it and/or modify it but you are not at
 * all allowed to sell this plugin at any cost. If found doing so the
 * necessary action required would be taken.
 *
 * Citation is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 * GNU General Public License v3.0 for more details.
 *
 * You should have received a copy of the GNU General Public License v3.0
 * along with this program. If not, see
 * <https://opensource.org/licenses/GPL-3.0>.
 * ------------------------------------------------------------------------
 */

namespace JackMD\Citation;

use pocketmine\plugin\Plugin;
use function is_null;

class Citation{

	/** @var string|null */
	private static $prefix = null;

	/** @var Plugin */
	private $plugin;
	/** @var Handler */
	private $handler;

	/**
	 * Citation constructor.
	 *
	 * @param Plugin      $plugin
	 * @param string|null $prefix
	 */
	public function __construct(Plugin $plugin, ?string $prefix = null){
		$this->plugin = $plugin;
		self::$prefix = $prefix;

		$this->handler = new Handler($this);
	}

	/**
	 * @return string
	 */
	public static function getPrefix(): string{
		return is_null(self::$prefix) ? "" : self::$prefix;
	}

	/**
	 * @return Plugin
	 */
	public function getPlugin(): Plugin{
		return $this->plugin;
	}

	/**
	 * @return Handler
	 */
	public function getHandler(): Handler{
		return $this->handler;
	}
}