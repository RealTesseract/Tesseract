<?php



namespace pocketmine\event\player;

use pocketmine\event\Cancellable;
use pocketmine\Player;

/**
 * Called when a player is sent a message via sendMessage, sendPopup or sendTip
 */
class PlayerTextPreSendEvent extends PlayerEvent implements Cancellable{

	const MESSAGE = 0;
	const POPUP = 1;
	const TIP = 2;
	const TRANSLATED_MESSAGE = 3;
	const ActionBar = 4;

	public static $handlerList = null;

	protected $message;
	protected $type = self::MESSAGE;

	public function __construct(Player $player, $message, $type = self::MESSAGE){
		$this->player = $player;
		$this->message = $message;
		$this->type = $type;
	}

	public function getMessage(){
		return $this->message;
	}

	public function setMessage($message){
		$this->message = $message;
	}

	public function getType(){
		return $this->type;
	}

	/**
	 * @return EventName
	 */
	public function getName(){
		return "PlayerTextPreSendEvent";
	}

}
