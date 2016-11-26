<?php


 
namespace WingProxy\network;

use pocketmine\network\protocol\DataPacket;
use pocketmine\network\SourceInterface;
use pocketmine\Player;
use WingProxy\network\protocol\spp\RedirectPacket;
use WingProxy\WingProxy;

class SynLibInterface implements SourceInterface{
	private $WingProxyInterface;
	private $WingProxy;

	public function __construct(WingProxy $WingProxy, WingProxyInterface $interface){
		$this->WingProxy = $WingProxy;
		$this->WingProxyInterface = $interface;
	}

	public function emergencyShutdown(){
	}

	public function setName($name){
	}

	public function process(){
	}

	public function close(Player $player, $reason = "unknown reason"){
	}

	public function putPacket(Player $player, DataPacket $packet, $needACK = false, $immediate = true){
		$packet->encode();
		$pk = new RedirectPacket();
		$pk->uuid = $player->getUniqueId();
		$pk->direct = $immediate;
		$pk->mcpeBuffer = $packet->buffer;
		$this->WingProxyInterface->putPacket($pk);
	}

	public function shutdown(){
	}
}