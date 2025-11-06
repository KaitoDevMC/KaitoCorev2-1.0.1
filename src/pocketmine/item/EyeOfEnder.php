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

namespace pocketmine\item;

use pocketmine\block\Block;
use pocketmine\block\EndPortalFrame;
use pocketmine\level\Level;
use pocketmine\item\Item;
use pocketmine\block\Solid;
use pocketmine\math\Vector3;
use pocketmine\{Player, Server};
use pocketmine\inventory\Inventory;
use pocketmine\level\particle\SmokeParticle;

class EyeOfEnder extends Item{

	private $temporalVector = null;
	/**
	 * EyeOfEnder constructor.
	 *
	 * @param int $meta
	 * @param int $count
	 */
	public function __construct($meta = 0, $count = 1){
		parent::__construct(self::EYE_OF_ENDER, 0, $count, "Eye Of Ender");
		if($this->temporalVector === null){
			$this->temporalVector = new Vector3(0, 0, 0);
		}
	}

	public function canBeActivated() : bool{
		return true;
	}
	public function onActivate(Level $level, Player $player, Block $block, Block $target, $face, $fx, $fy, $fz){
		$p = $player;
        $i = $player->getInventory()->getItemInHand();
        $b = $target;
        $l = $level;
        $x = $target->getX();
        $y = $target->getY();
        $z = $target->getZ();
        if($i->getId() == 381) {
            if($b->getId() == 120 and $b->getDamage() !== 4){
                $p->getInventory()->setItemInHand(Item::get($i->getId() , $i->getDamage(), $i->getCount() - 1));
                $l->addParticle(new SmokeParticle(new Vector3($x, $y + 1, $z)));
                $p->getLevel()->setBlock(new Vector3($x, $y, $z), Block::get(120, 4));
                if($l->getBlock(new Vector3($x + 1, $y, $z))->getId() == 120 and $l->getBlock(new Vector3($x + 1, $y, $z))->getDamage() == 4 and $l->getBlock(new Vector3($x - 1, $y, $z))->getId() == 120 and $l->getBlock(new Vector3($x - 1, $y, $z))->getDamage() == 4 and $l->getBlock(new Vector3($x + 2, $y, $z + 1))->getId() == 120 and $l->getBlock(new Vector3($x + 2, $y, $z + 1))->getDamage() == 4 and $l->getBlock(new Vector3($x - 2, $y, $z + 1))->getId() == 120 and $l->getBlock(new Vector3($x - 2, $y, $z + 1))->getDamage() == 4 and $l->getBlock(new Vector3($x + 2, $y, $z + 2))->getId() == 120 and $l->getBlock(new Vector3($x + 2, $y, $z + 2))->getDamage() == 4 and $l->getBlock(new Vector3($x - 2, $y, $z + 2))->getId() == 120 and $l->getBlock(new Vector3($x - 2, $y, $z + 2))->getDamage() == 4 and $l->getBlock(new Vector3($x + 2, $y, $z + 3))->getId() == 120 and $l->getBlock(new Vector3($x + 2, $y, $z + 3))->getDamage() == 4 and $l->getBlock(new Vector3($x - 2, $y, $z + 3))->getId() == 120 and $l->getBlock(new Vector3($x - 2, $y, $z + 3))->getDamage() == 4 and $l->getBlock(new Vector3($x, $y, $z + 4))->getId() == 120 and $l->getBlock(new Vector3($x, $y, $z + 4))->getDamage() == 4  and $l->getBlock(new Vector3($x + 1, $y, $z + 4))->getId() == 120 and $l->getBlock(new Vector3($x + 1, $y, $z + 4))->getDamage() == 4 and $l->getBlock(new Vector3($x - 1, $y, $z + 4))->getId() == 120 and $l->getBlock(new Vector3($x - 1, $y, $z + 4))->getDamage() == 4) {
                    $p->getLevel()->setBlock(new Vector3($x, $y, $z + 1), Block::get(119));
                    
                    $p->getLevel()->setBlock(new Vector3($x - 1, $y, $z + 1), Block::get(119));
                    
                    $p->getLevel()->setBlock(new Vector3($x + 1, $y, $z + 1), Block::get(119));
                    
                    $p->getLevel()->setBlock(new Vector3($x, $y, $z + 2), Block::get(119));
                    
                    $p->getLevel()->setBlock(new Vector3($x - 1, $y, $z + 2), Block::get(119));
                    
                    $p->getLevel()->setBlock(new Vector3($x + 1, $y, $z + 2), Block::get(119)); 
                    
                    $p->getLevel()->setBlock(new Vector3($x, $y, $z + 3), Block::get(119));
                    
                    $p->getLevel()->setBlock(new Vector3($x - 1, $y, $z + 3), Block::get(119));
                    
                    $p->getLevel()->setBlock(new Vector3($x + 1, $y, $z + 3), Block::get(119));
                }

                if($l->getBlock(new Vector3($x - 1, $y, $z))->getId() == 120 and $l->getBlock(new Vector3($x - 1, $y, $z))->getDamage() == 4 and $l->getBlock(new Vector3($x - 2, $y, $z))->getId() == 120 and $l->getBlock(new Vector3($x - 2, $y, $z))->getDamage() == 4 and $l->getBlock(new Vector3($x - 3, $y, $z + 1))->getId() == 120 and $l->getBlock(new Vector3($x - 3, $y, $z + 1))->getDamage() == 4 and $l->getBlock(new Vector3($x + 1, $y, $z + 1))->getId() == 120 and $l->getBlock(new Vector3($x + 1, $y, $z + 1))->getDamage() == 4 and $l->getBlock(new Vector3($x - 3, $y, $z + 2))->getId() == 120 and $l->getBlock(new Vector3($x - 3, $y, $z + 2))->getDamage() == 4 and $l->getBlock(new Vector3($x + 1, $y, $z + 2))->getId() == 120 and $l->getBlock(new Vector3($x + 1, $y, $z + 2))->getDamage() == 4 and $l->getBlock(new Vector3($x - 3, $y, $z + 3))->getId() == 120 and $l->getBlock(new Vector3($x - 3, $y, $z + 3))->getDamage() == 4 and $l->getBlock(new Vector3($x + 1, $y, $z + 3))->getId() == 120 and $l->getBlock(new Vector3($x + 1, $y, $z + 3))->getDamage() == 4 and $l->getBlock(new Vector3($x, $y, $z + 4))->getId() == 120 and $l->getBlock(new Vector3($x, $y, $z + 4))->getDamage() == 4  and $l->getBlock(new Vector3($x - 2, $y, $z + 4))->getId() == 120 and $l->getBlock(new Vector3($x - 2, $y, $z + 4))->getDamage() == 4 and $l->getBlock(new Vector3($x - 1, $y, $z + 4))->getId() == 120 and $l->getBlock(new Vector3($x - 1, $y, $z + 4))->getDamage() == 4) {
                    $p->getLevel()->setBlock(new Vector3($x, $y, $z + 1), Block::get(119));
                    
                    $p->getLevel()->setBlock(new Vector3($x - 1, $y, $z + 1), Block::get(119));
                    
                    $p->getLevel()->setBlock(new Vector3($x - 2, $y, $z + 1), Block::get(119));
                    
                    $p->getLevel()->setBlock(new Vector3($x, $y, $z + 2), Block::get(119));
                    
                    $p->getLevel()->setBlock(new Vector3($x - 1, $y, $z + 2), Block::get(119));
                    
                    $p->getLevel()->setBlock(new Vector3($x - 2, $y, $z + 2), Block::get(119)); 
                    
                    $p->getLevel()->setBlock(new Vector3($x, $y, $z + 3), Block::get(119));
                    
                    $p->getLevel()->setBlock(new Vector3($x - 1, $y, $z + 3), Block::get(119));
                    
                    $p->getLevel()->setBlock(new Vector3($x - 2, $y, $z + 3), Block::get(119));
                }

                if($l->getBlock(new Vector3($x + 1, $y, $z))->getId() == 120 and $l->getBlock(new Vector3($x + 1, $y, $z))->getDamage() == 4 and $l->getBlock(new Vector3($x + 2, $y, $z))->getId() == 120 and $l->getBlock(new Vector3($x + 2, $y, $z))->getDamage() == 4 and $l->getBlock(new Vector3($x + 3, $y, $z + 1))->getId() == 120 and $l->getBlock(new Vector3($x + 3, $y, $z + 1))->getDamage() == 4 and $l->getBlock(new Vector3($x - 1, $y, $z + 1))->getId() == 120 and $l->getBlock(new Vector3($x - 1, $y, $z + 1))->getDamage() == 4 and $l->getBlock(new Vector3($x + 3, $y, $z + 2))->getId() == 120 and $l->getBlock(new Vector3($x + 3, $y, $z + 2))->getDamage() == 4 and $l->getBlock(new Vector3($x - 1, $y, $z + 2))->getId() == 120 and $l->getBlock(new Vector3($x - 1, $y, $z + 2))->getDamage() == 4 and $l->getBlock(new Vector3($x + 3, $y, $z + 3))->getId() == 120 and $l->getBlock(new Vector3($x + 3, $y, $z + 3))->getDamage() == 4 and $l->getBlock(new Vector3($x - 1, $y, $z + 3))->getId() == 120 and $l->getBlock(new Vector3($x - 1, $y, $z + 3))->getDamage() == 4 and $l->getBlock(new Vector3($x, $y, $z + 4))->getId() == 120 and $l->getBlock(new Vector3($x, $y, $z + 4))->getDamage() == 4  and $l->getBlock(new Vector3($x + 2, $y, $z + 4))->getId() == 120 and $l->getBlock(new Vector3($x + 2, $y, $z + 4))->getDamage() == 4 and $l->getBlock(new Vector3($x + 1, $y, $z + 4))->getId() == 120 and $l->getBlock(new Vector3($x + 1, $y, $z + 4))->getDamage() == 4) {
                    $p->getLevel()->setBlock(new Vector3($x, $y, $z + 1), Block::get(119));
                    
                    $p->getLevel()->setBlock(new Vector3($x + 1, $y, $z + 1), Block::get(119));
                    
                    $p->getLevel()->setBlock(new Vector3($x + 2, $y, $z + 1), Block::get(119));
                    
                    $p->getLevel()->setBlock(new Vector3($x, $y, $z + 2), Block::get(119));
                    
                    $p->getLevel()->setBlock(new Vector3($x + 1, $y, $z + 2), Block::get(119));
                    
                    $p->getLevel()->setBlock(new Vector3($x + 2, $y, $z + 2), Block::get(119)); 
                    
                    $p->getLevel()->setBlock(new Vector3($x, $y, $z + 3), Block::get(119));
                    
                    $p->getLevel()->setBlock(new Vector3($x + 1, $y, $z + 3), Block::get(119));
                    
                    $p->getLevel()->setBlock(new Vector3($x + 2, $y, $z + 3), Block::get(119));
                }
            
                if($l->getBlock(new Vector3($x, $y, $z + 1))->getId() == 120 and $l->getBlock(new Vector3($x, $y, $z + 1))->getDamage() == 4 and $l->getBlock(new Vector3($x, $y, $z - 1))->getId() == 120 and $l->getBlock(new Vector3($x, $y, $z - 1))->getDamage() == 4 and $l->getBlock(new Vector3($x + 1, $y, $z + 2))->getId() == 120 and $l->getBlock(new Vector3($x + 1, $y, $z + 2))->getDamage() == 4 and $l->getBlock(new Vector3($x + 1, $y, $z - 2))->getId() == 120 and $l->getBlock(new Vector3($x + 1, $y, $z - 2))->getDamage() == 4 and $l->getBlock(new Vector3($x + 2, $y, $z + 2))->getId() == 120 and $l->getBlock(new Vector3($x + 2, $y, $z + 2))->getDamage() == 4 and $l->getBlock(new Vector3($x + 2, $y, $z - 2))->getId() == 120 and $l->getBlock(new Vector3($x + 2, $y, $z - 2))->getDamage() == 4 and $l->getBlock(new Vector3($x + 3, $y, $z + 2))->getId() == 120 and $l->getBlock(new Vector3($x + 3, $y, $z + 2))->getDamage() == 4 and $l->getBlock(new Vector3($x + 3, $y, $z - 2))->getId() == 120 and $l->getBlock(new Vector3($x + 3, $y, $z - 2))->getDamage() == 4 and $l->getBlock(new Vector3($x + 4, $y, $z))->getId() == 120 and $l->getBlock(new Vector3($x + 4, $y, $z))->getDamage() == 4  and $l->getBlock(new Vector3($x + 4, $y, $z + 1))->getId() == 120 and $l->getBlock(new Vector3($x + 4, $y, $z + 1))->getDamage() == 4 and $l->getBlock(new Vector3($x + 4, $y, $z - 1))->getId() == 120 and $l->getBlock(new Vector3($x + 4, $y, $z - 1))->getDamage() == 4) {
                    $p->getLevel()->setBlock(new Vector3($x + 1, $y, $z), Block::get(119));
                    
                    $p->getLevel()->setBlock(new Vector3($x + 1, $y, $z - 1), Block::get(119));
                    
                    $p->getLevel()->setBlock(new Vector3($x + 1, $y, $z + 1), Block::get(119));
                    
                    $p->getLevel()->setBlock(new Vector3($x + 2, $y, $z), Block::get(119));
                    
                    $p->getLevel()->setBlock(new Vector3($x + 2, $y, $z - 1), Block::get(119));
                    
                    $p->getLevel()->setBlock(new Vector3($x + 2, $y, $z + 1), Block::get(119)); 
                    
                    $p->getLevel()->setBlock(new Vector3($x + 3, $y, $z), Block::get(119));
                    
                    $p->getLevel()->setBlock(new Vector3($x + 3, $y, $z - 1), Block::get(119));
                    
                    $p->getLevel()->setBlock(new Vector3($x + 3, $y, $z + 1), Block::get(119));
                }
            
                if($l->getBlock(new Vector3($x, $y, $z - 1))->getId() == 120 and $l->getBlock(new Vector3($x, $y, $z - 1))->getDamage() == 4 and $l->getBlock(new Vector3($x, $y, $z - 2))->getId() == 120 and $l->getBlock(new Vector3($x, $y, $z - 2))->getDamage() == 4 and $l->getBlock(new Vector3($x + 1, $y, $z - 3))->getId() == 120 and $l->getBlock(new Vector3($x + 1, $y, $z - 3))->getDamage() == 4 and $l->getBlock(new Vector3($x + 1, $y, $z + 1))->getId() == 120 and $l->getBlock(new Vector3($x + 1, $y, $z + 1))->getDamage() == 4 and $l->getBlock(new Vector3($x + 2, $y, $z - 3))->getId() == 120 and $l->getBlock(new Vector3($x + 2, $y, $z - 3))->getDamage() == 4 and $l->getBlock(new Vector3($x + 2, $y, $z + 1))->getId() == 120 and $l->getBlock(new Vector3($x + 2, $y, $z + 1))->getDamage() == 4 and $l->getBlock(new Vector3($x + 3, $y, $z - 3))->getId() == 120 and $l->getBlock(new Vector3($x + 3, $y, $z - 3))->getDamage() == 4 and $l->getBlock(new Vector3($x + 3, $y, $z + 1))->getId() == 120 and $l->getBlock(new Vector3($x + 3, $y, $z + 1))->getDamage() == 4 and $l->getBlock(new Vector3($x + 4, $y, $z))->getId() == 120 and $l->getBlock(new Vector3($x + 4, $y, $z))->getDamage() == 4  and $l->getBlock(new Vector3($x + 4, $y, $z - 2))->getId() == 120 and $l->getBlock(new Vector3($x + 4, $y, $z - 2))->getDamage() == 4 and $l->getBlock(new Vector3($x + 4, $y, $z - 1))->getId() == 120 and $l->getBlock(new Vector3($x + 4, $y, $z - 1))->getDamage() == 4) {
                    $p->getLevel()->setBlock(new Vector3($x + 1, $y, $z), Block::get(119));
                    
                    $p->getLevel()->setBlock(new Vector3($x + 1, $y, $z - 1), Block::get(119));
                    
                    $p->getLevel()->setBlock(new Vector3($x + 1, $y, $z - 2), Block::get(119));
                    
                    $p->getLevel()->setBlock(new Vector3($x + 2, $y, $z), Block::get(119));
                    
                    $p->getLevel()->setBlock(new Vector3($x + 2, $y, $z - 1), Block::get(119));
                    
                    $p->getLevel()->setBlock(new Vector3($x + 2, $y, $z - 2), Block::get(119)); 
                    
                    $p->getLevel()->setBlock(new Vector3($x + 3, $y, $z), Block::get(119));
                    
                    $p->getLevel()->setBlock(new Vector3($x + 3, $y, $z - 1), Block::get(119));
                    
                    $p->getLevel()->setBlock(new Vector3($x + 3, $y, $z - 2), Block::get(119));
                }

                if($l->getBlock(new Vector3($x, $y, $z + 1))->getId() == 120 and $l->getBlock(new Vector3($x, $y, $z + 1))->getDamage() == 4 and $l->getBlock(new Vector3($x, $y, $z + 2))->getId() == 120 and $l->getBlock(new Vector3($x, $y, $z + 2))->getDamage() == 4 and $l->getBlock(new Vector3($x + 1, $y, $z + 3))->getId() == 120 and $l->getBlock(new Vector3($x + 1, $y, $z + 3))->getDamage() == 4 and $l->getBlock(new Vector3($x + 1, $y, $z - 1))->getId() == 120 and $l->getBlock(new Vector3($x + 1, $y, $z - 1))->getDamage() == 4 and $l->getBlock(new Vector3($x + 2, $y, $z + 3))->getId() == 120 and $l->getBlock(new Vector3($x + 2, $y, $z + 3))->getDamage() == 4 and $l->getBlock(new Vector3($x + 2, $y, $z - 1))->getId() == 120 and $l->getBlock(new Vector3($x + 2, $y, $z - 1))->getDamage() == 4 and $l->getBlock(new Vector3($x + 3, $y, $z + 3))->getId() == 120 and $l->getBlock(new Vector3($x + 3, $y, $z + 3))->getDamage() == 4 and $l->getBlock(new Vector3($x + 3, $y, $z - 1))->getId() == 120 and $l->getBlock(new Vector3($x + 3, $y, $z - 1))->getDamage() == 4 and $l->getBlock(new Vector3($x + 4, $y, $z))->getId() == 120 and $l->getBlock(new Vector3($x + 4, $y, $z))->getDamage() == 4  and $l->getBlock(new Vector3($x + 4, $y, $z + 2))->getId() == 120 and $l->getBlock(new Vector3($x + 4, $y, $z + 2))->getDamage() == 4 and $l->getBlock(new Vector3($x + 4, $y, $z + 1))->getId() == 120 and $l->getBlock(new Vector3($x + 4, $y, $z + 1))->getDamage() == 4) {
                    $p->getLevel()->setBlock(new Vector3($x + 1, $y, $z), Block::get(119));
                    
                    $p->getLevel()->setBlock(new Vector3($x + 1, $y, $z + 1), Block::get(119));
                    
                    $p->getLevel()->setBlock(new Vector3($x + 1, $y, $z + 2), Block::get(119));
                    
                    $p->getLevel()->setBlock(new Vector3($x + 2, $y, $z), Block::get(119));
                    
                    $p->getLevel()->setBlock(new Vector3($x + 2, $y, $z + 1), Block::get(119));
                    
                    $p->getLevel()->setBlock(new Vector3($x + 2, $y, $z + 2), Block::get(119)); 
                    
                    $p->getLevel()->setBlock(new Vector3($x + 3, $y, $z), Block::get(119));
                    
                    $p->getLevel()->setBlock(new Vector3($x + 3, $y, $z + 1), Block::get(119));
                    
                    $p->getLevel()->setBlock(new Vector3($x + 3, $y, $z + 2), Block::get(119));
                }

                if($l->getBlock(new Vector3($x + 1, $y, $z))->getId() == 120 and $l->getBlock(new Vector3($x + 1, $y, $z))->getDamage() == 4 and $l->getBlock(new Vector3($x - 1, $y, $z))->getId() == 120 and $l->getBlock(new Vector3($x - 1, $y, $z))->getDamage() == 4 and $l->getBlock(new Vector3($x + 2, $y, $z - 1))->getId() == 120 and $l->getBlock(new Vector3($x + 2, $y, $z - 1))->getDamage() == 4 and $l->getBlock(new Vector3($x - 2, $y, $z - 1))->getId() == 120 and $l->getBlock(new Vector3($x - 2, $y, $z - 1))->getDamage() == 4 and $l->getBlock(new Vector3($x + 2, $y, $z - 2))->getId() == 120 and $l->getBlock(new Vector3($x + 2, $y, $z - 2))->getDamage() == 4 and $l->getBlock(new Vector3($x - 2, $y, $z - 2))->getId() == 120 and $l->getBlock(new Vector3($x - 2, $y, $z - 2))->getDamage() == 4 and $l->getBlock(new Vector3($x + 2, $y, $z - 3))->getId() == 120 and $l->getBlock(new Vector3($x + 2, $y, $z - 3))->getDamage() == 4 and $l->getBlock(new Vector3($x - 2, $y, $z - 3))->getId() == 120 and $l->getBlock(new Vector3($x - 2, $y, $z - 3))->getDamage() == 4 and $l->getBlock(new Vector3($x, $y, $z - 4))->getId() == 120 and $l->getBlock(new Vector3($x, $y, $z - 4))->getDamage() == 4  and $l->getBlock(new Vector3($x + 1, $y, $z - 4))->getId() == 120 and $l->getBlock(new Vector3($x + 1, $y, $z - 4))->getDamage() == 4 and $l->getBlock(new Vector3($x - 1, $y, $z - 4))->getId() == 120 and $l->getBlock(new Vector3($x - 1, $y, $z - 4))->getDamage() == 4) {
                    $p->getLevel()->setBlock(new Vector3($x, $y, $z - 1), Block::get(119));
                    
                    $p->getLevel()->setBlock(new Vector3($x - 1, $y, $z - 1), Block::get(119));
                    
                    $p->getLevel()->setBlock(new Vector3($x + 1, $y, $z - 1), Block::get(119));
                    
                    $p->getLevel()->setBlock(new Vector3($x, $y, $z - 2), Block::get(119));
                    
                    $p->getLevel()->setBlock(new Vector3($x - 1, $y, $z - 2), Block::get(119));
                    
                    $p->getLevel()->setBlock(new Vector3($x + 1, $y, $z - 2), Block::get(119)); 
                    
                    $p->getLevel()->setBlock(new Vector3($x, $y, $z - 3), Block::get(119));
                    
                    $p->getLevel()->setBlock(new Vector3($x - 1, $y, $z - 3), Block::get(119));
                    
                    $p->getLevel()->setBlock(new Vector3($x + 1, $y, $z - 3), Block::get(119));
                }

                if($l->getBlock(new Vector3($x - 1, $y, $z))->getId() == 120 and $l->getBlock(new Vector3($x - 1, $y, $z))->getDamage() == 4 and $l->getBlock(new Vector3($x - 2, $y, $z))->getId() == 120 and $l->getBlock(new Vector3($x - 2, $y, $z))->getDamage() == 4 and $l->getBlock(new Vector3($x - 3, $y, $z - 1))->getId() == 120 and $l->getBlock(new Vector3($x - 3, $y, $z - 1))->getDamage() == 4 and $l->getBlock(new Vector3($x + 1, $y, $z - 1))->getId() == 120 and $l->getBlock(new Vector3($x + 1, $y, $z - 1))->getDamage() == 4 and $l->getBlock(new Vector3($x - 3, $y, $z - 2))->getId() == 120 and $l->getBlock(new Vector3($x - 3, $y, $z - 2))->getDamage() == 4 and $l->getBlock(new Vector3($x + 1, $y, $z - 2))->getId() == 120 and $l->getBlock(new Vector3($x + 1, $y, $z - 2))->getDamage() == 4 and $l->getBlock(new Vector3($x - 3, $y, $z - 3))->getId() == 120 and $l->getBlock(new Vector3($x - 3, $y, $z - 3))->getDamage() == 4 and $l->getBlock(new Vector3($x + 1, $y, $z - 3))->getId() == 120 and $l->getBlock(new Vector3($x + 1, $y, $z - 3))->getDamage() == 4 and $l->getBlock(new Vector3($x, $y, $z - 4))->getId() == 120 and $l->getBlock(new Vector3($x, $y, $z - 4))->getDamage() == 4  and $l->getBlock(new Vector3($x - 2, $y, $z - 4))->getId() == 120 and $l->getBlock(new Vector3($x - 2, $y, $z - 4))->getDamage() == 4 and $l->getBlock(new Vector3($x - 1, $y, $z - 4))->getId() == 120 and $l->getBlock(new Vector3($x - 1, $y, $z - 4))->getDamage() == 4) {
                    $p->getLevel()->setBlock(new Vector3($x, $y, $z - 1), Block::get(119));
                    
                    $p->getLevel()->setBlock(new Vector3($x - 1, $y, $z - 1), Block::get(119));
                    
                    $p->getLevel()->setBlock(new Vector3($x - 2, $y, $z - 1), Block::get(119));
                    
                    $p->getLevel()->setBlock(new Vector3($x, $y, $z - 2), Block::get(119));
                    
                    $p->getLevel()->setBlock(new Vector3($x - 1, $y, $z - 2), Block::get(119));
                    
                    $p->getLevel()->setBlock(new Vector3($x - 2, $y, $z - 2), Block::get(119)); 
                    
                    $p->getLevel()->setBlock(new Vector3($x, $y, $z - 3), Block::get(119));
                    
                    $p->getLevel()->setBlock(new Vector3($x - 1, $y, $z - 3), Block::get(119));
                    
                    $p->getLevel()->setBlock(new Vector3($x - 2, $y, $z - 3), Block::get(119));
                }

                if($l->getBlock(new Vector3($x + 1, $y, $z))->getId() == 120 and $l->getBlock(new Vector3($x + 1, $y, $z))->getDamage() == 4 and $l->getBlock(new Vector3($x + 2, $y, $z))->getId() == 120 and $l->getBlock(new Vector3($x + 2, $y, $z))->getDamage() == 4 and $l->getBlock(new Vector3($x + 3, $y, $z - 1))->getId() == 120 and $l->getBlock(new Vector3($x + 3, $y, $z - 1))->getDamage() == 4 and $l->getBlock(new Vector3($x - 1, $y, $z - 1))->getId() == 120 and $l->getBlock(new Vector3($x - 1, $y, $z - 1))->getDamage() == 4 and $l->getBlock(new Vector3($x + 3, $y, $z - 2))->getId() == 120 and $l->getBlock(new Vector3($x + 3, $y, $z - 2))->getDamage() == 4 and $l->getBlock(new Vector3($x - 1, $y, $z - 2))->getId() == 120 and $l->getBlock(new Vector3($x - 1, $y, $z - 2))->getDamage() == 4 and $l->getBlock(new Vector3($x + 3, $y, $z - 3))->getId() == 120 and $l->getBlock(new Vector3($x + 3, $y, $z - 3))->getDamage() == 4 and $l->getBlock(new Vector3($x - 1, $y, $z - 3))->getId() == 120 and $l->getBlock(new Vector3($x - 1, $y, $z - 3))->getDamage() == 4 and $l->getBlock(new Vector3($x, $y, $z - 4))->getId() == 120 and $l->getBlock(new Vector3($x, $y, $z - 4))->getDamage() == 4  and $l->getBlock(new Vector3($x + 2, $y, $z - 4))->getId() == 120 and $l->getBlock(new Vector3($x + 2, $y, $z - 4))->getDamage() == 4 and $l->getBlock(new Vector3($x + 1, $y, $z - 4))->getId() == 120 and $l->getBlock(new Vector3($x + 1, $y, $z - 4))->getDamage() == 4) {
                    $p->getLevel()->setBlock(new Vector3($x, $y, $z - 1), Block::get(119));
                    
                    $p->getLevel()->setBlock(new Vector3($x + 1, $y, $z - 1), Block::get(119));
                    
                    $p->getLevel()->setBlock(new Vector3($x + 2, $y, $z - 1), Block::get(119));
                    
                    $p->getLevel()->setBlock(new Vector3($x, $y, $z - 2), Block::get(119));
                    
                    $p->getLevel()->setBlock(new Vector3($x + 1, $y, $z - 2), Block::get(119));
                    
                    $p->getLevel()->setBlock(new Vector3($x + 2, $y, $z - 2), Block::get(119)); 
                    
                    $p->getLevel()->setBlock(new Vector3($x, $y, $z - 3), Block::get(119));
                    
                    $p->getLevel()->setBlock(new Vector3($x + 1, $y, $z - 3), Block::get(119));
                    
                    $p->getLevel()->setBlock(new Vector3($x + 2, $y, $z - 3), Block::get(119));
                }
                
                if($l->getBlock(new Vector3($x, $y, $z + 1))->getId() == 120 and $l->getBlock(new Vector3($x, $y, $z + 1))->getDamage() == 4 and $l->getBlock(new Vector3($x, $y, $z - 1))->getId() == 120 and $l->getBlock(new Vector3($x, $y, $z - 1))->getDamage() == 4 and $l->getBlock(new Vector3($x - 1, $y, $z + 2))->getId() == 120 and $l->getBlock(new Vector3($x - 1, $y, $z + 2))->getDamage() == 4 and $l->getBlock(new Vector3($x - 1, $y, $z - 2))->getId() == 120 and $l->getBlock(new Vector3($x - 1, $y, $z - 2))->getDamage() == 4 and $l->getBlock(new Vector3($x - 2, $y, $z + 2))->getId() == 120 and $l->getBlock(new Vector3($x - 2, $y, $z + 2))->getDamage() == 4 and $l->getBlock(new Vector3($x - 2, $y, $z - 2))->getId() == 120 and $l->getBlock(new Vector3($x - 2, $y, $z - 2))->getDamage() == 4 and $l->getBlock(new Vector3($x - 3, $y, $z + 2))->getId() == 120 and $l->getBlock(new Vector3($x - 3, $y, $z + 2))->getDamage() == 4 and $l->getBlock(new Vector3($x - 3, $y, $z - 2))->getId() == 120 and $l->getBlock(new Vector3($x - 3, $y, $z - 2))->getDamage() == 4 and $l->getBlock(new Vector3($x - 4, $y, $z))->getId() == 120 and $l->getBlock(new Vector3($x - 4, $y, $z))->getDamage() == 4  and $l->getBlock(new Vector3($x - 4, $y, $z + 1))->getId() == 120 and $l->getBlock(new Vector3($x - 4, $y, $z + 1))->getDamage() == 4 and $l->getBlock(new Vector3($x - 4, $y, $z - 1))->getId() == 120 and $l->getBlock(new Vector3($x - 4, $y, $z - 1))->getDamage() == 4) {
                    $p->getLevel()->setBlock(new Vector3($x - 1, $y, $z), Block::get(119));
                    
                    $p->getLevel()->setBlock(new Vector3($x - 1, $y, $z - 1), Block::get(119));
                    
                    $p->getLevel()->setBlock(new Vector3($x - 1, $y, $z + 1), Block::get(119));
                    
                    $p->getLevel()->setBlock(new Vector3($x - 2, $y, $z), Block::get(119));
                    
                    $p->getLevel()->setBlock(new Vector3($x - 2, $y, $z - 1), Block::get(119));
                    
                    $p->getLevel()->setBlock(new Vector3($x - 2, $y, $z + 1), Block::get(119)); 
                    
                    $p->getLevel()->setBlock(new Vector3($x - 3, $y, $z), Block::get(119));
                    
                    $p->getLevel()->setBlock(new Vector3($x - 3, $y, $z - 1), Block::get(119));
                    
                    $p->getLevel()->setBlock(new Vector3($x - 3, $y, $z + 1), Block::get(119));
                }
            
                if($l->getBlock(new Vector3($x, $y, $z - 1))->getId() == 120 and $l->getBlock(new Vector3($x, $y, $z - 1))->getDamage() == 4 and $l->getBlock(new Vector3($x, $y, $z - 2))->getId() == 120 and $l->getBlock(new Vector3($x, $y, $z - 2))->getDamage() == 4 and $l->getBlock(new Vector3($x - 1, $y, $z - 3))->getId() == 120 and $l->getBlock(new Vector3($x - 1, $y, $z - 3))->getDamage() == 4 and $l->getBlock(new Vector3($x - 1, $y, $z + 1))->getId() == 120 and $l->getBlock(new Vector3($x - 1, $y, $z + 1))->getDamage() == 4 and $l->getBlock(new Vector3($x - 2, $y, $z - 3))->getId() == 120 and $l->getBlock(new Vector3($x - 2, $y, $z - 3))->getDamage() == 4 and $l->getBlock(new Vector3($x - 2, $y, $z + 1))->getId() == 120 and $l->getBlock(new Vector3($x - 2, $y, $z + 1))->getDamage() == 4 and $l->getBlock(new Vector3($x - 3, $y, $z - 3))->getId() == 120 and $l->getBlock(new Vector3($x - 3, $y, $z - 3))->getDamage() == 4 and $l->getBlock(new Vector3($x - 3, $y, $z + 1))->getId() == 120 and $l->getBlock(new Vector3($x - 3, $y, $z + 1))->getDamage() == 4 and $l->getBlock(new Vector3($x - 4, $y, $z))->getId() == 120 and $l->getBlock(new Vector3($x - 4, $y, $z))->getDamage() == 4  and $l->getBlock(new Vector3($x - 4, $y, $z - 2))->getId() == 120 and $l->getBlock(new Vector3($x - 4, $y, $z - 2))->getDamage() == 4 and $l->getBlock(new Vector3($x - 4, $y, $z - 1))->getId() == 120 and $l->getBlock(new Vector3($x - 4, $y, $z - 1))->getDamage() == 4) {
                    $p->getLevel()->setBlock(new Vector3($x - 1, $y, $z), Block::get(119));
                    
                    $p->getLevel()->setBlock(new Vector3($x - 1, $y, $z - 1), Block::get(119));
                    
                    $p->getLevel()->setBlock(new Vector3($x - 1, $y, $z - 2), Block::get(119));
                    
                    $p->getLevel()->setBlock(new Vector3($x - 2, $y, $z), Block::get(119));
                    
                    $p->getLevel()->setBlock(new Vector3($x - 2, $y, $z - 1), Block::get(119));
                    
                    $p->getLevel()->setBlock(new Vector3($x - 2, $y, $z - 2), Block::get(119)); 
                    
                    $p->getLevel()->setBlock(new Vector3($x - 3, $y, $z), Block::get(119));
                    
                    $p->getLevel()->setBlock(new Vector3($x - 3, $y, $z - 1), Block::get(119));
                    
                    $p->getLevel()->setBlock(new Vector3($x - 3, $y, $z - 2), Block::get(119));
                }

                if($l->getBlock(new Vector3($x, $y, $z + 1))->getId() == 120 and $l->getBlock(new Vector3($x, $y, $z + 1))->getDamage() == 4 and $l->getBlock(new Vector3($x, $y, $z + 2))->getId() == 120 and $l->getBlock(new Vector3($x, $y, $z + 2))->getDamage() == 4 and $l->getBlock(new Vector3($x - 1, $y, $z + 3))->getId() == 120 and $l->getBlock(new Vector3($x - 1, $y, $z + 3))->getDamage() == 4 and $l->getBlock(new Vector3($x - 1, $y, $z - 1))->getId() == 120 and $l->getBlock(new Vector3($x - 1, $y, $z - 1))->getDamage() == 4 and $l->getBlock(new Vector3($x - 2, $y, $z + 3))->getId() == 120 and $l->getBlock(new Vector3($x - 2, $y, $z + 3))->getDamage() == 4 and $l->getBlock(new Vector3($x - 2, $y, $z - 1))->getId() == 120 and $l->getBlock(new Vector3($x - 2, $y, $z - 1))->getDamage() == 4 and $l->getBlock(new Vector3($x - 3, $y, $z + 3))->getId() == 120 and $l->getBlock(new Vector3($x - 3, $y, $z + 3))->getDamage() == 4 and $l->getBlock(new Vector3($x - 3, $y, $z - 1))->getId() == 120 and $l->getBlock(new Vector3($x - 3, $y, $z - 1))->getDamage() == 4 and $l->getBlock(new Vector3($x - 4, $y, $z))->getId() == 120 and $l->getBlock(new Vector3($x - 4, $y, $z))->getDamage() == 4  and $l->getBlock(new Vector3($x - 4, $y, $z + 2))->getId() == 120 and $l->getBlock(new Vector3($x - 4, $y, $z + 2))->getDamage() == 4 and $l->getBlock(new Vector3($x - 4, $y, $z + 1))->getId() == 120 and $l->getBlock(new Vector3($x - 4, $y, $z + 1))->getDamage() == 4) {
                    $p->getLevel()->setBlock(new Vector3($x - 1, $y, $z), Block::get(119));
                    
                    $p->getLevel()->setBlock(new Vector3($x - 1, $y, $z + 1), Block::get(119));
                    
                    $p->getLevel()->setBlock(new Vector3($x - 1, $y, $z + 2), Block::get(119));
                    
                    $p->getLevel()->setBlock(new Vector3($x - 2, $y, $z), Block::get(119));
                    
                    $p->getLevel()->setBlock(new Vector3($x - 2, $y, $z + 1), Block::get(119));
                    
                    $p->getLevel()->setBlock(new Vector3($x - 2, $y, $z + 2), Block::get(119)); 
                    
                    $p->getLevel()->setBlock(new Vector3($x - 3, $y, $z), Block::get(119));
                    
                    $p->getLevel()->setBlock(new Vector3($x - 3, $y, $z + 1), Block::get(119));
                    
                    $p->getLevel()->setBlock(new Vector3($x - 3, $y, $z + 2), Block::get(119));
                }
            }
        }
	}
}