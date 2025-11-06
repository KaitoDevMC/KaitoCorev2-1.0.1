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

namespace pocketmine\tile;

use pocketmine\block\Block;
use pocketmine\inventory\EnchantInventory;
use pocketmine\inventory\FurnaceRecipe;
use pocketmine\inventory\InventoryHolder;
use pocketmine\item\Item;
use pocketmine\level\Level;
use pocketmine\nbt\NBT;
use pocketmine\nbt\tag\CompoundTag;
use pocketmine\nbt\tag\IntTag;
use pocketmine\nbt\tag\ListTag;
use pocketmine\nbt\tag\ShortTag;
use pocketmine\nbt\tag\StringTag;
use pocketmine\network\mcpe\protocol\ContainerSetDataPacket;

class EnchantTable extends Spawnable implements Nameable, InventoryHolder {
	protected $inventory;
	/**
	 * EnchantTable constructor.
	 *
	 * @param Level       $level
	 * @param CompoundTag $nbt
	 */
	public function __construct(Level $level, CompoundTag $nbt){
		parent::__construct($level, $nbt);
		$this->inventory = new EnchantInventory($this);
	}

	/**
	 * @return string
	 */
	public function getName() : string{
		return $this->hasName() ? $this->namedtag->CustomName->getValue() : "Enchanting Table";
	}

	/**
	 * @return bool
	 */
	public function hasName(){
		return isset($this->namedtag->CustomName);
	}

	/**
	 * @param void $str
	 */
	public function setName($str){
		if($str === ""){
			unset($this->namedtag->CustomName);
			return;
		}

		$this->namedtag->CustomName = new StringTag("CustomName", $str);
	}
	public function getInventory(){
		return $this->inventory;
	}

	/**
	 * @return CompoundTag
	 */
	public function getSpawnCompound(){
		$nbt = new CompoundTag("", [
			new StringTag("id", Tile::ENCHANT_TABLE),
			new IntTag("x", (int) $this->x),
			new IntTag("y", (int) $this->y),
			new IntTag("z", (int) $this->z)
		]);

		if($this->hasName()) $nbt->CustomName = $this->namedtag->CustomName;

		return $nbt;
	}
}
