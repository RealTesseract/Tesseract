<?php



namespace pocketmine\block;




class Rail extends Solid{

	protected $id = self::RAIL;

	public function __construct($meta = 0){
		$this->meta = $meta;
	}

	public function getName() : string{
		return "Rail";
	}
}