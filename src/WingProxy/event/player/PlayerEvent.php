<?php


 
namespace WingProxy\event\player;

use WingProxy\event\Event;

abstract class PlayerEvent extends Event{
	/** @var \WingProxy\Player */
	protected $player;

	public function getPlayer(){
		return $this->player;
	}
}