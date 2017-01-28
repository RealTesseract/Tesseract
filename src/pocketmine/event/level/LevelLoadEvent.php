<?php



namespace pocketmine\event\level;

/**
 * Called when a Level is loading
 */
class LevelLoadEvent extends LevelEvent{

	public static $handlerList = null;

	/**
	 * @return EventName
	 */
	public function getName(){
		return "LevelLoadEvent";
	}

}
