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

use pocketmine\inventory\Inventory;
use pocketmine\item\Item;

interface Container{

	/**
	 * @param int $index
	 *
	 * @return Item
	 */
	public function getItem($index);

	/**
	 * @param int  $index
	 * @param Item $item
	 */
	public function setItem($index, Item $item);

	/**
	 * @return int
	 */
	public function getSize();

	/**
	 * @return Inventory
	 */
	public function getInventory();
}
