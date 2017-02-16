<?php



namespace pocketmine\network\protocol;

#include <rules/DataPacket.h>

#ifndef COMPILE


#endif

class AddEntityPacket extends DataPacket{

	const NETWORK_ID = Info::ADD_ENTITY_PACKET;

	public $eid;
	public $type;
	public $x;
	public $y;
	public $z;
	public $speedX;
	public $speedY;
	public $speedZ;
	public $yaw;
	public $pitch;
	public $attributes = [];
	public $metadata = [];
	public $links = [];

	public function decode(){

	}

	public function encode(){
		$this->reset();
		$this->putEntityId($this->eid); //EntityUniqueID - TODO: verify this
		$this->putEntityId($this->eid);
		$this->putUnsignedVarInt($this->type);
		$this->putVector3f($this->x, $this->y, $this->z);
		$this->putVector3f($this->speedX, $this->speedY, $this->speedZ);
		$this->putLFloat($this->pitch * (256 / 360));
		$this->putLFloat($this->yaw * (256 / 360));
		$this->putUnsignedVarInt(count($this->attributes));
		foreach($this->attributes as $entry){
			$this->putString($entry->getName());
			$this->putLFloat($entry->getMinValue());
			$this->putLFloat($entry->getValue());
			$this->putLFloat($entry->getMaxValue());
		}
		$this->putEntityMetadata($this->metadata);
		$this->putUnsignedVarInt(count($this->links));
		foreach($this->links as $link){
			$this->putEntityId($link[0]);
			$this->putEntityId($link[1]);
			$this->putByte($link[2]);
		}
	}

	/**
	 * @return PacketName
	 */
	public function getName(){
		return "AddEntityPacket";
	}

}
