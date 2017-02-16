<?php



namespace pocketmine\block;

use pocketmine\Player;
use pocketmine\level\Level;
use pocketmine\item\Item;

class EndRod extends Flowable{

	protected $id = self::END_ROD;

	public function __construct($meta = 0){
		$this->meta = $meta;
	}

	public function getLightLevel(){
		return 14;
	}

	public function getName() : string {
		return "End Rod";
	}

	public function getResistance(){
        return 0;
    }
	
	public function getHardness(){
        return 0;
    }

	public function place(Item $item, Block $block, Block $target, $face, $fx, $fy, $fz, Player $player = null){
			$faces = [
				0 => 0,
				1 => 1,
				2 => 3,
				3 => 2,
				4 => 5,
				5 => 4,
			];
			$this->meta = ($target->getId() === self::END_ROD && $faces[$face] == $target->getDamage()) ? Vector3::getOppositeSide($faces[$face]) : $faces[$face];
			$this->getLevel()->setBlock($block, $this, true, true);
			return true;
		}

	public function getDrops(Item $item) : array {
		return [
			[$this->id, 0, 1],
		];
	}

}
