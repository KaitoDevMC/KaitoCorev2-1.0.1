<?php

/*
 * _      _ _        _____               
 *| |    (_) |      / ____|              
 *| |     _| |_ ___| |     ___  _ __ ___ 
 *| |    | | __/ _ \ |    / _ \| '__/ _ \
 *| |____| | ||  __/ |___| (_) | | |  __/
 *|______|_|\__\___|\_____\___/|_|  \___|
 *
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU Lesser General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * @author genisyspromcpe
 * @link https://github.com/genisyspromcpe/LiteCore
 *
*/

namespace pocketmine\entity;

use pocketmine\event\player\PlayerFishEvent;
use pocketmine\item\Item as ItemItem;
use pocketmine\level\Level;
use pocketmine\nbt\tag\CompoundTag;
use pocketmine\network\mcpe\protocol\AddEntityPacket;
use pocketmine\network\mcpe\protocol\EntityEventPacket;
use pocketmine\Player;
use pocketmine\inventory\Inventory;
use pocketmine\item\enchantment\Enchantment;
use pocketmine\math\Vector3;


class FishingHook extends Projectile {
	const NETWORK_ID = 77;

	public $width = 0.25;
	public $length = 0.25;
	public $height = 0.25;

	protected $gravity = 0.1;
	protected $drag = 0.05;

	public $data = 0;
	public $attractTimer = 100;
	public $coughtTimer = 0;
	public $damageRod = false;

	public function initEntity(){
		parent::initEntity();

		if(isset($this->namedtag->Data)) $this->data = $this->namedtag["Data"];
	}

	/**
	 * FishingHook constructor.
	 *
	 * @param Level       $level
	 * @param CompoundTag $nbt
	 * @param Entity|null $shootingEntity
	 */
	public function __construct(Level $level, CompoundTag $nbt, Entity $shootingEntity = null){
		parent::__construct($level, $nbt, $shootingEntity);
	}

	/**
	 * @param $id
	 */
	public function setData($id){
		$this->data = $id;
	}

	/**
	 * @return int
	 */
	public function getData(){
		return $this->data;
	}

	/**
	 * @param $currentTick
	 *
	 * @return bool
	 */
	public function onUpdate($currentTick){
		if($this->closed) return false;

		$this->timings->startTiming();

		$hasUpdate = parent::onUpdate($currentTick);
        if($this->isInsideOfWater()){
		    if($this->isCollidedVertically && $this->isInsideOfWater()){
			    $this->motionX = 0;
			    $this->motionY += 0.01;
			    $this->motionZ = 0;
			    $this->motionChanged = true;
			    $hasUpdate = true;
		    }elseif($this->isCollided && $this->keepMovement === true){
			    $this->motionX = 0;
			    $this->motionY = 0;
			    $this->motionZ = 0;
			    $this->motionChanged = true;
			    $this->keepMovement = false;
			    $hasUpdate = true;
		    }
		    if($this->attractTimer === 0 && mt_rand(0, 100) <= 60){ // chance, that a fish bites
			    $this->coughtTimer = mt_rand(5, 10) * 20; // random delay to catch fish
			    $this->attractTimer = 10 * 20; // reset timer
			    $this->attractFish();
			    if(!$this->getOwningEntity() instanceof Player) return;
			    $p = $this->getOwningEntity();
			    if($p->getItemInHand()->getId() !== 346) return;
			    $ihand = $p->getItemInHand();
			    if($ihand->getDamage() >= 380) return $p->getInventory()->setItemInHand(ItemItem::get(0, 0, 0));
			    if($ihand->hasEnchantment(23)){
			    	switch($ihand->getEnchantment(23)->getLevel()){
			    		case 1: 
			    			$fishes = [ItemItem::RAW_FISH, ItemItem::GLASS_BOTTLE, ItemItem::POISONOUS_POTATO]; 
			    		break;
			    		case 2: 
			    			$fishes = [ItemItem::RAW_FISH, ItemItem::RAW_SALMON, ItemItem::CLOWN_FISH, ItemItem::PUFFER_FISH, ItemItem::BONE, ItemItem::GLASS_BOTTLE]; 
			    		break;
			    		case 3: 
			    			$fishes = [ItemItem::RAW_FISH, ItemItem::RAW_SALMON, ItemItem::CLOWN_FISH, ItemItem::PUFFER_FISH, ItemItem::BONE, ItemItem::ROTTEN_FLESH, ItemItem::ARROW, ItemItem::SUGAR, ItemItem::GLASS_BOTTLE, ItemItem::POTION, ItemItem::NETHER_WART, ItemItem::SOUL_SAND]; 
			    		break;
			    	}
			    }else $fishes = [ItemItem::RAW_FISH];
			    $fish = array_rand($fishes, 1);
			    if(mt_rand(1, 100) < 3){
			    	$item2 = ItemItem::get(346, 0, 1);
			    	$item2->addEnchantment(Enchantment::getEnchantment(23)->setLevel(mt_rand(1, 2)));;
			    	$item2->setDamage(mt_rand(280, 340));
			    	$p->getInventory()->addItem($item2);
			    }
			    if(mt_rand(1, 100) < 2){
			    	$item2 = ItemItem::get(mt_rand(310, 313));
			    	$item2->addEnchantment(Enchantment::getEnchantment(0)->setLevel(mt_rand(1, 4)));;
			    	$item2->setDamage(mt_rand(200, 340));
			    	$p->getInventory()->addItem($item2);
			    }
			    $item = ItemItem::get($fishes[$fish]);
			    $this->getLevel()->getServer()->getPluginManager()->callEvent($ev = new PlayerFishEvent($p, $item, $this));
			    if(!$ev->isCancelled()){
					$p->addXp(mt_rand(1, 4));
			    	$ihand->setDamage($ihand->getDamage() + 2);
			    	$p->getInventory()->setItemInHand($ihand);
					$p->getInventory()->addItem($item);
			    }
			    $p->unlinkHookFromPlayer();
		    }elseif($this->attractTimer > 0) --$this->attractTimer;
		    if($this->coughtTimer > 0){
			    --$this->coughtTimer;
			    $this->fishBites();
		    }
		}
		$this->timings->stopTiming();

		return $hasUpdate;
	}

	public function fishBites(){
		if($this->getOwningEntity() instanceof Player){
			$pk = new EntityEventPacket();
			$pk->eid = $this->getOwningEntity()->getId();//$this or $p
			$pk->event = EntityEventPacket::FISH_HOOK_HOOK;
			$this->server->broadcastPacket($this->getOwningEntity()->hasSpawned, $pk);
		}
	}

	public function attractFish(){
		if($this->getOwningEntity() instanceof Player){
			$pk = new EntityEventPacket();
			$pk->eid = $this->getOwningEntity()->getId();//$this or $p
			$pk->event = EntityEventPacket::FISH_HOOK_BUBBLE;
			$this->server->broadcastPacket($this->getOwningEntity()->hasSpawned, $pk);
		}
	}

	/**
	 * @param Player $player
	 */
	public function spawnTo(Player $player){
		$pk = new AddEntityPacket();
		$pk->eid = $this->getId();
		$pk->type = FishingHook::NETWORK_ID;
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
}
