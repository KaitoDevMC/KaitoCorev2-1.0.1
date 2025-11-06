<?php 

/**
*     ______  _     _
*    / ____/ (_)   (_) ___    __  __
*   / /_    / /   / / / _ \  / / / /
*  / __/   / /   / / /  __/ / /_/ /
* /_/     /_/ __/ /  \___/  \__, /
*            /___/         /____/
*   @author Fijey
*   @link github.com/fijey000
*/

namespace pocketmine\item;

use pocketmine\entity\MinecartTNT as MinecartTNTEntity;
use pocketmine\nbt\tag\CompoundTag;
use pocketmine\nbt\tag\ListTag;
use pocketmine\nbt\tag\DoubleTag;
use pocketmine\block\Rail;
use pocketmine\item\Item;
use pocketmine\level\Level;
use pocketmine\block\Block;
use pocketmine\Player;

class MinecartTNT extends Item {
    /**
	 * MinecartTNT constructor.
	 *
	 * @param int $meta
	 * @param int $count
	 */
    public function __construct($meta = 0, $count = 1){
        parent::__construct(self::MINECART_WITH_TNT, $meta, $count, 'Minecart TNT');
    }

    /**
	 * @return bool
	 */
    public function canBeActivated() : bool {
        return false;
    }

    /**
     * @return int
     */
    public function getMaxStackSize() : int {
        return 1;
    }

    /**
	 * @param Level  $level
	 * @param Player $player
	 * @param Block  $block
	 * @param Block  $target
	 * @param        $face
	 * @param        $fx
	 * @param        $fy
	 * @param        $fz
	 */
}