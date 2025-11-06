<?php

/*
 *
 *    _______                                _
 *   |__   __|                              | |
 *      | | ___  ___ ___  ___ _ __ __ _  ___| |_
 *      | |/ _ \/ __/ __|/ _ \  __/ _` |/ __| __|
 *      | |  __/\__ \__ \  __/ | | (_| | (__| |_
 *      |_|\___||___/___/\___|_|  \__,_|\___|\__|
 *
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU Lesser General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * @author Tesseract Team
 * @link DEAD
 * 
 *
 */

namespace pocketmine\entity;

use pocketmine\Player;
use pocketmine\Server;
use pocketmine\block\Block;
use pocketmine\level\Explosion;
use pocketmine\level\Level;
use pocketmine\math\Vector3;
use pocketmine\entity\Entity;
use pocketmine\level\Position;
use pocketmine\event\entity\EntityDamageEvent;
use pocketmine\network\mcpe\protocol\AddEntityPacket;
use pocketmine\level\Particle;
use pocketmine\level\particle\HugeExplodeParticle;

class EnderCrystal extends Entity {

	const NETWORK_ID = 71;

	public $width = 0.6;
	public $length = 0.6;
	public $height = 1.8;

	public function initEntity(){
		parent::initEntity();
		$this->setMaxHealth(2);
		$this->setHealth(2);
	}

	/**
	 * @return string
	 */
	public function getName() : string{
		return "Ender Crystal";
	}

	/**
	 * @param Player $player
	 */
	public function spawnTo(Player $player){
		$pk = new AddEntityPacket();
		$pk->eid = $this->getId();
		$pk->type = self::NETWORK_ID;
		$pk->x = $this->x;
		$pk->y = $this->y;
		$pk->z = $this->z;
		$pk->speedX = $this->motionX;
		$pk->speedY = $this->motionY;
		$pk->speedZ = $this->motionZ;
		$pk->yaw = $this->yaw;
		$pk->pitch = $this->pitch;
		$pk->metadata = $this->dataProperties;
		$player->dataPacket($pk);

		parent::spawnTo($player);
	}
	public function attack($damage, EntityDamageEvent $source){
		if(!$source->isCancelled()){
			$this->kill();
			$this->close();
			$explode = new Explosion($this->asPosition(), 4);
			$block = $this->getLevel()->getBlock($this->asVector3()->subtract(0, 1, 0));
			$this->getLevel()->setBlock($this->asVector3()->subtract(0, 1, 0), Block::get(0, 0));
			$explode->explodeA();
			$explode->explodeB();
			$this->getLevel()->setBlock($this->asVector3()->subtract(0, 1, 0), $block);
		}
	}
}