<?php


namespace pocketmine\block;


class Wood2 extends Wood{

	const ACACIA = 0;
	const DARK_OAK = 1;

	protected $id = self::WOOD2;

	public function getName() : string{
		static $names = [
			0 => "Acacia Wood",
			1 => "Dark Oak Wood",
			2 => "Unknown",
			3 => "Unknown"
		];
		return $names[$this->meta & 0x03];
	}
}
