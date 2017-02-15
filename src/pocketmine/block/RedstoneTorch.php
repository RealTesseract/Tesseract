<?php



namespace pocketmine\block;

use pocketmine\item\Item;
use pocketmine\level\Level;
use pocketmine\Player;
use pocketmine\math\Vector3;

class RedstoneTorch extends Flowable{

	protected $id = self::REDSTONE_TORCH;
	protected $ignore = "";

	public function __construct($meta = 0){
		$this->meta = $meta;
	}

	public function getLightLevel(){
		return 7;
	}

	public function getName() : string{
		return "Redstone Torch";
	}

	public function place(Item $item, Block $block, Block $target, $face, $fx, $fy, $fz, Player $player = null){
		$below = $this->getSide(0);

		if($target->isTransparent() === false and $face !== 0){
			$faces = [
				1 => 5,
				2 => 4,
				3 => 3,
				4 => 2,
				5 => 1,
			];
			$this->meta = $faces[$face];
			$this->getLevel()->setBlock($block, $this, true, true);

			return true;
		}elseif(
				$below->isTransparent() === false or $below->getId() === self::FENCE or
				$below->getId() === self::COBBLE_WALL or
				$below->getId() == Block::REDSTONE_LAMP or
				$below->getId() == Block::LIT_REDSTONE_LAMP
		){
			$this->meta = 0;
			$this->getLevel()->setBlock($block, $this, true, true);

			return true;
		}

		return false;
	}

	public function getDrops(Item $item) : array{
		return [
			[Item::REDSTONE_TORCH, 0, 1],
		];
	}
}

