<?php



namespace pocketmine\network\protocol;

class SetEntityDataPacket extends DataPacket{

	const NETWORK_ID = Info::SET_ENTITY_DATA_PACKET;

	public $eid;
	public $metadata;

	public function decode(){

	}

	public function encode(){
		$this->reset();
		$this->putEntityId($this->eid);
		$this->putEntityMetadata($this->metadata);
	}

	/**
	 * @return PacketName
	 */
	public function getName(){
		return "SetEntityDataPacket";
	}

}
