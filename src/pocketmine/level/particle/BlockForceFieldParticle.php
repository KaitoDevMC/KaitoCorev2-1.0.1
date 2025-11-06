<?php

/* 

  @author vk.com/sanekmelkov and vk.com/kirillmineproyt

	█   ▀ ▀█▀ █▀▀ █▀▀ █▀█ █▀█ █▀▀   ▄▄   █ █ ▄▀▄ █▄ █ ▀ █   █   ▄▀▄
	█▄▄ █  █  ██▄ █▄▄ █▄█ █▀▄ ██▄        ▀▄▀ █▀█ █ ▀█ █ █▄▄ █▄▄ █▀█
 
 
  This program is free software: you can redistribute it and/or modify
  it under the terms of the GNU Lesser General Public License as published by
  the Free Software Foundation, either version 3 of the License, or
  (at your option) any later version.
 
  @author vk.com/sanekmelkov and vk.com/kirillmineproyt
 
*/

namespace pocketmine\level\particle;

use pocketmine\block\Block;
use pocketmine\math\Vector3;
use pocketmine\network\mcpe\protocol\LevelEventPacket;

class BlockForceFieldParticle extends Particle {
	/**
	 * BlockForceFieldParticle constructor.
	 *
	 * @param Vector3 $pos
	 * @param int     $data
	 */
	public function __construct(Vector3 $pos, Block $b){
		parent::__construct($pos->x, $pos->y, $pos->z);
		$this->data = $b->getId() | ($b->getDamage() << 8);
	}

	/**
	 * @return LevelEventPacket
	 */
	public function encode(){
		$pk = new LevelEventPacket;
		$pk->evid = LevelEventPacket::EVENT_PARTICLE_BLOCK_FORCE_FIELD;
		$pk->x = $this->x;
		$pk->y = $this->y;
		$pk->z = $this->z;
		$pk->data = $this->data;

		return $pk;
	}
}
