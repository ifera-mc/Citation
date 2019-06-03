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

namespace JackMD\Citation\Command;

use pocketmine\command\CommandSender;

abstract class SubCommand{

	/** @var string */
	private $name;
	/** @var string */
	private $permission;
	/** @var string */
	private $description;
	/** @var string */
	private $usage;
	/** @var array */
	private $aliases;

	/**
	 * SubCommand constructor.
	 *
	 * @param string $name
	 * @param string $permission
	 * @param string $description
	 * @param string $usage
	 * @param array  $aliases
	 */
	public function __construct(string $name, string $permission, string $description, string $usage, array $aliases = []){
		$this->name = $name;
		$this->permission = $permission;
		$this->description = $description;
		$this->usage = $usage;
		$this->aliases = $aliases;
	}

	/**
	 * @return string
	 */
	public function getName(): string{
		return $this->name;
	}

	/**
	 * @return string
	 */
	public function getPermission(): string{
		return $this->permission;
	}

	/**
	 * @return string
	 */
	public function getDescription(): string{
		return $this->description;
	}

	/**
	 * @param CommandSender $sender
	 * @return bool
	 */
	public function canUse(CommandSender $sender): bool{
		return $sender->hasPermission($this->permission);
	}

	/**
	 * @return string
	 */
	public function getUsage(): string{
		return $this->usage;
	}

	/**
	 * @return array
	 */
	public function getAliases(): array{
		return $this->aliases;
	}

	/**
	 * @param CommandSender $sender
	 * @param array         $args
	 */
	public abstract function execute(CommandSender $sender, array $args): void;
}