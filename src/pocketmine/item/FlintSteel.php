<?php

/*
 *
 *  ____			_		_   __  __ _				  __  __ ____  
 * |  _ \ ___   ___| | _____| |_|  \/  (_)_ __   ___	  |  \/  |  _ \ 
 * | |_) / _ \ / __| |/ / _ \ __| |\/| | | '_ \ / _ \_____| |\/| | |_) |
 * |  __/ (_) | (__|   <  __/ |_| |  | | | | | |  __/_____| |  | |  __/ 
 * |_|   \___/ \___|_|\_\___|\__|_|  |_|_|_| |_|\___|	 |_|  |_|_| 
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

namespace pocketmine\item;

use pocketmine\block\Block;
use pocketmine\block\Fire;
use pocketmine\block\Portal;
use pocketmine\block\Solid;
use pocketmine\level\Level;
use pocketmine\math\Vector3;
use pocketmine\network\mcpe\protocol\LevelSoundEventPacket;
use pocketmine\Player;

class FlintSteel extends Tool {
	/** @var Vector3 */
	private $temporalVector = null;

	/**
	 * FlintSteel constructor.
	 *
	 * @param int $meta
	 * @param int $count
	 */
	public function __construct($meta = 0, $count = 1){
		parent::__construct(self::FLINT_STEEL, $meta, $count, "Flint and Steel");
		if($this->temporalVector === null) $this->temporalVector = new Vector3(0, 0, 0);
	}

	/**
	 * @return bool
	 */
	public function canBeActivated() : bool{
		return true;
	}

	/**
	 * @param Level  $level
	 * @param Player $player
	 * @param Block  $block
	 * @param Block  $target
	 * @param        $face
	 * @param        $fx
	 * @param        $fy
	 * @param        $fz
	 *
	 * @return bool
	 */
	public function onActivate(Level $level, Player $player, Block $block, Block $target, $face, $fx, $fy, $fz){
		if($block->getId() === self::AIR and ($target instanceof Solid) and $target->getId() !== Block::OBSIDIAN){
			$level->setBlock($block, new Fire(), true);
			$player->getLevel()->broadcastLevelSoundEvent($player, LevelSoundEventPacket::SOUND_IGNITE);

			if($player->isSurvival()){
				$this->useOn($level->getBlock($block), 2);
				$player->getInventory()->setItemInHand($this);
			}

			return true;
		}
		if($target->getId() === Block::OBSIDIAN and $player->getServer()->netherEnabled){
			if($level->getBlock($target->asVector3()->add(1, 0, 0))->getId() === Block::OBSIDIAN and $level->getBlock($target->asVector3()->add(1, 4, 0))->getId() === Block::OBSIDIAN and $level->getBlock($target->asVector3()->add(0, 4, 0))->getId() === Block::OBSIDIAN and $level->getBlock($target->asVector3()->add(2, 3, 0))->getId() === Block::OBSIDIAN and $level->getBlock($target->asVector3()->add(2, 2, 0))->getId() === Block::OBSIDIAN and $level->getBlock($target->asVector3()->add(2, 1, 0))->getId() === Block::OBSIDIAN and $level->getBlock($target->asVector3()->subtract(1, 0, 0)->add(0, 1, 0))->getId() === Block::OBSIDIAN and $level->getBlock($target->asVector3()->subtract(1, 0, 0)->add(0, 2, 0))->getId() === Block::OBSIDIAN and $level->getBlock($target->asVector3()->subtract(1, 0, 0)->add(0, 3, 0))->getId() === Block::OBSIDIAN){
				$count = 0;
				for($y2 = 1; $y2 <= 3; ++$y2){
					for($x2 = 0; $x2 <= 1; ++$x2){
						if($level->getBlock(new Vector3($target->getX() + $x2, $target->getY() + $y2, $target->getZ()))->getId() === 0) ++$count;
					}
				}
				if($count !== 6) return;
				for($y2 = 1; $y2 <= 3; ++$y2){
					for($x2 = 0; $x2 <= 1; ++$x2){
						$level->setBlock(new Vector3($target->getX() + $x2, $target->getY() + $y2, $target->getZ()), Block::get(90, 0));
					}
				}
				if($level->getName() === 'world'){
					Server::getInstance()->loadLevel('nether');
					$nether = Server::getInstance()->getLevelByName('nether');
					$portalX = $target->getX() * 8;
					$portalY = $target->getY();
					$portalZ = $target->getZ() * 8;
					for($y2 = 1; $y2 <= 3; ++$y2){
						for($x2 = 0; $x2 <= 1; ++$x2){
							$nether->setBlock(new Vector3($portalX + $x2, $portalY + $y2, $portalZ), Block::get(90, 0));
						}
					}
				}elseif($level->getName() === 'nether'){
					$portalX = $target->getX() * 8;
					$portalY = $target->getY();
					$portalZ = $target->getZ() * 8;
					for($y2 = 1; $y2 <= 3; ++$y2){
						for($x2 = 0; $x2 <= 1; ++$x2){
							Server::getInstance()->getLevelByName('world')->setBlock(new Vector3($portalX + $x2, $portalY + $y2, $portalZ), Block::get(90, 0));
						}
					}
				}
			}
		}
		if($target->getId() === Block::OBSIDIAN and $player->getServer()->netherEnabled){
			if($level->getBlock($target->asVector3()->add(0, 0, 1))->getId() === Block::OBSIDIAN and $level->getBlock($target->asVector3()->add(0, 4, 1))->getId() === Block::OBSIDIAN and $level->getBlock($target->asVector3()->add(0, 4, 0))->getId() === Block::OBSIDIAN and $level->getBlock($target->asVector3()->add(0, 3, 2))->getId() === Block::OBSIDIAN and $level->getBlock($target->asVector3()->add(0, 2, 2))->getId() === Block::OBSIDIAN and $level->getBlock($target->asVector3()->add(0, 1, 2))->getId() === Block::OBSIDIAN and $level->getBlock($target->asVector3()->subtract(0, 0, 1)->add(0, 1, 0))->getId() === Block::OBSIDIAN and $level->getBlock($target->asVector3()->subtract(0, 0, 1)->add(0, 2, 0))->getId() === Block::OBSIDIAN and $level->getBlock($target->asVector3()->subtract(0, 0, 1)->add(0, 3, 0))->getId() === Block::OBSIDIAN){
				$count = 0;
				for($y2 = 1; $y2 <= 3; ++$y2){
					for($z2 = 0; $z2 <= 1; ++$z2){
						if($level->getBlock(new Vector3($target->getX(), $target->getY() + $y2, $target->getZ() + $z2))->getId() === 0) ++$count;
					}
				}
				if($count !== 6) return;
				for($y2 = 1; $y2 <= 3; ++$y2){
					for($z2 = 0; $z2 <= 1; ++$z2){
						$level->setBlock(new Vector3($target->getX(), $target->getY() + $y2, $target->getZ() + $z2), Block::get(90, 0));
					}
				}
				if($level->getName() === 'world'){
					Server::getInstance()->loadLevel('nether');
					$nether = Server::getInstance()->getLevelByName('nether');
					$portalX = $target->getX() * 8;
					$portalY = $target->getY();
					$portalZ = $target->getZ() * 8;
					for($y2 = 1; $y2 <= 3; ++$y2){
						for($x2 = 0; $x2 <= 1; ++$x2){
							$nether->setBlock(new Vector3($portalX + $x2, $portalY + $y2, $portalZ), Block::get(90, 0));
						}
					}
				}elseif($level->getName() === 'nether'){
					$portalX = $target->getX() * 8;
					$portalY = $target->getY();
					$portalZ = $target->getZ() * 8;
					for($y2 = 1; $y2 <= 3; ++$y2){
						for($x2 = 0; $x2 <= 1; ++$x2){
							Server::getInstance()->getLevelByName('world')->setBlock(new Vector3($portalX + $x2, $portalY + $y2, $portalZ), Block::get(90, 0));
						}
					}
				}
			}
		}

		return false;
	}
}
