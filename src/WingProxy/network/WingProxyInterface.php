<?php


 
namespace WingProxy\network;

use WingProxy\network\protocol\spp\BroadcastPacket;
use WingProxy\network\protocol\spp\ConnectPacket;
use WingProxy\network\protocol\spp\DataPacket;
use WingProxy\network\protocol\spp\DisconnectPacket;
use WingProxy\network\protocol\spp\FastPlayerListPacket;
use WingProxy\network\protocol\spp\HeartbeatPacket;
use WingProxy\network\protocol\spp\Info;
use WingProxy\network\protocol\spp\InformationPacket;
use WingProxy\network\protocol\spp\PlayerLoginPacket;
use WingProxy\network\protocol\spp\PlayerLogoutPacket;
use WingProxy\network\protocol\spp\RedirectPacket;
use WingProxy\network\protocol\spp\TransferPacket;
use WingProxy\network\synlib\WingProxyClient;
use WingProxy\WingProxy;

class WingProxyInterface{
	private $WingProxy;
	private $ip;
	private $port;
	/** @var WingProxyClient */
	private $client;
	/** @var DataPacket[] */
	private $packetPool = [];
	private $connected = true;
	
	public function __construct(WingProxy $server, string $ip, int $port){
		$this->WingProxy = $server;
		$this->ip = $ip;
		$this->port = $port;
		$this->registerPackets();
		$this->client = new WingProxyClient($server->getLogger(), $server->getTesseractServer()->getLoader(), $port, $ip);
	}

	public function getWingProxy(){
		return $this->WingProxy;
	}

	public function reconnect(){
		$this->client->reconnect();
	}

	public function shutdown(){
		$this->client->shutdown();
	}

	public function putPacket(DataPacket $pk){
		if(!$pk->isEncoded){
			$pk->encode();
		}
		$this->client->pushMainToThreadPacket($pk->buffer);
	}

	public function isConnected() : bool{
		return $this->connected;
	}

	public function process(){
		while(strlen($buffer = $this->client->readThreadToMainPacket()) > 0){
			$this->handlePacket($buffer);
		}
		$this->connected = $this->client->isConnected();
		if($this->client->isNeedAuth()){
			$this->WingProxy->connect();
			$this->client->setNeedAuth(false);
		}
	}

	/**
	 * @param $buffer
	 *
	 * @return DataPacket
	 */
	public function getPacket($buffer) {
		$pid = ord($buffer{0});
		/** @var DataPacket $class */
		$class = $this->packetPool[$pid];
		if ($class !== null) {
			$pk = clone $class;
			$pk->setBuffer($buffer, 1);
			return $pk;
		}
		return null;
	}

	public function handlePacket($buffer){
		if(($pk = $this->getPacket($buffer)) != null){
			$pk->decode();
			$this->WingProxy->handleDataPacket($pk);
		}
	}

	/**
	 * @param int        $id 0-255
	 * @param DataPacket $class
	 */
	public function registerPacket($id, $class) {
		$this->packetPool[$id] = new $class;
	}


	private function registerPackets() {
		$this->packetPool = new \SplFixedArray(256);

		$this->registerPacket(Info::HEARTBEAT_PACKET, HeartbeatPacket::class);
		$this->registerPacket(Info::CONNECT_PACKET, ConnectPacket::class);
		$this->registerPacket(Info::DISCONNECT_PACKET, DisconnectPacket::class);
		$this->registerPacket(Info::REDIRECT_PACKET, RedirectPacket::class);
		$this->registerPacket(Info::PLAYER_LOGIN_PACKET, PlayerLoginPacket::class);
		$this->registerPacket(Info::PLAYER_LOGOUT_PACKET, PlayerLogoutPacket::class);
		$this->registerPacket(Info::INFORMATION_PACKET, InformationPacket::class);
		$this->registerPacket(Info::TRANSFER_PACKET, TransferPacket::class);
		$this->registerPacket(Info::BROADCAST_PACKET, BroadcastPacket::class);
		$this->registerPacket(Info::FAST_PLAYER_LIST_PACKET, FastPlayerListPacket::class);
	}
}
