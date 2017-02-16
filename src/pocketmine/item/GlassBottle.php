<?php



namespace pocketmine\item;

use pocketmine\block\Block;
use pocketmine\level\Level;
use pocketmine\Player;
use pocketmine\event\player\PlayerGlassBottleEvent;

class GlassBottle extends Item{
	public function __construct($meta = 0, $count = 1){
		parent::__construct(self::GLASS_BOTTLE, $meta, $count, "Glass Bottle");
	}

	public function canBeActivated() : bool{
		return true;
	}

	public function onActivate(Level $level, Player $player, Block $block, Block $target, $face, $fx, $fy, $fz){
		if($player === null or $player->isSurvival() !== true){
			return false;
		}
		if($target->getId() === Block::STILL_WATER or $target->getId() === Block::WATER){
			$player->getServer()->getPluginManager()->callEvent($ev = new PlayerGlassBottleEvent($player, $target, $this));
			if($ev->isCancelled()){
				return false;
			}else{
				if($this->count <= 1){
					$player->getInventory()->setItemInHand(Item::get(Item::POTION, 0, 1));
					return true;
				}else{
					$this->count--;
					$player->getInventory()->setItemInHand($this);
				}
				if($player->getInventory()->canAddItem(Item::get(Item::POTION, 0, 1)) === true){
					$player->getInventory()->AddItem(Item::get(Item::POTION, 0, 1));
				}else{
					$motion = $player->getDirectionVector()->multiply(0.4);
					$position = clone $player->getPosition();
					$player->getLevel()->dropItem($position->add(0 , 0.5, 0), Item::get(Item::POTION, 0, 1) , $motion, 40);
				}
				return true;
			}
		}
		return false;
	}
}