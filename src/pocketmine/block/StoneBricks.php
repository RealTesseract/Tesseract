<?php



namespace pocketmine\block;

use pocketmine\item\Item;
use pocketmine\item\Tool;

class StoneBricks extends Solid{
	
	const NORMAL = 0;
	const MOSSY = 1;
	const CRACKED = 2;
	const CHISELED = 3;

	protected $id = self::STONE_BRICKS;

	public function __construct($meta = 0){
		$this->meta = $meta;
	}

	public function getHardness() {
		return 1.5;
	}

	public function getToolType(){
		return Tool::TYPE_PICKAXE;
	}

	public function getName() : string{
		static $names = [
			0 => "Stone Bricks",
			1 => "Mossy Stone Bricks",
			2 => "Cracked Stone Bricks",
			3 => "Chiseled Stone Bricks",
		];
		return $names[$this->meta & 0x03];
	}
	
	public function getDrops(Item $item) : array {
		if($item->isPickaxe() >= 1){
			return [
				[Item::STONE_BRICKS, $this->meta & 0x03, 1],
			];
		}else{
			return [];
		}
	}

}