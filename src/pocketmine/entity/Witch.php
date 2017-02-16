<?php



namespace pocketmine\entity;

use pocketmine\Player;
use pocketmine\network\protocol\AddEntityPacket;

class Witch extends Monster{
	const NETWORK_ID = 45;
	
	public $dropExp = [5, 5];
	
	public function getName() : string{
		return "Witch";
	}
	
	public function initEntity(){
		$this->setMaxHealth(26);
		parent::initEntity();
	}
	
	public function spawnTo(Player $player){
		$pk = new AddEntityPacket();
		$pk->eid = $this->getId();
		$pk->type = Witch::NETWORK_ID;
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
	
	public function getDrops(){
		$cause = $this->lastDamageCause;
		$drops = [];
		if($cause instanceof EntityDamageByEntityEvent and $cause->getDamager() instanceof Player){
				switch(mt_rand(2, 7)){
					case 2:
						$drops[] = ItemItem::get(ItemItem::POTION_WATER_BREATHING, 0, $rnd);
						break;
					case 3:
					$rnd = mt_rand(1, 3);
						$drops[] = ItemItem::get(ItemItem::GLOWSTONE_DUST, 0, $rnd);
						break;
					case 4:
					$rnd = mt_rand(1, 3);
						$drops[] = ItemItem::get(ItemItem::GUNPOWDER, 0, $rnd);
						break;
					case 5:
					$rnd = mt_rand(1, 3);
						$drops[] = ItemItem::get(ItemItem::POTION_HEALING, 0, $rnd);
						break;
					case 6:
					$rnd = mt_rand(1, 3);
						$drops[] = ItemItem::get(ItemItem::POTION_FIRE_RESISTANCE, 0, $rnd);
						break;
					case 7:
					$rnd = mt_rand(1, 3);
						$drops[] = ItemItem::get(ItemItem::POTION_SWIFTNESS, 0, $rnd);
						break;
				}
			}
			$count = mt_rand(0, 1);
			if($count > 1){
				$drops[] = ItemItem::get(ItemItem::GLASS_BOTTLE, 0, $count); /* This is a Rare loot */
			}

		return $drops;
	}
}