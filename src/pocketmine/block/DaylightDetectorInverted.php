<?php



namespace pocketmine\block;

use pocketmine\item\Item;
use pocketmine\Player;

class DaylightDetectorInverted extends Solid{
	protected $id = self::DAYLIGHT_SENSOR_INVERTED;
	
	public function __construct($meta = 0){
		$this->meta = $meta;
	}
}