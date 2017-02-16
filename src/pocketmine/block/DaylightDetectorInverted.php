<?php



namespace pocketmine\block;




class DaylightDetectorInverted extends Solid{
	protected $id = self::DAYLIGHT_SENSOR_INVERTED;
	
	public function __construct($meta = 0){
		$this->meta = $meta;
	}
}