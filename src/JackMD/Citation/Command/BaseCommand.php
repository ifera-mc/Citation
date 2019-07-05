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

use JackMD\Citation\Citation;
use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\command\ConsoleCommandSender;
use pocketmine\utils\TextFormat;
use function array_shift;
use function strtolower;

abstract class BaseCommand extends Command{

	/** @var SubCommand[] */
	private $subCommands = [];
	/** @var SubCommand[] */
	private $aliasSubCommands = [];

	/**
	 * BaseCommand constructor.
	 *
	 * @param string $commandName
	 * @param string $permission
	 * @param string $description
	 * @param string $usageMessage
	 * @param array  $aliases
	 */
	public function __construct(string $commandName, string $permission, string $description = "", string $usageMessage = "", array $aliases = []){
		parent::__construct($commandName, $description, $usageMessage, $aliases);

		$this->setPermission($permission);
	}

	/**
	 * @param CommandSender $sender
	 * @param string        $label
	 * @param array         $args
	 */
	public function execute(CommandSender $sender, string $label, array $args): void{
		if((!$sender instanceof ConsoleCommandSender) && !$this->testPermissionSilent($sender)){
			$this->sendError($sender, "You don't have permission to use this command.");

			return;
		}

		$this->onCommand($sender, $label, $args);
	}

	/**
	 * @param CommandSender $sender
	 * @param string        $label
	 * @param array         $args
	 */
	public abstract function onCommand(CommandSender $sender, string $label, array $args): void;

	/**
	 * @param CommandSender $sender
	 * @param string        $permission
	 * @param string|null   $customError
	 * @return bool
	 */
	public final function hasPermission(CommandSender $sender, string $permission, ?string $customError = null): bool{
		if($sender->hasPermission($permission)){
			return true;
		}

		$this->sendError($sender, $customError ?? "You don't have permission to use this command.");

		return false;
	}

	/**
	 * @return SubCommand[]
	 */
	public function getSubCommands(): array{
		return $this->subCommands;
	}

	/**
	 * @return SubCommand[]
	 */
	public function getAliasSubCommands(): array{
		return $this->aliasSubCommands;
	}

	/**
	 * @param SubCommand $command
	 */
	public function registerSubCommand(SubCommand $command): void{
		$this->subCommands[$command->getName()] = $command;

		foreach($command->getAliases() as $alias){
			if($alias !== ""){
				$this->aliasSubCommands[$alias] = $command;
			}
		}
	}

	/**
	 * @param array $args
	 * @return bool
	 */
	public function subCommandExists(array $args): bool{
		$subCommand = strtolower(array_shift($args));

		return isset($this->subCommands[$subCommand]) || isset($this->aliasSubCommands[$subCommand]);
	}

	/**
	 * @param CommandSender $sender
	 * @param array         $args
	 */
	public function executeSubCommand(CommandSender $sender, array $args): void{
		$subCommand = strtolower(array_shift($args));

		if(isset($this->subCommands[$subCommand])){
			$command = $this->subCommands[$subCommand];
		}elseif(isset($this->aliasSubCommands[$subCommand])){
			$command = $this->aliasSubCommands[$subCommand];
		}else{
			$this->sendError($sender, "Unknown command. Use /help for a list of commands.");

			return;
		}

		if($command->canUse($sender)){
			$command->execute($sender, $args);
		}else{
			$this->sendError($sender, "You don't have permission to use this command.");
		}
	}

	/**
	 * @param CommandSender $sender
	 * @param string        $error
	 */
	public function sendError(CommandSender $sender, string $error): void{
		$sender->sendMessage(Citation::getPrefix() . TextFormat::RED . $error);
	}

	/**
	 * @param CommandSender $sender
	 * @param string        $message
	 */
	public function sendMessage(CommandSender $sender, string $message): void{
		$sender->sendMessage(Citation::getPrefix() . TextFormat::GREEN . $message);
	}
}