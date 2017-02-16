<?php



namespace pocketmine\block;

use pocketmine\entity\Entity;
use pocketmine\item\Item;
use pocketmine\math\Math;
use pocketmine\math\Vector3;
use pocketmine\level\Level;
use pocketmine\level\sound\GenericSound;
use pocketmine\Player;

class PressurePlate extends Solid{

	public function __construct($meta = 0){
		$this->meta = $meta;
	}

	public function hasEntityCollision(){
		return true;
	}

	public function place(Item $item, Block $block, Block $target, $face, $fx, $fy, $fz, Player $player = null){
		$below = $this->getSide(Vector3::SIDE_DOWN);
		if($below instanceof Transparent) return;
		else $this->getLevel()->setBlock($block, $this, true, false);
	}

	public function onBreak(Item $item){
		$this->getLevel()->setBlock($this, new Air(), true);
	}

	public function getHardness() {
		return 0.5;
	}

	public function getResistance(){
		return 2.5;
	}
}
