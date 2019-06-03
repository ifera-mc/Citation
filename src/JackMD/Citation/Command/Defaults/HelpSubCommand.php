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

namespace JackMD\Citation\Command\Defaults;

use JackMD\Citation\Command\BaseCommand;
use JackMD\Citation\Command\SubCommand;
use pocketmine\command\CommandSender;
use function implode;
use function strtolower;

class HelpSubCommand extends SubCommand{

	/** @var BaseCommand */
	private $command;
	/** @var string */
	private $headerName;

	/**
	 * HelpSubCommand constructor.
	 *
	 * @param        $command
	 * @param string $headerName
	 * @param string $permission
	 * @param string $usage
	 * @param array  $aliases
	 */
	public function __construct(BaseCommand $command, string $headerName, string $permission, string $usage, array $aliases = []){
		parent::__construct("help", $permission, "Access to $headerName help page", $usage . " help [page|command]", $aliases);

		$this->command = $command;
		$this->headerName = $headerName;
	}

	/**
	 * @param CommandSender $sender
	 * @param array         $args
	 */
	public function execute(CommandSender $sender, array $args): void{
		if(empty($args)){
			$pageNumber = 1;
		}elseif(is_numeric($args[0])){
			$pageNumber = (int) array_shift($args);

			if($pageNumber <= 0){
				$pageNumber = 1;
			}
		}else{
			$this->sendCommandHelp($sender, $args);

			return;
		}

		$subCommands = $this->command->getSubCommands();

		/** @var SubCommand[] $commands */
		$commands = [];

		foreach($subCommands as $command){
			if($command->canUse($sender)){
				$commands[$command->getName()] = $command;
			}
		}

		ksort($commands, SORT_NATURAL | SORT_FLAG_CASE);

		$commands = array_chunk($commands, $sender->getScreenLineHeight());
		$pageNumber = (int) min(count($commands), $pageNumber);

		$sender->sendMessage("§6{$this->headerName} §aHelp Page §f[§c" . $pageNumber . "§f/§c" . count($commands) . "§f]");

		foreach($commands[$pageNumber - 1] as $command){
			$message = "§l§c»§r §2" . $command->getUsage() . " §l§b»§r §f" . $command->getDescription();

			if(!empty($command->getAliases())){
				$message .= " (Alias: " . implode(", ", $command->getAliases()) . ")";
			}

			$sender->sendMessage($message);
		}
	}

	/**
	 * @param CommandSender $sender
	 * @param array         $args
	 */
	public function sendCommandHelp(CommandSender $sender, array $args): void{
		$commandName = strtolower($args[0]);

		$subCommands = $this->command->getSubCommands();
		$aliasCommands = $this->command->getAliasSubCommands();

		if(isset($subCommands[$commandName])){
			$subCommand = $subCommands[$commandName];
		}elseif(isset($aliasCommands[$commandName])){
			$subCommand = $aliasCommands[$commandName];
		}else{
			$this->command->sendMessage($sender, "Unknown command. Use {$this->getUsage()} for list of available commands.");

			return;
		}

		$message = "§e--------- §6{$this->headerName} Help: §a{$subCommand->getName()} §e---------\n";
		$message .= "§6Description: §f{$subCommand->getDescription()}\n";
		$message .= "§6Usage: §f{$subCommand->getUsage()}\n";

		if(!empty($subCommand->getAliases())){
			$message .= "§6Alias: §f" . implode(", ", $subCommand->getAliases());
		}

		$sender->sendMessage($message);
	}
}