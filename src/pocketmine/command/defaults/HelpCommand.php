<?php

/*
 *
 *  ____            _        _   __  __ _                  __  __ ____
 * |  _ \ ___   ___| | _____| |_|  \/  (_)_ __   ___      |  \/  |  _ \
 * | |_) / _ \ / __| |/ / _ \ __| |\/| | | '_ \ / _ \_____| |\/| | |_) |
 * |  __/ (_) | (__|   <  __/ |_| |  | | | | | |  __/_____| |  | |  __/
 * |_|   \___/ \___|_|\_\___|\__|_|  |_|_|_| |_|\___|     |_|  |_|_|
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU Lesser General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * @author PocketMine Team
 * @link http://www.pocketmine.net/
 *
 *
*/

namespace pocketmine\command\defaults;

use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\command\ConsoleCommandSender;
use pocketmine\event\TranslationContainer;
use pocketmine\utils\TextFormat;
use pocketmine\level\sound\ClickSound;

class HelpCommand extends VanillaCommand {

	/**
	 * HelpCommand constructor.
	 *
	 * @param $name
	 */
	public function __construct($name){
		parent::__construct(
			$name,
			"%pocketmine.command.help.description",
			"%pocketmine.command.help.usage",
			["?"]
		);
		$this->setPermission("pocketmine.command.help");
	}

	/**
	 * @param CommandSender $sender
	 * @param string        $currentAlias
	 * @param array         $args
	 *
	 * @return bool
	 */
	public function execute(CommandSender $sender, $currentAlias, array $args){

		$message = "§eГлавные команды сервера§8:\n §a/donate §8- §eознакомиться со списком привилегий\n §a/auc §8- §eпомощь по аукциону\n §a/sethome §8- §eустановить точку дома\n §a/delhome §8- §eудалить точку дома\n §a/home §8- §eтелепортироваться на точку дома\n §a/rg §8- §eпомощь по региону\n §a/clan §8- §eпомощь по кланам\n §a/rtp §8- §eрандомная телепортация\n §a/vrtp §8- §eтелепортация к рандомному игроку (за 20 блоков от него)\n §a/stats §8- §eузнать свою статистику\n §a/money §8- §eузнать свой баланс денежных средств\n §a/coins §8- §eузнать свой баланс коинов\n §a/kit §8- §eинформация о наборах\n\n§8[§l§cINFO§r§8] §eСообщество ВКонтакте§8: §6§l@rizeminepe§r §8| §eСайт§8: §6§lshop.rizemine.fun§r";

		$sender->sendMessage($message);
		$sender->getLevel()->addSound(new ClickSound($sender));

		return true;
	}
}