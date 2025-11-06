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

namespace pocketmine\block;

use pocketmine\block\Block;
use pocketmine\level\Level;
use pocketmine\item\Item;
use pocketmine\item\Tool;
use pocketmine\level\Position;
use pocketmine\math\Vector3;
use pocketmine\entity\Entity;
use pocketmine\Server;
use pocketmine\Player;

class EndPortal extends Solid {

	protected $id = self::END_PORTAL;

	private $temporalVector = null;
	/**
	 * EndPortal constructor.
	 *
	 * @param int $meta
	 */
	public function __construct($meta = 0){
		$this->meta = $meta;
		if($this->temporalVector === null){
			$this->temporalVector = new Vector3(0, 0, 0);
		}
	}

	/**
	 * @return int
	 */

	/**
	 * @return string
	 */
	public function getName() : string{
		return "End Portal";
	}

	/**
	 * @return int
	 */
	public function getHardness(){
		return -1;
	}

	/**
	 * @return int
	 */
	public function getResistance(){
		return 18000000;
	}

	/**
	 * @param Item $item
	 *
	 * @return bool
	 */
	public function isBreakable(Item $item){
		return false;
	}
	public function canPassThrough(){
		return true;
	}
}