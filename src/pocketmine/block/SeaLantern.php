<?php



namespace pocketmine\block;


use pocketmine\item\Item;

class SeaLantern extends Transparent implements SolidLight{

	protected $id = self::SEA_LANTERN;

	public function __construct($meta = 0){
		$this->meta = $meta;
	}

	public function getLightLevel(){
		return 15;
	}

	public function getName() : string{
        return "Sea Lantern";
	}

	public function getHardness(){
		return 0.3;
	}

	public function getDrops(Item $item) : array {
		return [
			[Item::PRISMARINE_CRYSTALS, 0, 3],
		];
	}

}
