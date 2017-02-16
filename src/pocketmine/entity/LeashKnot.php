<?php



namespace pocketmine\entity;




use pocketmine\level\format\FullChunk;

use pocketmine\nbt\tag\CompoundTag;

use pocketmine\network\protocol\AddEntityPacket;
use pocketmine\Player;

class LeashKnot extends Entity{
	const NETWORK_ID = 88;

	//TO-DO: Find the REAL width, length and height.
	public $width = 0.98;
	public $length = 0.98;
	public $height = 0.98;

	protected $gravity = 0.04;
	protected $drag = 0.02;

	public $canCollide = false;

	private $dropItem = true;

	public function __construct(FullChunk $chunk, CompoundTag $nbt, bool $dropItem = true){
		parent::__construct($chunk, $nbt);
		$this->dropItem = $dropItem;
	}

	protected function initEntity(){
		parent::initEntity();
	}


	public function canCollideWith(Entity $entity){
		return false;
	}

	public function spawnTo(Player $player){
		$pk = new AddEntityPacket();
		$pk->type = LeashKnot::NETWORK_ID;
		$pk->eid = $this->getId();
		$pk->x = $this->x;
		$pk->y = $this->y;
		$pk->z = $this->z;
		$pk->speedX = $this->motionX;
		$pk->speedY = $this->motionY;
		$pk->speedZ = $this->motionZ;
		$pk->metadata = $this->dataProperties;
		$player->dataPacket($pk);

		parent::spawnTo($player);
	}
}