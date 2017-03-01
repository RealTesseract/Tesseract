<?php

namespace pocketmine\command\defaults;

use pocketmine\network\protocol\TransferPacket;
use pocketmine\command\CommandSender;
use pocketmine\Player;

class TransferCommand extends VanillaCommand{
	
    public function __construct($name){
        parent::__construct(
        $name,
        "%pocketmine.command.transfer.description",
        "%pocketmine.command.transfer.usage",
        ["transfer"]
        );
        $this->setPermission("pocketmine.command.transfer");
    }

    public function execute(CommandSender $sender, $currentAlias, array $args){
		$ip = $args[0];
		$port = $args[1];
		
        if(!$this->testPermission($sender)){
            return true;
        }
		
        if(!$sender instanceof Player){
            $sender->sendMessage("Run command in-game");
            return false;
        }
		
        if(!isset($ip)){
            $sender->sendMessage("Please provide a ip and port. /transferserver <ip> [port]");
            return false;
        }
		
        if(!isset($port)){ $port = 19132; }
        $sender->sendMessage("Transferring you to ".$ip.":".$port);
        $pk = new TransferPacket();
        $pk->address = $ip;
        $pk->port = $port;
        $sender->dataPacket($pk);
    }
	
}
