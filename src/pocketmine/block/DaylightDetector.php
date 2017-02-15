<?php



namespace pocketmine\block;

use pocketmine\item\Item;
use pocketmine\Player;
use pocketmine\nbt\tag\CompoundTag;
use pocketmine\nbt\tag\StringTag;
use pocketmine\nbt\tag\IntTag;
use pocketmine\tile\Tile;

class DaylightDetector extends Solid{
	protected $id = self::DAYLIGHT_SENSOR;
	
	public function __construct($meta = 0){
		$this->meta = $meta;
	}

	public function getName() : string{
		return "Daylight Sensor";
	}

	public function getBoundingBox(){
		if($this->boundingBox === null){
			$this->boundingBox = $this->recalculateBoundingBox();
		}
		return $this->boundingBox;
	}

	public function canBeFlowedInto(){
		return false;
	}

	public function canBeActivated() : bool {
		return true;
	}

	public function getHardness() {
		return 0.2;
	}

	public function getResistance(){
		return 1;
	}

	public function getDrops(Item $item) : array {
		return [
			[self::DAYLIGHT_SENSOR, 0, 1]
		];
	}
}