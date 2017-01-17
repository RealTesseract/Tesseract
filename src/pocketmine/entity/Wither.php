<?php


namespace pocketmine\entity;

use pocketmine\network\protocol\AddEntityPacket;
use pocketmine\Player;
use pocketmine\item\Item as ItemItem;

class Wither extends FlyingAnimal{
	const NETWORK_ID = 52;

	public $width = 0.72;
	public $length = 6; //TODO: Find the good one.
	public $height = 2;

	public $dropExp = 50;
	
	public function getName() : string{
		return "Wither";
	}

	public function initEntity(){
		$this->setMaxHealth(300);
		parent::initEntity();
	}
	
	public function spawnTo(Player $player){
		$pk = new AddEntityPacket();
		$pk->eid = $this->getId();
		$pk->type = Wither::NETWORK_ID;
		$pk->x = $this->x;
		$pk->y = $this->y;
		$pk->z = $this->z;
		$pk->speedX = $this->motionX;
		$pk->speedY = $this->motionY;
		$pk->speedZ = $this->motionZ;
		$pk->yaw = $this->yaw;
		$pk->pitch = $this->pitch;
		$pk->metadata = $this->dataProperties;
		$player->dataPacket($pk);

		parent::spawnTo($player);
	}

	//TODO: Add his spawn scenario and his death scenario

	public function getDrops(){
		$drops = [ItemItem::get(ItemItem::NETHER_STAR, 0, 1)];
		return $drops;
	}
}
