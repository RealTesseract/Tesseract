<?php


namespace pocketmine\network\protocol;

#include <rules/DataPacket.h>


class PlayerActionPacket extends DataPacket{
	const NETWORK_ID = Info::PLAYER_ACTION_PACKET;

	const ACTION_START_BREAK = 0;
	const ACTION_ABORT_BREAK = 1;
	const ACTION_STOP_BREAK = 2;


	const ACTION_RELEASE_ITEM = 5;
	const ACTION_STOP_SLEEPING = 6;
	const ACTION_SPAWN_SAME_DIMENSION = 7;
	const ACTION_JUMP = 8;
	const ACTION_START_SPRINT = 9;
	const ACTION_STOP_SPRINT = 10;
	const ACTION_START_SNEAK = 11;
	const ACTION_STOP_SNEAK = 12;
	const ACTION_SPAWN_OVERWORLD = 13;
	const ACTION_SPAWN_NETHER = 14;

	const ACTION_START_GLIDE = 15;
	const ACTION_STOP_GLIDE = 16;

	public $eid;
	public $action;
	public $x;
	public $y;
	public $z;
	public $face;

	public function decode(){
		$this->eid = $this->getEntityId();
		$this->action = $this->getVarInt();
		$this->getBlockCoords($this->x, $this->y, $this->z);
		$this->face = $this->getVarInt();
	}

	public function encode(){
		$this->reset();
		$this->putEntityId($this->eid);
		$this->putVarInt($this->action);
		$this->putBlockCoords($this->x, $this->y, $this->z);
		$this->putVarInt($this->face);
	}

}
