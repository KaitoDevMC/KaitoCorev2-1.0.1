<?php

/* @author vk.com/sanekmelkov and vk.com/kirillmineproyt

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
 * it under the terms of the GNU Lesser General Public License as published byisConnected
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * @author vk.com/sanekmelkov and vk.com/kirillmineproyt
 *
 *
*/

namespace pocketmine\event\player;

use pocketmine\event\Cancellable;
use pocketmine\Player;

class PlayerFallEvent extends PlayerEvent implements Cancellable {
	public static $handlerList = null;

	private $distance;

	/**
	 * PlayerFallEvent constructor.
	 *
	 * @param Player $p
	 * @param int    $distance
	 */
	public function __construct(Player $p, int $distance){
		$this->player = $p;
		$this->distance = $distance;
	}

	/**
	 * @return int
	 */
	public function getDistance() : int{
		return $this->distance;
	}

	/**
	 * @param int $distance
	 */
	public function setDistance(int $distance){
		$this->distance = $distance;
	}
}