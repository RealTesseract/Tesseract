<?php



namespace pocketmine\block;

use pocketmine\item\Item;
use pocketmine\item\Tool;

class ChorusPlant extends Crops{

	protected $id = self::CHORUS_PLANT;

	public function __construct($meta = 0){
		$this->meta = $meta;
	}

    	public function getHardness(){
		return 0.4;
	}

	public function getToolType(){
		return Tool::TYPE_AXE;
	}

	public function getName() : string{
		return "Chorus Plant";
	}

	public function getDrops(Item $item) : array {
		$drops = [];
		if($this->meta >= 0x07){
			$drops[] = [Item::CHORUS_FRUIT, 0, 1];
		}
		return $drops;
	}

}