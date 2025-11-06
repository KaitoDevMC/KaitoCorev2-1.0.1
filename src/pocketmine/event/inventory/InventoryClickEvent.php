<?php

/* @author vk.com/sanekmelkov

██╗░░░░░██╗████████╗███████╗░█████╗░░█████╗░██████╗░███████╗
██║░░░░░██║╚══██╔══╝██╔════╝██╔══██╗██╔══██╗██╔══██╗██╔════╝
██║░░░░░██║░░░██║░░░█████╗░░██║░░╚═╝██║░░██║██████╔╝█████╗░░
██║░░░░░██║░░░██║░░░██╔══╝░░██║░░██╗██║░░██║██╔══██╗██╔══╝░░
███████╗██║░░░██║░░░███████╗╚█████╔╝╚█████╔╝██║░░██║███████╗
╚══════╝╚═╝░░░╚═╝░░░╚══════╝░╚════╝░░╚════╝░╚═╝░░╚═╝╚══════╝
██╗░░░██╗░█████╗░███╗░░██╗██╗██╗░░░░░██╗░░░░░░█████╗░
██║░░░██║██╔══██╗████╗░██║██║██║░░░░░██║░░░░░██╔══██╗
╚██╗░██╔╝███████║██╔██╗██║██║██║░░░░░██║░░░░░███████║
░╚████╔╝░██╔══██║██║╚████║██║██║░░░░░██║░░░░░██╔══██║
░░╚██╔╝░░██║░░██║██║░╚███║██║███████╗███████╗██║░░██║
░░░╚═╝░░░╚═╝░░╚═╝╚═╝░░╚══╝╚═╝╚══════╝╚══════╝╚═╝░░╚═╝
 *
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU Lesser General Public License as published by
 * the Free Software Foundation, either version 3 of the License, orsetFlying
 * (at your option) any later version.
 *
 * @author vk.com/sanekmelkov
 *
 *
*/

namespace pocketmine\event\inventory;

use pocketmine\event\Cancellable;
use pocketmine\inventory\Inventory;
use pocketmine\item\Item;
use pocketmine\Player;

class InventoryClickEvent extends InventoryEvent implements Cancellable{
	public static $handlerList = null;

	/** @var Player */
	private $who;

	private $slot;

	/** @var Item */
	private $item;

	/** @var Inventory */
	protected $inventory;

	/**
	 * @param Inventory $inventory
	 * @param Player    $who
	 * @param int       $slot
	 * @param Item      $item
	 */
	public function __construct(Inventory $inventory, Player $who, int $slot, Item $item){
		$this->who = $who;
		$this->slot = $slot;
		$this->item = $item;
		$this->inventory = $inventory;
		parent::__construct($inventory);
	}

	/**
	 * @return Player
	 */
	public function getPlayer() : Player{
		return $this->who;
	}

	/**
	 * @return int
	 */
	public function getSlot() : int{
		return $this->slot;
	}

	/**
	 * @return Item
	 */
	public function getItem() : Item{
		return $this->item;
	}
}