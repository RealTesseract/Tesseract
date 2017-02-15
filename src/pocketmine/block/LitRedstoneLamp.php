<?php



namespace pocketmine\block;

use pocketmine\item\Item;
use pocketmine\item\Tool;
use pocketmine\math\Vector3;

class LitRedstoneLamp extends Solid{
	protected $id = self::LIT_REDSTONE_LAMP;

	public function __construct($meta = 0){
		$this->meta = $meta;
	}

	public function getName() : string{
		return "Lit Redstone Lamp";
	}

	public function getHardness() {
		return 0.3;
	}

	public function getToolType(){
		return Tool::TYPE_PICKAXE;
	}


	public function getDrops(Item $item) : array {
		return [
			[Item::INACTIVE_REDSTONE_LAMP, 0 ,1],
		];
	}
}