<?php



namespace pocketmine\item;

use pocketmine\block\Air;
use pocketmine\block\Block;
use pocketmine\block\Liquid;
use pocketmine\event\player\PlayerBucketFillEvent;
use pocketmine\event\player\PlayerBucketEmptyEvent;
use pocketmine\level\Level;
use pocketmine\Player;

class Bucket extends Item{
	public function __construct($meta = 0, $count = 1){
		parent::__construct(self::BUCKET, $meta, $count, "Bucket");
	}

	public function getMaxStackSize() : int{
		return 1;
	}

	public function canBeActivated() : bool{
		return true;
	}

	public function onActivate(Level $level, Player $player, Block $block, Block $target, $face, $fx, $fy, $fz){
		$targetBlock = Block::get($this->meta);

		if($targetBlock instanceof Air){
			if($target instanceof Liquid and $target->getDamage() === 0){
				$result = clone $this;
				$id = $target->getId();
				if($id == self::STILL_WATER){
					$id = self::WATER;
				}
				if($id == self::STILL_LAVA){
					$id = self::LAVA;
				}
				$result->setDamage($id);
				$player->getServer()->getPluginManager()->callEvent($ev = new PlayerBucketFillEvent($player, $block, $face, $this, $result));
				if(!$ev->isCancelled()){
					$player->getLevel()->setBlock($target, new Air(), true, true);
					if($player->isSurvival()){
						$player->getInventory()->setItemInHand($ev->getItem());
					}
					return true;
				}else{
					$player->getInventory()->sendContents($player);
				}
			}
		}elseif($targetBlock instanceof Liquid){
			$result = clone $this;
			$result->setDamage(0);
			$player->getServer()->getPluginManager()->callEvent($ev = new PlayerBucketEmptyEvent($player, $block, $face, $this, $result));
			if(!$ev->isCancelled()){
				//Only disallow water placement in the Nether, allow other liquids to be placed
				//In vanilla, water buckets are emptied when used in the Nether, but no water placed.
				if(!($player->getLevel()->getDimension() === Level::DIMENSION_NETHER and $targetBlock->getID() === self::WATER)){
					$player->getLevel()->setBlock($block, $targetBlock, true, true);
				}
				if($player->isSurvival()){
					$player->getInventory()->setItemInHand($ev->getItem());
				}
				return true;
			}else{
				$player->getInventory()->sendContents($player);
			}
		}

		return false;
	}
}