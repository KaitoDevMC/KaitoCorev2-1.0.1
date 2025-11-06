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


use pocketmine\event\entity\EntityDamageByEntityEvent;
use pocketmine\event\entity\EntityDamageEvent;
use pocketmine\item\enchantment\Enchantment;
use pocketmine\item\Item as ItemItem;
use pocketmine\network\mcpe\protocol\AddEntityPacket;
use pocketmine\network\mcpe\protocol\EntityEventPacket;
use pocketmine\Player;
use pocketmine\math\Vector3;
use pocketmine\level\Level;

class Enderman extends Monster {
	const NETWORK_ID = 38;

	public $width = 0.3;
	public $length = 0.9;
	public $height = 1.8;

	public $dropExp = [5, 5];

	public $drag = 0.2;
	public $gravity = 0.3;
	
	private $step = 0.2;
	private $motionVector = null;
	private $farest = null;
	private $attackTicks = 0;

	/**
	 * @return string
	 */
	public function getName() : string{
		return "Enderman";
	}

	public function initEntity(){
		$this->setMaxHealth(40);
		parent::initEntity();
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
		$pk->eid = $this->getId();
		$pk->type = Enderman::NETWORK_ID;
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

	/**
	 * @return array
	 */
	public function getDrops(){
		$cause = $this->lastDamageCause;
		if($cause instanceof EntityDamageByEntityEvent){
			$damager = $cause->getDamager();
			if($damager instanceof Player){
				$lootingL = $damager->getItemInHand()->getEnchantmentLevel(Enchantment::TYPE_WEAPON_LOOTING);
				$drops = [ItemItem::get(ItemItem::ENDER_PEARL, 0, mt_rand(0, 1 + $lootingL))];

				return $drops;
			}
		}
		return [];
	}
	
	public function onUpdate($currentTick){
		if($this->isClosed() or !$this->isAlive()){
			return parent::onUpdate($currentTick);
		}
		if(mt_rand(1, 40) == 40){
		$consumer = $this;
      	$level = $consumer->getLevel();
		assert($level !== null);

		$minX = $consumer->getFloorX() - 8;
		$minY = min($consumer->getFloorY(), $level->getHighestBlockAt($consumer->getX(), $consumer->getZ())) - 8;
		$minZ = $consumer->getFloorZ() - 8;

		$maxX = $minX + 16;
		$maxY = $minY + 16;
		$maxZ = $minZ + 16;

		for($attempts = 0; $attempts < 16; ++$attempts){
			$x = mt_rand($minX, $maxX);
			$y = mt_rand($minY, $maxY);
			$z = mt_rand($minZ, $maxZ);

			while($y >= 0 and !$level->getBlockAt($x, $y, $z)->isSolid()){
				$y--;
			}
			if($y < 0){
				continue;
			}

			$blockUp = $level->getBlockAt($x, $y + 1, $z);
			$block = $level->getBlockAt($x, $y, $z);
			$blockUp2 = $level->getBlockAt($x, $y + 2, $z);
			if($blockUp->isSolid() or $blockUp2->isSolid()){
				continue;
			}

			//Sounds are broadcasted at both source and destination
			$consumer->teleport(new Vector3($x + 0.5, $y + 1, $z + 0.5));
		}
		}
		if($this->isMorph){
			return true;
		}

		$this->timings->startTiming();

		$hasUpdate = parent::onUpdate($currentTick);
        if ($this->getLevel() !== null) {
            $block = $this->getLevel()->getBlock(new Vector3(floor($this->x), floor($this->y) - 1, floor($this->z)));
        }else{
            return false;
        }
		
		
		if($this->attackTicks > 0){
			$this->attackTicks--;
		}
		
		$x = 0;
		$y = 0;
		$z = 0;
		
		if($this->isOnGround()){
			if($this->fallDistance > 0){
				$this->updateFallState($this->fallDistance, true);
			}else{
				if($this->willMove()){
					foreach($this->getViewers() as $viewer){
						if(($viewer instanceof Player)and($viewer->isSurvival())and($this->distance($viewer) < 16)){
							if($this->farest == null){
								$this->farest = $viewer;
							}
							
							if($this->farest != $viewer){
								if($this->distance($viewer) < $this->distance($this->farest)){
									$this->farest = $viewer;
								}
							}
						}
					}
					
					if($this->farest != null){
						if(($this->farest instanceof Player)and($this->farest->isSurvival())and($this->distance($this->farest) < 16)){
							$this->motionVector = $this->farest->asVector3();
						}else{
							$this->farest = null;
							$this->motionVector = null;
						}
					}
					
					if($this->farest != null){
						if($this->distance($this->farest) < 2){
							if($this->attackTicks == 0){
								$damage = 5;
								$ev = new EntityDamageByEntityEvent($this, $this->farest, EntityDamageEvent::CAUSE_ENTITY_ATTACK, $damage);
								if($this->farest->attack($damage, $ev) == true){
									$ev->useArmors();
								}
								$this->attackTicks = 20;
							}
						}
					}
					
					if(($this->motionVector == null)or($this->distance($this->motionVector) < $this->step)){
						$rx = mt_rand(-5, 5);
						$rz = mt_rand(-5, 5);
						$this->motionVector = new Vector3($this->x + $rx, $this->y, $this->z + $rz);
					}else{
						$this->motionVector->y = $this->y;
						if(($this->motionVector->x - $this->x) > $this->step){
							$x = $this->step;
						}elseif(($this->motionVector->x - $this->x) < -$this->step){
							$x = -$this->step;
						}
						if(($this->motionVector->z - $this->z) > $this->step){
							$z = $this->step;
						}elseif(($this->motionVector->z - $this->z) < -$this->step){
							$z = -$this->step;
						}
						
						$bx = floor($this->x);
						$by = floor($this->y);
						$bz = floor($this->z);
						if($x > 0){
							$bx++;
						}elseif($x < 0){
							$bx--;
						}
						if($y > 0){
							$by++;
						}elseif($y < 0){
							$by--;
						}
						if($z > 0){
							$bz++;
						}elseif($z < 0){
							$bz--;
						}
						$block1 = new Vector3($bx, $by, $bz);
						$block2 = new Vector3($bx, $by + 1, $bz);
						if(($this->isInsideOfWater())or($this->level->isFullBlock($block1) && !$this->level->isFullBlock($block2))){
							if($x > 0){
								$x = $x + 0.05;
							}elseif($x < 0){
								$x = $x - 0.05;
							}
							if($z > 0){
								$z = $z + 0.05;
							}elseif($z < 0){
								$z = $z - 0.05;
							}
							$this->move(0, 1.5, 0);
						}elseif($this->level->isFullBlock($block1) && $this->level->isFullBlock($block2)){
							$this->motionVector = null;
						}
						
						$this->yaw = $this->getMyYaw($x, $z);
						$nextPos = new Vector3($this->x + $x, $this->y, $this->z + $z);
						$latestPos = new Vector3($this->x, $this->y, $this->z);
						$this->pitch = $this->getMyPitch($latestPos, $nextPos);
					}
				}
			}
		}
		
		if((($x != 0)or($y != 0)or($z != 0))and($this->motionVector != null)){
			$this->setMotion(new Vector3($x, $y, $z));
		}
		
		$this->timings->stopTiming();

		return $hasUpdate;
	}
	
	public function hasHeadBlock($height = 50): bool{
		$x = floor($this->getX());
		$y = floor($this->getY()) + 2;
		$z = floor($this->getZ());
		$m = false;
		for($i=$y; $i < $y + $height; $i++){
			$block = $this->getLevel()->getBlock(new Vector3($x, $i, $z));
			if($block->getId() != 0){
				$m = true;
			}
		}
		return $m;
	}
	
}
