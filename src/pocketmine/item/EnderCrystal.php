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

use pocketmine\level\Level;
use pocketmine\item\Item;
use pocketmine\math\Vector3;
use pocketmine\block\Block;
use pocketmine\{Player, Server};
use pocketmine\nbt\tag\{CompoundTag, StringTag, ShortTag, ListTag, LongTag, ByteTag, IntTag, DoubleTag, FloatTag, Enum};
use pocketmine\entity\{Entity};
use pocketmine\entity\EnderCrystal as Crystal;

class EnderCrystal extends Item{

	private $temporalVector = null;
	/**
	 * EyeOfEnder constructor.
	 *
	 * @param int $meta
	 * @param int $count
	 */
	public function __construct($meta = 0, $count = 1){
		parent::__construct(self::ENDER_CRYSTAL, 0, $count, "Ender Crystal");
		if($this->temporalVector === null) $this->temporalVector = new Vector3(0, 0, 0);
	}
}