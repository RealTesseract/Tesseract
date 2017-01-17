<?php

 
namespace pocketmine\event\server;

use pocketmine\event;
use pocketmine\event\Cancellable;

class ServerShutdownEvent extends ServerEvent implements Cancellable{
	
	public static $handlerList = null;
	
}
