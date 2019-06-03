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

use JackMD\Citation\Command\BaseCommand;
use function is_null;
use function strtolower;

class Handler{

	/** @var Citation */
	private $citation;

	/**
	 * Handler constructor.
	 *
	 * @param Citation $citation
	 */
	public function __construct(Citation $citation){
		$this->citation = $citation;
	}

	/**
	 * @param BaseCommand[] $commands
	 */
	public function registerAll(array $commands): void{
		foreach($commands as $command){
			$this->registerCommand($command);
		}
	}

	/**
	 * @param BaseCommand $command
	 */
	public function registerCommand(BaseCommand $command): void{
		$plugin = $this->citation->getPlugin();
		$commandName = $command->getName();

		$plugin->getServer()->getCommandMap()->register(strtolower($plugin->getName()), $command);
		$plugin->getLogger()->debug("Registered Command: §6$commandName");
	}

	/**
	 * @param string $commandName
	 */
	public function unregisterCommand(string $commandName): void{
		$commandMap = $this->citation->getPlugin()->getServer()->getCommandMap();

		if(!is_null($command = $commandMap->getCommand($commandName))){
			$commandMap->unregister($command);
		}
	}
}