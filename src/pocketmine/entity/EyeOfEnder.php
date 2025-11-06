<?php

/* @author vk.com/sanekmelkov and vk.com/kirillmineproyt

█   ▀ ▀█▀ █▀▀ █▀▀ █▀█ █▀█ █▀▀   ▄▄   █ █ ▄▀▄ █▄ █ ▀ █   █   ▄▀▄
█▄▄ █  █  ██▄ █▄▄ █▄█ █▀▄ ██▄        ▀▄▀ █▀█ █ ▀█ █ █▄▄ █▄▄ █▀█
 *
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU Lesser General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * @author vk.com/sanekmelkov and vk.com/kirillmineproyt
 *
 *
*/

namespace pocketmine\entity;

use pocketmine\event\entity\EntityDamageEvent;
use pocketmine\event\entity\EntityDamageByEntityEvent;
use pocketmine\level\Level;
use pocketmine\entity\Entity;
use pocketmine\math\Vector3;
use pocketmine\item\Item;
use pocketmine\level\sound\EndermanTeleportSound;
use pocketmine\nbt\tag\CompoundTag;
use pocketmine\network\mcpe\protocol\AddEntityPacket;
use pocketmine\Player;

class EyeOfEnder extends Entity {

	const NETWORK_ID = 70;

	public $width = 0.25;
	public $length = 0.25;
	public $height = 0.25;

	protected $gravity = 0.03;
	protected $drag = 0.01;

	private $hasTeleportedShooter = false;
	public $hadCollision = false;

	/**
	 * EyeOfEnder constructor.
	 *
	 * @param Level       $level
	 * @param CompoundTag $nbt
	 * @param Entity|null $shootingEntity
	 */
	public function __construct(Level $level, CompoundTag $nbt, Entity $shootingEntity = null){
		parent::__construct($level, $nbt, $shootingEntity);
	}

	public function finish(){
		if(mt_rand(1, 3) !== 1) $this->getLevel()->dropItem(new Vector3($this->x, $this->y, $this->z), Item::get(Item::EYE_OF_ENDER, 0, 1));
		$this->kill();
		$this->close();
	}

	/**
	 * @param $currentTick
	 *
	 * @return bool
	 */

	/**
	 * @param Player $player
	 */
	public function spawnTo(Player $player){
		$pk = new AddEntityPacket();
		$pk->type = EyeOfEnder::NETWORK_ID;
		$pk->eid = $this->getId();
		$pk->x = $this->x;
		$pk->y = $this->y;
		$pk->z = $this->z;
		$pk->speedX = $this->motionX;
		$pk->speedY = $this->motionY;
		$pk->speedZ = $this->motionZ;
		$pk->metadata = $this->dataProperties;
		$player->dataPacket($pk);
		parent::spawnTo($player);
	}

}
