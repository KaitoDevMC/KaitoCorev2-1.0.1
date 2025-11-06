<?php

/*
 *
 *  _____            _               _____           
 * / ____|          (_)             |  __ \          
 *| |  __  ___ _ __  _ ___ _   _ ___| |__) | __ ___  
 *| | |_ |/ _ \ '_ \| / __| | | / __|  ___/ '__/ _ \ 
 *| |__| |  __/ | | | \__ \ |_| \__ \ |   | | | (_) |
 * \_____|\___|_| |_|_|___/\__, |___/_|   |_|  \___/ 
 *                         __/ |                    
 *                        |___/                     
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU Lesser General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * @author GenisysPro
 * @link https://github.com/GenisysPro/GenisysPro
 *
 *
*/

namespace pocketmine\block;

use pocketmine\item\Item;
use pocketmine\item\Tool;
use pocketmine\Player;

class Purpur extends Solid {

	const PURPUR_NORMAL = 0;
	const PURPUR_PILLAR = 2;

	protected $id = self::PURPUR;



	/**
	 * Purpur constructor.
	 *
	 * @param int $meta
	 */
	public function __construct($meta = 0){
		$this->meta = $meta;
	}

	/**
	 * @return float
	 */
	public function getHardness(){
		return 1.5;
	}

	public function getResistance(){
		return 30;
	}

	/**
	 * @return int
	 */
	public function getToolType(){
		return Tool::TYPE_PICKAXE;
	}

	/**
	 * @return string
	 */
	public function getName() : string{
		static $names = [
			0 => "Purpur Block",
			2 => "Purpur Pillar",
		];
		return $names[$this->meta & 0x02];
	}

	/**
	 * @param Item $item
	 *
	 * @return array
	 */
	public function place(Item $item, Block $block, Block $target, $face, $fx, $fy, $fz, Player $player = null){
		if($this->meta === 2){
			$faces = [
				0 => 0,
				1 => 0,
				2 => 0b1000,
				3 => 0b1000,
				4 => 0b0100,
				5 => 0b0100,
			];
			$this->meta = ($this->meta & 0x03) | $faces[$face];
		}
		$this->getLevel()->setBlock($block, $this, true, true);
		return true;
	}
	public function getDrops(Item $item) : array{
		if($item->isPickaxe() >= Tool::TIER_WOODEN){

			return [
				[$this->id, $this->meta & 0x0f, 1],
			];

		}else{

			return [];

		}
	}

}
