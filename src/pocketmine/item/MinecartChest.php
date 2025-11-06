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

namespace pocketmine\item;

class MinecartChest extends Item {
	/**
	 * BlazeRod constructor.
	 *
	 * @param int $meta
	 * @param int $count
	 */
	public function __construct($meta = 0, $count = 1){
		parent::__construct(self::MINECART_WITH_CHEST, $meta, $count, "Minecart Chest");
	}
	/**
	 * @return bool
	 */
    public function canBeActivated() : bool {
        return true;
    }

    /**
     * @return int
     */
    public function getMaxStackSize() : int {
        return 1;
    }
}

