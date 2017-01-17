<?php


namespace pocketmine\network\protocol;

#include <rules/DataPacket.h>


class ResourcePacksInfoPacket extends DataPacket{
	const NETWORK_ID = Info::RESOURCE_PACKS_INFO_PACKET;

	public $mustAccept = false; //force client to use selected resource packs
	/** @var ResourcePackInfoEntry */
	public $behaviourPackEntries = [];
	/** @var ResourcePackInfoEntry */
	public $resourcePackEntries = [];

	public function decode(){

	}

	public function encode(){
		$this->reset();

		$this->putBool($this->mustAccept);
		$this->putShort(count($this->behaviourPackEntries));
		foreach($this->behaviourPackEntries as $entry){
			$this->putString($entry->getPackId());
			$this->putString($entry->getVersion());
			$this->putLong($entry->getPackSize());
		}
		$this->putShort(count($this->resourcePackEntries));
		foreach($this->resourcePackEntries as $entry){
			$this->putString($entry->getPackId());
			$this->putString($entry->getVersion());
			$this->putLong($entry->getPackSize());
		}
	}
}