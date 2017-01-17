<?php


namespace pocketmine\block;


class FenceGateSpruce extends FenceGate{

	protected $id = self::FENCE_GATE_SPRUCE;

	public function getName() : string{
		return "Spruce Fence Gate";
	}
}