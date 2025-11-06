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

namespace pocketmine\level\generator\normal\biome;

use pocketmine\level\generator\populator\TallGrass;
use pocketmine\level\generator\populator\Tree;
use pocketmine\block\Sapling;
use pocketmine\block\Block;
use pocketmine\level\Level;
use pocketmine\level\generator\normal\biome\NormalBiome;

class SavannaBiome extends GrassyBiome {

	/**
	 * MountainsBiome constructor.
	 */
	public function __construct(){
		// parent::__construct();
		// $this->setGroundCover([
			// Block::get(Block::OBSIDIAN),
			// Block::get(Block::OBSIDIAN),
			// Block::get(Block::OBSIDIAN),
			// Block::get(Block::OBSIDIAN),
			// Block::get(Block::OBSIDIAN)
		// ]);
		$trees = new Tree(Sapling::ACACIA);
		$trees->setBaseAmount(1);
		$this->addPopulator($trees);

		$this->temperature = 1.2;
		$this->rainfall = 0;
		$this->setElevation(63, 120);
	}

	/**
	 * @return string
	 */
	public function getName() : string{
		return "Savanna";
	}
}
