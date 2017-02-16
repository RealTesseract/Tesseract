<?php



namespace pocketmine;

use pocketmine\block\Block;
use pocketmine\command\CommandReader;
use pocketmine\command\CommandSender;
use pocketmine\command\ConsoleCommandSender;
use pocketmine\command\PluginIdentifiableCommand;
use pocketmine\command\SimpleCommandMap;
use pocketmine\entity\Attribute;
use pocketmine\entity\Effect;
use pocketmine\entity\Entity;
use pocketmine\event\HandlerList;
use pocketmine\event\level\LevelInitEvent;
use pocketmine\event\level\LevelLoadEvent;
use pocketmine\event\server\QueryRegenerateEvent;
use pocketmine\event\server\ServerCommandEvent;
use pocketmine\event\Timings;
use pocketmine\event\TimingsHandler;
use pocketmine\event\TranslationContainer;
use pocketmine\inventory\CraftingManager;
use pocketmine\inventory\InventoryType;
use pocketmine\inventory\Recipe;
use pocketmine\item\enchantment\Enchantment;
use pocketmine\item\enchantment\EnchantmentLevelTable;
use pocketmine\item\Item;
use pocketmine\lang\BaseLang;
use pocketmine\level\format\io\region\Anvil;
use pocketmine\level\format\io\region\McRegion;
use pocketmine\level\format\io\region\PMAnvil;
use pocketmine\level\format\io\LevelProviderManager;
use pocketmine\level\generator\biome\Biome;
use pocketmine\level\generator\Flat;
use pocketmine\level\generator\Generator;
use pocketmine\level\generator\nether\Nether;
use pocketmine\level\generator\normal\Normal;
use pocketmine\level\Level;
use pocketmine\level\LevelException;
use pocketmine\metadata\EntityMetadataStore;
use pocketmine\metadata\LevelMetadataStore;
use pocketmine\metadata\PlayerMetadataStore;
use pocketmine\nbt\NBT;
use pocketmine\nbt\tag\ByteTag;
use pocketmine\nbt\tag\CompoundTag;
use pocketmine\nbt\tag\DoubleTag;
use pocketmine\nbt\tag\ListTag;
use pocketmine\nbt\tag\FloatTag;
use pocketmine\nbt\tag\IntTag;
use pocketmine\nbt\tag\LongTag;
use pocketmine\nbt\tag\ShortTag;
use pocketmine\nbt\tag\StringTag;
use pocketmine\network\CompressBatchedTask;
use pocketmine\network\Network;
use pocketmine\network\protocol\Info;
use pocketmine\network\protocol\BatchPacket;
use pocketmine\network\protocol\DataPacket;
use pocketmine\network\protocol\PlayerListPacket;
use pocketmine\network\query\QueryHandler;
use pocketmine\network\RakLibInterface;
use pocketmine\network\rcon\RCON;
use pocketmine\network\upnp\UPnP;
use pocketmine\permission\BanList;
use pocketmine\permission\DefaultPermissions;
use pocketmine\plugin\PharPluginLoader;
use pocketmine\plugin\FolderPluginLoader;
use pocketmine\plugin\Plugin;
use pocketmine\plugin\PluginLoadOrder;
use pocketmine\plugin\PluginManager;
use pocketmine\plugin\ScriptPluginLoader;
use pocketmine\scheduler\DServerTask;
use pocketmine\scheduler\FileWriteTask;
use pocketmine\scheduler\SendUsageTask;
use pocketmine\scheduler\ServerScheduler;
use pocketmine\tile\Tile;
use pocketmine\utils\Binary;
use pocketmine\utils\Color;
use pocketmine\utils\Config;
use pocketmine\utils\MainLogger;
use pocketmine\utils\ServerException;
use pocketmine\utils\Terminal;
use pocketmine\utils\TextFormat;
use pocketmine\utils\Utils;
use pocketmine\utils\UUID;

//TODO use pocketmine\level\generator\ender\Ender;



/**
 * The class that manages everything
 */
class Server{
    const BROADCAST_CHANNEL_ADMINISTRATIVE = "pocketmine.broadcast.admin";
    const BROADCAST_CHANNEL_USERS = "pocketmine.broadcast.user";

    const PLAYER_MSG_TYPE_MESSAGE = 0;
    const PLAYER_MSG_TYPE_TIP = 1;
    const PLAYER_MSG_TYPE_POPUP = 2;

    /** @var Server */
    private static $instance = null;

    /** @var \Threaded */
    private static $sleeper = null;

    /** @var BanList */
    private $banByName = null;

    /** @var BanList */
    private $banByIP = null;

    /** @var BanList */
    private $banByCID = \null;

    /** @var Config */
    private $operators = null;

    /** @var Config */
    private $whitelist = null;

    /** @var bool */
    private $isRunning = true;

    private $hasStopped = false;

    /** @var PluginManager */
    private $pluginManager = null;

    private $profilingTickRate = 20;

    /** @var ServerScheduler */
    private $scheduler = null;

    /**
     * Counts the ticks since the server start
     *
     * @var int
     */
    private $tickCounter;
    private $nextTick = 0;
    private $tickAverage = [20, 20, 20, 20, 20, 20, 20, 20, 20, 20, 20, 20, 20, 20, 20, 20, 20, 20, 20, 20];
    private $useAverage = [0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0];
    private $currentTPS = 20;
    private $currentUse = 0;

    private $sendUsageTicker = 0;

    private $dispatchSignals = false;

    /** @var \AttachableThreadedLogger */
    private $logger;

    /** @var MemoryManager */
    private $memoryManager;

    /** @var CommandReader */
    private $console = null;
    //private $consoleThreaded;

    /** @var SimpleCommandMap */
    private $commandMap = null;

    /** @var CraftingManager */
    private $craftingManager;

    /** @var ConsoleCommandSender */
    private $consoleSender;

	/** @var int */
	private $maxPlayers;
	
	/** @var bool */
	private $autoSave;


    /** @var int */
    private $maxTick;

    /** @var bool */
    private $autoSave;

    /** @var RCON */
    private $rcon;

    /** @var EntityMetadataStore */
    private $entityMetadata;

    /** @var PlayerMetadataStore */
    private $playerMetadata;

    /** @var LevelMetadataStore */
    private $levelMetadata;


        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        $response = curl_exec($ch);
        curl_close($ch);
        return $response;
    }


	public static function microSleep(int $microseconds){
		Server::$sleeper->synchronized(function(int $ms){
			Server::$sleeper->wait($ms);
		}, $microseconds);
	}

	public function loadAdvancedConfig(){
		$this->playerMsgType = $this->getAdvancedProperty("server.player-msg-type", self::PLAYER_MSG_TYPE_MESSAGE);
		$this->playerLoginMsg = $this->getAdvancedProperty("server.login-msg", "§3@player joined the game");
		$this->playerLogoutMsg = $this->getAdvancedProperty("server.logout-msg", "§3@player left the game");
		$this->weatherEnabled = $this->getAdvancedProperty("level.weather", true);
		$this->foodEnabled = $this->getAdvancedProperty("player.hunger", true);
		$this->expEnabled = $this->getAdvancedProperty("player.experience", true);
		$this->keepInventory = $this->getAdvancedProperty("player.keep-inventory", false);
		$this->keepExperience = $this->getAdvancedProperty("player.keep-experience", false);
		$this->netherEnabled = $this->getAdvancedProperty("level.allow-nether", false);
		$this->netherName = $this->getAdvancedProperty("level.level-name", "nether");
		$this->weatherRandomDurationMin = $this->getAdvancedProperty("level.weather-random-duration-min", 6000);
		$this->weatherRandomDurationMax = $this->getAdvancedProperty("level.weather-random-duration-max", 12000);
		$this->lightningTime = $this->getAdvancedProperty("level.lightning-time", 200);
		$this->lightningFire = $this->getAdvancedProperty("level.lightning-fire", false);
		$this->allowSnowGolem = $this->getAdvancedProperty("server.allow-snow-golem", false);
		$this->allowIronGolem = $this->getAdvancedProperty("server.allow-iron-golem", false);
		$this->autoClearInv = $this->getAdvancedProperty("player.auto-clear-inventory", true);
		$this->dserverConfig = [
			"enable" => $this->getAdvancedProperty("dserver.enable", false),
			"queryAutoUpdate" => $this->getAdvancedProperty("dserver.query-auto-update", false),
			"queryTickUpdate" => $this->getAdvancedProperty("dserver.query-tick-update", true),
			"motdMaxPlayers" => $this->getAdvancedProperty("dserver.motd-max-players", 0),
			"queryMaxPlayers" => $this->getAdvancedProperty("dserver.query-max-players", 0),
			"motdAllPlayers" => $this->getAdvancedProperty("dserver.motd-all-players", false),
			"queryAllPlayers" => $this->getAdvancedProperty("dserver.query-all-players", false),
			"motdPlayers" => $this->getAdvancedProperty("dserver.motd-players", false),
			"queryPlayers" => $this->getAdvancedProperty("dserver.query-players", false),
			"timer" => $this->getAdvancedProperty("dserver.time", 40),
			"retryTimes" => $this->getAdvancedProperty("dserver.retry-times", 3),
			"serverList" => explode(";", $this->getAdvancedProperty("dserver.server-list", ""))
		];
		$this->getLogger()->setWrite(!$this->getAdvancedProperty("server.disable-log", false));
		$this->asyncChunkRequest = $this->getAdvancedProperty("server.async-chunk-request", true);
		$this->limitedCreative = $this->getAdvancedProperty("server.limited-creative", true);
		$this->chunkRadius = $this->getAdvancedProperty("player.chunk-radius", -1);
		$this->allowSplashPotion = $this->getAdvancedProperty("server.allow-splash-potion", true);
		$this->fireSpread = $this->getAdvancedProperty("level.fire-spread", false);
		$this->advancedCommandSelector = $this->getAdvancedProperty("server.advanced-command-selector", false);
		$this->anvilEnabled = $this->getAdvancedProperty("enchantment.enable-anvil", true);
		$this->enchantingTableEnabled = $this->getAdvancedProperty("enchantment.enable-enchanting-table", true);
		$this->countBookshelf = $this->getAdvancedProperty("enchantment.count-bookshelf", false);
		$this->raklibDisable = $this->getAdvancedProperty("network.raklib-disable", false);
		$this->allowInventoryCheats = $this->getAdvancedProperty("inventory.allow-cheats", false);
		$this->checkMovement = $this->getAdvancedProperty("anticheat.check-movement", true);
		$this->allowInstabreak = $this->getAdvancedProperty("anticheat.allow-instabreak", true);
		$this->antiFly = $this->getAdvancedProperty("anticheat.anti-fly", true);
	}
	
	/**
	 * @return int
	 *
	 * Get DServer max players
	 */
	public function getDServerMaxPlayers(){
		return ($this->dserverAllPlayers + $this->getMaxPlayers());
	}

	/**
	 * @return int
	 *
	 * Get DServer all online player count
	 */
	public function getDServerOnlinePlayers(){
		return ($this->dserverPlayers + count($this->getOnlinePlayers()));
	}

	public function isDServerEnabled(){
		return $this->dserverConfig["enable"];
	}

	public function updateDServerInfo(){
		$this->scheduler->scheduleAsyncTask(new DServerTask($this->dserverConfig["serverList"], $this->dserverConfig["retryTimes"]));
	}

	public function getBuild(){
		return $this->version->getBuild();
	}

	public function getGameVersion(){
		return $this->version->getRelease();
	}

	/**
	 * @param \ClassLoader    $autoloader
	 * @param \ThreadedLogger $logger
	 * @param string          $filePath
	 * @param string          $dataPath
	 * @param string          $pluginPath
	 * @param string          $defaultLang
	 */
	public function __construct(\ClassLoader $autoloader, \ThreadedLogger $logger, $filePath, $dataPath, $pluginPath, $defaultLang = "unknown"){
		self::$instance = $this;
		self::$sleeper = new \Threaded;
		$this->autoloader = $autoloader;
		$this->logger = $logger;
		$this->filePath = $filePath;
		try{
			if(!file_exists($dataPath . "worlds/")){
				mkdir($dataPath . "worlds/", 0777);
			}

			if(!file_exists($dataPath . "players/")){
				mkdir($dataPath . "players/", 0777);
			}

			if(!file_exists($pluginPath)){
				mkdir($pluginPath, 0777);
			}

			if(!file_exists($dataPath . "crashdumps/")){
				mkdir($dataPath . "crashdumps/", 0777);
			}
			
			if(\Phar::running(true) === ""){
			   $packages = "src";
			} else {
				$packages = "phar";
			}

			$this->dataPath = realpath($dataPath) . DIRECTORY_SEPARATOR;
			$this->pluginPath = realpath($pluginPath) . DIRECTORY_SEPARATOR;

			if(!file_exists($this->dataPath . "pocketmine.yml")){
				$content = file_get_contents($this->filePath . "src/pocketmine/resources/pocketmine.yml");
				@file_put_contents($this->dataPath . "pocketmine.yml", $content);
			}
			$this->config = new Config($configPath = $this->dataPath . "pocketmine.yml", Config::YAML, []);
			$this->console = new CommandReader($logger);

			$version = $this->getFormattedVersion();
			$this->version = $version;
			$code = $this->getCodename();
			$mcpe = $this->getVersion();
			$protocol = Info::CURRENT_PROTOCOL;
			$api = $this->getApiVersion();
			$ip = Utils::getIP();
			$port = "19132";//TODO
			$ssl = $this->isExtensionInstalled("OpenSSL");
			$mode = $this->checkAuthentication();
			$lang = $this->getProperty("settings.language", "eng");
			$date = date("D, F d, Y, H:i T");
			$package = $packages;

			            $this->logger->info("
§e###################################################  §6-- Loaded: Properties and Configuration --
§e#                                                 #    §cDate: §d$date
§e#§b   _______                                _      §e#    §cVersion: §d$version §cCodename: §d$code
§e#§b  |__   __|                              | |     §e#    §cMCPE: §d$mcpe
§e#§b     | | ___  ___ ___  ___ _ __ __ _  ___| |_    §e#    §cIP: §d$ip §cPort: §d$port
§e#§b     | |/ _ \/ __/ __|/ _ \ '__/ _` |/ __| __|   §e#    §cProtocol: §d$protocol
§e#§b     | |  __/\__ \__ \  __/ | | (_| | (__| |_    §e#    §cSSL Extension: §d$ssl
§e#§b     |_|\___||___/___/\___|_|  \__,_|\___|\__|   §e#    §cAuthentication: §d$mode
§e#                                                 #  §6------------------------------------------
§e#                                                 #    §cAPI Version: §d$api
§e#     §bwww.github.com/TesseractTeam/Tesseract      §e#    §cLanguage: §d$lang
§e#					          #    §cPackage: §d$package
§e###################################################  §6------------------------------------------");


			$nowLang = $this->getProperty("settings.language", "eng");

			//Crashes unsupported builds without the correct configuration
			if(strpos(\pocketmine\VERSION, "unsupported") !== false and getenv("GITLAB_CI") === false){
				if($this->getProperty("settings.enable-testing", false) !== true){
					throw new ServerException("This build is not intended for production use. You may set 'settings.enable-testing: true' under pocketmine.yml to allow use of non-production builds. Do so at your own risk and ONLY if you know what you are doing.");
				}else{
					$this->logger->warning("You are using an unsupported build. Do not use this build in a production environment.");
				}
			}
			if($defaultLang != "unknown" and $nowLang != $defaultLang){
				@file_put_contents($configPath, str_replace('language: "' . $nowLang . '"', 'language: "' . $defaultLang . '"', file_get_contents($configPath)));
				$this->config->reload();
				unset($this->propertyCache["settings.language"]);
			}

			$lang = $this->getProperty("settings.language", BaseLang::FALLBACK_LANGUAGE);
			if(file_exists($this->filePath . "src/pocketmine/resources/tesseract_$lang.yml")){
				$content = file_get_contents($file = $this->filePath . "src/pocketmine/resources/tesseract_$lang.yml");
			}else{
				$content = file_get_contents($file = $this->filePath . "src/pocketmine/resources/tesseract_eng.yml");
			}

			if(!file_exists($this->dataPath . "tesseract.yml")){
				@file_put_contents($this->dataPath . "tesseract.yml", $content);
			}
			$internelConfig = new Config($file, Config::YAML, []);
			$this->advancedConfig = new Config($this->dataPath . "tesseract.yml", Config::YAML, []);
			$cfgVer = $this->getAdvancedProperty("config.version", 0, $internelConfig);
			$advVer = $this->getAdvancedProperty("config.version", 0);

			$this->loadAdvancedConfig();

			$this->properties = new Config($this->dataPath . "server.properties", Config::PROPERTIES, [
				"motd" => "Minecraft: PE Server",
				"server-port" => 19132,
				"white-list" => false,
				"announce-player-achievements" => true,
				"spawn-protection" => 16,
				"max-players" => 20,
				"allow-flight" => false,
				"spawn-animals" => true,
				"spawn-mobs" => true,
				"gamemode" => 0,
				"force-gamemode" => false,
				"hardcore" => false,
				"pvp" => true,
				"difficulty" => 1,
				"generator-settings" => "",
				"level-name" => "world",
				"level-seed" => "",
				"level-type" => "DEFAULT",
				"enable-query" => true,
				"enable-rcon" => false,
				"rcon.password" => substr(base64_encode(random_bytes(20)), 3, 10),
				"auto-save" => true,
				"online-mode" => false,
			]);


			$this->forceLanguage = $this->getProperty("settings.force-language", false);
			$this->baseLang = new BaseLang($this->getProperty("settings.language", BaseLang::FALLBACK_LANGUAGE));

			$this->memoryManager = new MemoryManager($this);

			if(($poolSize = $this->getProperty("settings.async-workers", "auto")) === "auto"){
				$poolSize = ServerScheduler::$WORKERS;
				$processors = Utils::getCoreCount() - 2;

				if($processors > 0){
					$poolSize = max(1, $processors);
				}
			}

			ServerScheduler::$WORKERS = $poolSize;

			if($this->getProperty("network.batch-threshold", 256) >= 0){
				Network::$BATCH_THRESHOLD = (int) $this->getProperty("network.batch-threshold", 256);
			}else{
				Network::$BATCH_THRESHOLD = -1;
			}
			$this->networkCompressionLevel = $this->getProperty("network.compression-level", 7);
			$this->networkCompressionAsync = $this->getProperty("network.async-compression", true);

			$this->autoTickRate = (bool) $this->getProperty("level-settings.auto-tick-rate", true);
			$this->autoTickRateLimit = (int) $this->getProperty("level-settings.auto-tick-rate-limit", 20);
			$this->alwaysTickPlayers = (int) $this->getProperty("level-settings.always-tick-players", false);
			$this->baseTickRate = (int) $this->getProperty("level-settings.base-tick-rate", 1);

			$this->scheduler = new ServerScheduler();

			if($this->getConfigBoolean("enable-rcon", false) === true){
				$this->rcon = new RCON($this, $this->getConfigString("rcon.password", ""), $this->getConfigInt("rcon.port", $this->getPort()), ($ip = $this->getIp()) != "" ? $ip : "0.0.0.0", $this->getConfigInt("rcon.threads", 1), $this->getConfigInt("rcon.clients-per-thread", 50));
			}

			$this->entityMetadata = new EntityMetadataStore();
			$this->playerMetadata = new PlayerMetadataStore();
			$this->levelMetadata = new LevelMetadataStore();

			$this->operators = new Config($this->dataPath . "ops.txt", Config::ENUM);
			$this->whitelist = new Config($this->dataPath . "white-list.txt", Config::ENUM);
			if(file_exists($this->dataPath . "banned.txt") and !file_exists($this->dataPath . "banned-players.txt")){
				@rename($this->dataPath . "banned.txt", $this->dataPath . "banned-players.txt");
			}
			@touch($this->dataPath . "banned-players.txt");
			$this->banByName = new BanList($this->dataPath . "banned-players.txt");
			$this->banByName->load();
			@touch($this->dataPath . "banned-ips.txt");
			$this->banByIP = new BanList($this->dataPath . "banned-ips.txt");
			$this->banByIP->load();
			@touch($this->dataPath . "banned-cids.txt");
			$this->banByCID = new BanList($this->dataPath . "banned-cids.txt");
			$this->banByCID->load();

			$this->maxPlayers = $this->getConfigInt("max-players", 20);
			$this->setAutoSave($this->getConfigBoolean("auto-save", true));

			if($this->getConfigBoolean("hardcore", false) === true and $this->getDifficulty() < 3){
				$this->setConfigInt("difficulty", 3);
			}

			define("pocketmine\\DEBUG", (int) $this->getProperty("debug.level", 1));
			if($this->logger instanceof MainLogger){
				$this->logger->setLogDebug(\pocketmine\DEBUG > 1);
			}

			if(\pocketmine\DEBUG >= 0){
				@cli_set_process_title($this->getName() . " " . $this->getPocketMineVersion());
			}

			$this->logger->info(TextFormat::BLUE."Everything seems to be alright. Server started!");
			$this->serverID = Utils::getMachineUniqueId($this->getIp() . $this->getPort());

			$this->getLogger()->debug("Server unique id: " . $this->getServerUniqueId());
			$this->getLogger()->debug("Machine unique id: " . Utils::getMachineUniqueId());

			$this->network = new Network($this);
			$this->network->setName($this->getMotd());


			Timings::init();

			$this->consoleSender = new ConsoleCommandSender();
			$this->commandMap = new SimpleCommandMap($this);

			Entity::init();
			Tile::init();
			InventoryType::init();
			Block::init();
			Enchantment::init();
			Item::init();
			Biome::init();
			Effect::init();
			Attribute::init();
			EnchantmentLevelTable::init();
			Color::init();
			$this->craftingManager = new CraftingManager();

			$this->pluginManager = new PluginManager($this, $this->commandMap);
			$this->pluginManager->subscribeToPermission(Server::BROADCAST_CHANNEL_ADMINISTRATIVE, $this->consoleSender);
			$this->pluginManager->setUseTimings($this->getProperty("settings.enable-profiling", false));
			$this->profilingTickRate = (float) $this->getProperty("settings.profile-report-trigger", 20);
			$this->pluginManager->registerInterface(PharPluginLoader::class);
			$this->pluginManager->registerInterface(FolderPluginLoader::class);
			$this->pluginManager->registerInterface(ScriptPluginLoader::class);

			//set_exception_handler([$this, "exceptionHandler"]);
			register_shutdown_function([$this, "crashDump"]);

			$this->queryRegenerateTask = new QueryRegenerateEvent($this, 5);
			
			$this->pluginManager->loadPlugins($this->pluginPath);

			$this->enablePlugins(PluginLoadOrder::STARTUP);
			
			if($this->getAdvancedProperty("network.raklib-disable") === false){
			$this->network->registerInterface(new RakLibInterface($this));
			} else {
				$this->logger->notice("Raklib disabled by tesseract.yml!");
			}

			LevelProviderManager::addProvider(Anvil::class);
			LevelProviderManager::addProvider(PMAnvil::class);
			LevelProviderManager::addProvider(McRegion::class);


			Generator::addGenerator(Flat::class, "flat");
			Generator::addGenerator(Normal::class, "normal");
			Generator::addGenerator(Normal::class, "default");
			Generator::addGenerator(Nether::class, "hell");
			Generator::addGenerator(Nether::class, "nether");
			//TODO Generator::addGenerator(Ender::class, "ender");

			foreach((array) $this->getProperty("worlds", []) as $name => $worldSetting){
				if($this->loadLevel($name) === false){
					$seed = $this->getProperty("worlds.$name.seed", time());
					$options = explode(":", $this->getProperty("worlds.$name.generator", Generator::getGenerator("default")));
					$generator = Generator::getGenerator(array_shift($options));
					if(count($options) > 0){
						$options = [
							"preset" => implode(":", $options),
						];
					}else{
						$options = [];
					}

					$this->generateLevel($name, $seed, $generator, $options);
				}
			}

			if($this->getDefaultLevel() === null){
				$default = $this->getConfigString("level-name", "world");
				if(trim($default) == ""){
					$this->getLogger()->warning("level-name cannot be null, using default");
					$default = "world";
					$this->setConfigString("level-name", "world");
				}
				if($this->loadLevel($default) === false){
					$seed = getopt("", ["level-seed::"])["level-seed"] ?? $this->properties->get("level-seed", time());
					if(!is_numeric($seed) or bccomp($seed, "9223372036854775807") > 0){
						$seed = Utils::javaStringHash($seed);
					}elseif(PHP_INT_SIZE === 8){
						$seed = (int) $seed;
					}
					$this->generateLevel($default, $seed === 0 ? time() : $seed);
				}

				$this->setDefaultLevel($this->getLevelByName($default));
			}


			$this->properties->save(true);

			if(!($this->getDefaultLevel() instanceof Level)){
				$this->getLogger()->emergency($this->getLanguage()->translateString("pocketmine.level.defaultError"));
				$this->forceShutdown();

				return;
			}

			if($this->getProperty("ticks-per.autosave", 6000) > 0){
				$this->autoSaveTicks = (int) $this->getProperty("ticks-per.autosave", 6000);
			}

			$this->enablePlugins(PluginLoadOrder::POSTWORLD);

			if($cfgVer > $advVer){
				$this->logger->notice("Your tesseract.yml needs update (Current : $advVer -> Latest: $cfgVer)");
			}

			$this->start();
		}catch(\Throwable $e){
			$this->exceptionHandler($e);
		}
	}

	public function getOnlineMode(){
		
		return $this->getConfigBoolean("online-mode", false);
					
	}
	
	public function isExtensionInstalled($type){
		switch($type){
			
			case 'OpenSSL':
			if(!extension_loaded("openssl")){
				return "false";
				$this->setConfigBool("online-mode", false);
				
			} else {
				return "true";
			break;
		}
		    case '$type';
			if(!extension_loaded($type)){
				return "false";
				
			} else {
				return "true";
			}
	}
	}
	
	public function checkAuthentication(){
	   if($this->isExtensionInstalled("OpenSSL") == "false"){
		   return "offline mode/insecure";
		   
	   } else {
		   return "online mode/secure";
	   }
	}

	/**
	 * @param string        $message
	 * @param Player[]|null $recipients
	 *
	 * @return int
	 */
	public function broadcastMessage($message, $recipients = null) : int{
		if(!is_array($recipients)){
			return $this->broadcast($message, self::BROADCAST_CHANNEL_USERS);
		}

		/** @var Player[] $recipients */
		foreach($recipients as $recipient){
			$recipient->sendMessage($message);
		}

		return count($recipients);
	}

	/**
	 * @param string        $tip
	 * @param Player[]|null $recipients
	 *
	 * @return int
	 */
	public function broadcastTip(string $tip, $recipients = null) : int{
		if(!is_array($recipients)){
			/** @var Player[] $recipients */
			$recipients = [];

			foreach($this->pluginManager->getPermissionSubscriptions(self::BROADCAST_CHANNEL_USERS) as $permissible){
				if($permissible instanceof Player and $permissible->hasPermission(self::BROADCAST_CHANNEL_USERS)){
					$recipients[spl_object_hash($permissible)] = $permissible; // do not send messages directly, or some might be repeated
				}
			}
		}

		/** @var Player[] $recipients */
		foreach($recipients as $recipient){
			$recipient->sendTip($tip);
		}

		return count($recipients);
	}

	/**
	 * @param string        $popup
	 * @param Player[]|null $recipients
	 *
	 * @return int
	 */
	public function broadcastPopup(string $popup, $recipients = null) : int{
		if(!is_array($recipients)){
			/** @var Player[] $recipients */
			$recipients = [];

			foreach($this->pluginManager->getPermissionSubscriptions(self::BROADCAST_CHANNEL_USERS) as $permissible){
				if($permissible instanceof Player and $permissible->hasPermission(self::BROADCAST_CHANNEL_USERS)){
					$recipients[spl_object_hash($permissible)] = $permissible; // do not send messages directly, or some might be repeated
				}
			}
		}

		/** @var Player[] $recipients */
		foreach($recipients as $recipient){
			$recipient->sendPopup($popup);
		}

		return count($recipients);
	}

	/**
	 * @param string $message
	 * @param string $permissions
	 *
	 * @return int
	 */
	public function broadcast($message, string $permissions) : int{
		/** @var CommandSender[] $recipients */
		$recipients = [];
		foreach(explode(";", $permissions) as $permission){
			foreach($this->pluginManager->getPermissionSubscriptions($permission) as $permissible){
				if($permissible instanceof CommandSender and $permissible->hasPermission($permission)){
					$recipients[spl_object_hash($permissible)] = $permissible; // do not send messages directly, or some might be repeated
				}
			}
		}

		foreach($recipients as $recipient){
			$recipient->sendMessage($message);
		}

		return count($recipients);
	}

	/**
	 * Broadcasts a Minecraft packet to a list of players
	 *
	 * @param Player[]   $players
	 * @param DataPacket $packet
	 */
	public function broadcastPacket(array $players, DataPacket $packet){
		$packet->encode();
		$packet->isEncoded = true;
		if(Network::$BATCH_THRESHOLD >= 0 and strlen($packet->buffer) >= Network::$BATCH_THRESHOLD){
			$this->batchPackets($players, [$packet->buffer], false);
			return;
		}

		foreach($players as $player){
			$player->dataPacket($packet);
		}
		if(isset($packet->__encapsulatedPacket)){
			unset($packet->__encapsulatedPacket);
		}
	}

	/**
	 * Broadcasts a list of packets in a batch to a list of players
	 *
	 * @param Player[]            $players
	 * @param DataPacket[]|string $packets
	 * @param bool                $forceSync
	 */
	public function batchPackets(array $players, array $packets, $forceSync = false){
		Timings::$playerNetworkTimer->startTiming();
		$str = "";

		foreach($packets as $p){
			if($p instanceof DataPacket){
				if(!$p->isEncoded){
					$p->encode();
				}
				$str .= Binary::writeUnsignedVarInt(strlen($p->buffer)) . $p->buffer;
			}else{
				$str .= Binary::writeUnsignedVarInt(strlen($p)) . $p;
			}
		}

		$targets = [];
		foreach($players as $p){
			if($p->isConnected()){
				$targets[] = $this->identifiers[spl_object_hash($p)];
			}
		}

		if(!$forceSync and $this->networkCompressionAsync){
			$task = new CompressBatchedTask($str, $targets, $this->networkCompressionLevel);
			$this->getScheduler()->scheduleAsyncTask($task);
		}else{
			$this->broadcastPacketsCallback(zlib_encode($str, ZLIB_ENCODING_DEFLATE, $this->networkCompressionLevel), $targets);
		}

		Timings::$playerNetworkTimer->stopTiming();
	}

	public function broadcastPacketsCallback($data, array $identifiers){
		$pk = new BatchPacket();
		$pk->payload = $data;
		$pk->encode();
		$pk->isEncoded = true;

		foreach($identifiers as $i){
			if(isset($this->players[$i])){
				$this->players[$i]->dataPacket($pk);
			}
		}
	}


	/**
	 * @param int $type
	 */
	public function enablePlugins(int $type){
		foreach($this->pluginManager->getPlugins() as $plugin){
			if(!$plugin->isEnabled() and $plugin->getDescription()->getOrder() === $type){
				$this->enablePlugin($plugin);
			}
		}

		if($type === PluginLoadOrder::POSTWORLD){
			$this->commandMap->registerServerAliases();
			DefaultPermissions::registerCorePermissions();
		}
	}

	/**
	 * @param Plugin $plugin
	 */
	public function enablePlugin(Plugin $plugin){
		$this->pluginManager->enablePlugin($plugin);
	}

	public function disablePlugins(){
		$this->pluginManager->disablePlugins();
	}

	public function checkConsole(){
		Timings::$serverCommandTimer->startTiming();
		if(($line = $this->console->getLine()) !== null){
			$this->pluginManager->callEvent($ev = new ServerCommandEvent($this->consoleSender, $line));
			if(!$ev->isCancelled()){
				$this->dispatchCommand($ev->getSender(), $ev->getCommand());
			}
		}
		Timings::$serverCommandTimer->stopTiming();
	}

	/**
	 * Executes a command from a CommandSender
	 *
	 * @param CommandSender $sender
	 * @param string        $commandLine
	 *
	 * @return bool
	 *
	 */
	public function dispatchCommand(CommandSender $sender, $commandLine){
		if($this->commandMap->dispatch($sender, $commandLine)){
			return true;
		}


		$sender->sendMessage(new TranslationContainer(TextFormat::GOLD . "%commands.generic.notFound"));

		return false;
	}

	public function reload(){
		$this->logger->info("Saving levels...");

		foreach($this->levels as $level){
			$level->save();
		}

		$this->pluginManager->disablePlugins();
		$this->pluginManager->clearPlugins();
		$this->commandMap->clearCommands();

		$this->logger->info("Reloading properties...");
		$this->properties->reload();
		$this->advancedConfig->reload();
		$this->loadAdvancedConfig();
		$this->maxPlayers = $this->getConfigInt("max-players", 20);

		if($this->getConfigBoolean("hardcore", false) === true and $this->getDifficulty() < 3){
			$this->setConfigInt("difficulty", 3);
		}

		$this->banByIP->load();
		$this->banByName->load();
		$this->banByCID->load();
		$this->reloadWhitelist();
		$this->operators->reload();

		$this->memoryManager->doObjectCleanup();

		foreach($this->getIPBans()->getEntries() as $entry){
			$this->getNetwork()->blockAddress($entry->getName(), -1);
		}

		$this->pluginManager->registerInterface(PharPluginLoader::class);
		$this->pluginManager->registerInterface(FolderPluginLoader::class);
		$this->pluginManager->registerInterface(ScriptPluginLoader::class);
		$this->pluginManager->loadPlugins($this->pluginPath);
		$this->enablePlugins(PluginLoadOrder::STARTUP);
		$this->enablePlugins(PluginLoadOrder::POSTWORLD);
		TimingsHandler::reload();
	}

	/**
	 * Shutdowns the server correctly
	 * @param bool   $restart
	 * @param string $msg
	 */
	public function shutdown(bool $restart = false, string $msg = ""){
		/*if($this->isRunning){
			$killer = new ServerKiller(90);
			$killer->start();
			$killer->kill();
		}*/
		
		$this->getPluginManager()->callEvent($ev = new event\server\ServerShutdownEvent());
 		if($ev->isCancelled(true)) return;
		
		$this->isRunning = false;
		if($msg != ""){
			$this->propertyCache["settings.shutdown-message"] = $msg;
		}
	}

	public function forceShutdown(){
		if($this->hasStopped){
			return;
		}

		try{
			if(!$this->isRunning()){
				$this->sendUsage(SendUsageTask::TYPE_CLOSE);
			}

			$this->hasStopped = true;

			$this->shutdown();
			if($this->rcon instanceof RCON){
				$this->rcon->stop();
			}

			if($this->getProperty("network.upnp-forwarding", false) === true){
				$this->logger->info("[UPnP] Removing port forward...");
				UPnP::RemovePortForward($this->getPort());
			}

			$this->getLogger()->debug("Disabling all plugins");
			$this->pluginManager->disablePlugins();

			foreach($this->players as $player){
				$player->close($player->getLeaveMessage(), $this->getProperty("settings.shutdown-message", "Server closed"));
			}

			$this->getLogger()->debug("Unloading all levels");
			foreach($this->getLevels() as $level){
				$this->unloadLevel($level, true);
			}

			$this->getLogger()->debug("Removing event handlers");
			HandlerList::unregisterAll();

			$this->getLogger()->debug("Stopping all tasks");
			$this->scheduler->cancelAllTasks();
			$this->scheduler->mainThreadHeartbeat(PHP_INT_MAX);

			$this->getLogger()->debug("Saving properties");
			$this->properties->save();

			$this->getLogger()->debug("Closing console");
			$this->console->shutdown();
			$this->console->notify();

			$this->getLogger()->debug("Stopping network interfaces");
			foreach($this->network->getInterfaces() as $interface){
				$interface->shutdown();
				$this->network->unregisterInterface($interface);
			}
 			
			//$this->memoryManager->doObjectCleanup();

			gc_collect_cycles();
		}catch(\Throwable $e){
			$this->logger->logException($e);
			$this->logger->emergency("Crashed while crashing, killing process");
			@kill(getmypid());
		}

	}

	public function getQueryInformation(){
		return $this->queryRegenerateTask;
	}

	/**
	 * Starts the PocketMine-MP server and starts processing ticks and packets
	 */
	public function start(){
		if($this->getConfigBoolean("enable-query", true) === true){
			$this->queryHandler = new QueryHandler();
		}

		foreach($this->getIPBans()->getEntries() as $entry){
			$this->network->blockAddress($entry->getName(), -1);
		}

		if($this->getProperty("settings.send-usage", true)){
			$this->sendUsageTicker = 6000;
			$this->sendUsage(SendUsageTask::TYPE_OPEN);
		}


		if($this->getProperty("network.upnp-forwarding", false) == true){
			$this->logger->info("[UPnP] Trying to port forward...");
			UPnP::PortForward($this->getPort());
		}

		$this->tickCounter = 0;

		if(function_exists("pcntl_signal")){
			pcntl_signal(SIGTERM, [$this, "handleSignal"]);
			pcntl_signal(SIGINT, [$this, "handleSignal"]);
			pcntl_signal(SIGHUP, [$this, "handleSignal"]);
			$this->dispatchSignals = true;
		}

		$this->logger->info($this->getLanguage()->translateString("pocketmine.server.defaultGameMode", [self::getGamemodeString($this->getGamemode())]));

		$this->logger->info($this->getLanguage()->translateString("pocketmine.server.startFinished", [round(microtime(true) - \pocketmine\START_TIME, 3)]));

		$this->tickProcessor();
		$this->forceShutdown();

		gc_collect_cycles();
	}

	public function handleSignal($signo){
		if($signo === SIGTERM or $signo === SIGINT or $signo === SIGHUP){
			$this->shutdown();
		}
	}

	public function exceptionHandler(\Throwable $e, $trace = null){
		if($e === null){
			return;
		}

		global $lastError;

		if($trace === null){
			$trace = $e->getTrace();
		}

		$errstr = $e->getMessage();
		$errfile = $e->getFile();
		$errno = $e->getCode();
		$errline = $e->getLine();

		$type = ($errno === E_ERROR or $errno === E_USER_ERROR) ? \LogLevel::ERROR : (($errno === E_USER_WARNING or $errno === E_WARNING) ? \LogLevel::WARNING : \LogLevel::NOTICE);
		if(($pos = strpos($errstr, "\n")) !== false){
			$errstr = substr($errstr, 0, $pos);
		}

		$errfile = cleanPath($errfile);

		if($this->logger instanceof MainLogger){
			$this->logger->logException($e, $trace);
		}

		$lastError = [
			"type" => $type,
			"message" => $errstr,
			"fullFile" => $e->getFile(),
			"file" => $errfile,
			"line" => $errline,
			"trace" => @getTrace(1, $trace)
		];

		global $lastExceptionError, $lastError;
		$lastExceptionError = $lastError;
		$this->crashDump();
	}

	public function crashDump(){
		if($this->isRunning === false){
			return;
		}
		if($this->sendUsageTicker > 0){
			$this->sendUsage(SendUsageTask::TYPE_CLOSE);
		}
		$this->hasStopped = false;

		ini_set("error_reporting", 0);
		ini_set("memory_limit", -1); //Fix error dump not dumped on memory problems
		$this->logger->emergency($this->getLanguage()->translateString("pocketmine.crash.create"));
		try{
			$dump = new CrashDump($this);
		}catch(\Throwable $e){
			$this->logger->critical($this->getLanguage()->translateString("pocketmine.crash.error", $e->getMessage()));
			return;
		}

		$this->logger->emergency($this->getLanguage()->translateString("pocketmine.crash.submit", [$dump->getPath()]));

		//$this->checkMemory();
		//$dump .= "Memory Usage Tracking: \r\n" . chunk_split(base64_encode(gzdeflate(implode(";", $this->memoryStats), 9))) . "\r\n";

		$this->forceShutdown();
		$this->isRunning = false;
		@kill(getmypid());
		exit(1);
	}

	public function __debugInfo(){
		return [];
	}

	private function tickProcessor(){
		$this->nextTick = microtime(true);
		while($this->isRunning){
			$this->tick();
			$next = $this->nextTick - 0.0001;
			if($next > microtime(true)){
				@time_sleep_until($next);
			}
		}
	}

	public function onPlayerLogin(Player $player){
		if($this->sendUsageTicker > 0){
			$this->uniquePlayers[$player->getRawUniqueId()] = $player->getRawUniqueId();
		}

		$this->sendFullPlayerListData($player);
        $player->dataPacket($this->craftingManager->getCraftingDataPacket());
	}

	public function addPlayer($identifier, Player $player){
		$this->players[$identifier] = $player;
		$this->identifiers[spl_object_hash($player)] = $identifier;
	}

	public function addOnlinePlayer(Player $player){
		$this->playerList[$player->getRawUniqueId()] = $player;

		$this->updatePlayerListData($player->getUniqueId(), $player->getId(), $player->getDisplayName(), $player->getSkinId(), $player->getSkinData());
	}

	public function removeOnlinePlayer(Player $player){
		if(isset($this->playerList[$player->getRawUniqueId()])){
			unset($this->playerList[$player->getRawUniqueId()]);

			$pk = new PlayerListPacket();
			$pk->type = PlayerListPacket::TYPE_REMOVE;
			$pk->entries[] = [$player->getUniqueId()];
			$this->broadcastPacket($this->playerList, $pk);
		}
	}

	public function updatePlayerListData(UUID $uuid, $entityId, $name, $skinId, $skinData, array $players = null){
		$pk = new PlayerListPacket();
		$pk->type = PlayerListPacket::TYPE_ADD;
		$pk->entries[] = [$uuid, $entityId, $name, $skinId, $skinData];
		$this->broadcastPacket($players === null ? $this->playerList : $players, $pk);
	}

	public function removePlayerListData(UUID $uuid, array $players = null){
		$pk = new PlayerListPacket();
		$pk->type = PlayerListPacket::TYPE_REMOVE;
		$pk->entries[] = [$uuid];
		$this->broadcastPacket($players === null ? $this->playerList : $players, $pk);
	}

	public function sendFullPlayerListData(Player $p){
		$pk = new PlayerListPacket();
		$pk->type = PlayerListPacket::TYPE_ADD;
		foreach($this->playerList as $player){
			if($p === $player){
				continue; //fixes duplicates
			}
			$pk->entries[] = [$player->getUniqueId(), $player->getId(), $player->getDisplayName(), $player->getSkinId(), $player->getSkinData()];
		}

		$p->dataPacket($pk);
	}

	private function checkTickUpdates($currentTick, $tickTime){
		foreach($this->players as $p){
			if(!$p->loggedIn and ($tickTime - $p->creationTime) >= 10){
				$p->close("", "Login timeout");
			}elseif($this->alwaysTickPlayers){
				$p->onUpdate($currentTick);
			}
		}

		//Do level ticks
		foreach($this->getLevels() as $level){
			if($level->getTickRate() > $this->baseTickRate and --$level->tickRateCounter > 0){
				continue;
			}
			try{
				$levelTime = microtime(true);
				$level->doTick($currentTick);
				$tickMs = (microtime(true) - $levelTime) * 1000;
				$level->tickRateTime = $tickMs;

				if($this->autoTickRate){
					if($tickMs < 50 and $level->getTickRate() > $this->baseTickRate){
						$level->setTickRate($r = $level->getTickRate() - 1);
						if($r > $this->baseTickRate){
							$level->tickRateCounter = $level->getTickRate();
						}
						$this->getLogger()->debug("Raising level \"" . $level->getName() . "\" tick rate to " . $level->getTickRate() . " ticks");
					}elseif($tickMs >= 50){
						if($level->getTickRate() === $this->baseTickRate){
							$level->setTickRate(max($this->baseTickRate + 1, min($this->autoTickRateLimit, floor($tickMs / 50))));
							$this->getLogger()->debug("Level \"" . $level->getName() . "\" took " . round($tickMs, 2) . "ms, setting tick rate to " . $level->getTickRate() . " ticks");
						}elseif(($tickMs / $level->getTickRate()) >= 50 and $level->getTickRate() < $this->autoTickRateLimit){
							$level->setTickRate($level->getTickRate() + 1);
							$this->getLogger()->debug("Level \"" . $level->getName() . "\" took " . round($tickMs, 2) . "ms, setting tick rate to " . $level->getTickRate() . " ticks");
						}
						$level->tickRateCounter = $level->getTickRate();
					}
				}
			}catch(\Throwable $e){
				$this->logger->critical($this->getLanguage()->translateString("pocketmine.level.tickError", [$level->getName(), $e->getMessage()]));
				if(\pocketmine\DEBUG > 1 and $this->logger instanceof MainLogger){
					$this->logger->logException($e);
				}
			}
		}
	}

	public function doAutoSave(){
		if($this->getAutoSave()){
			Timings::$worldSaveTimer->startTiming();
			foreach($this->players as $index => $player){
				if($player->isOnline()){
					$player->save(true);
				}elseif(!$player->isConnected()){
					$this->removePlayer($player);
				}
			}

			foreach($this->getLevels() as $level){
				$level->save(false);
			}
			Timings::$worldSaveTimer->stopTiming();
		}
	}

	public function sendUsage($type = SendUsageTask::TYPE_STATUS){
		$this->scheduler->scheduleAsyncTask(new SendUsageTask($this, $type, $this->uniquePlayers));
		$this->uniquePlayers = [];
	}


	/**
	 * @return BaseLang
	 */
	public function getLanguage(){
		return $this->baseLang;
	}

	/**
	 * @return bool
	 */
	public function isLanguageForced(){
		return $this->forceLanguage;
	}

	/**
	 * @return Network
	 */
	public function getNetwork(){
		return $this->network;
	}

	/**
	 * @return MemoryManager
	 */
	
	public function getMemoryManager(){
		return $this->memoryManager;
	}

	private function titleTick(){
		if(!Terminal::hasFormattingCodes()){
			return;
		}

		$d = Utils::getRealMemoryUsage();

		$u = Utils::getMemoryUsage(true);
		$usage = round(($u[0] / 1024) / 1024, 2) . "/" . round(($d[0] / 1024) / 1024, 2) . "/" . round(($u[1] / 1024) / 1024, 2) . "/" . round(($u[2] / 1024) / 1024, 2) . " MB @ " . Utils::getThreadCount() . " threads";

		echo "\x1b]0;" . $this->getName() . $this->getFormattedVersion(" ") .
			" | Online " . count($this->players) . "/" . $this->getMaxPlayers() .
			" | Memory " . $usage .
			" | U " . round($this->network->getUpload() / 1024, 2) .
			" D " . round($this->network->getDownload() / 1024, 2) .
			" kB/s | TPS " . $this->getTicksPerSecondAverage() .
			" | Load " . $this->getTickUsageAverage() . "%\x07";

		$this->network->resetStatistics();
	}

	/**
	 * @param string $address
	 * @param int    $port
	 * @param string $payload
	 *
	 * TODO: move this to Network
	 */
	public function handlePacket($address, $port, $payload){
		try{
			if(strlen($payload) > 2 and substr($payload, 0, 2) === "\xfe\xfd" and $this->queryHandler instanceof QueryHandler){
				$this->queryHandler->handle($address, $port, $payload);
			}
		}catch(\Throwable $e){
			if(\pocketmine\DEBUG > 1){
				if($this->logger instanceof MainLogger){
					$this->logger->logException($e);
				}
			}

			$this->getNetwork()->blockAddress($address, 600);
		}
		//TODO: add raw packet events
	}

	/**
	 * @param             $variable
	 * @param null        $defaultValue
	 * @param Config|null $cfg
	 * @return bool|mixed|null
	 */
	public function getAdvancedProperty($variable, $defaultValue = null, Config $cfg = null){
		$vars = explode(".", $variable);
		$base = array_shift($vars);
		if($cfg == null) $cfg = $this->advancedConfig;
		if($cfg->exists($base)){
			$base = $cfg->get($base);
		}else{
			return $defaultValue;
		}

		while(count($vars) > 0){
			$baseKey = array_shift($vars);
			if(is_array($base) and isset($base[$baseKey])){
				$base = $base[$baseKey];
			}else{
				return $defaultValue;
			}
		}

		return $base;
	}

	public function updateQuery(){
		try{
			$this->getPluginManager()->callEvent($this->queryRegenerateTask = new QueryRegenerateEvent($this, 5));
			if($this->queryHandler !== null){
				$this->queryHandler->regenerateInfo();
			}
		}catch(\Throwable $e){
			$this->logger->logException($e);
		}
	}


	/**
	 * Tries to execute a server tick
	 */
	private function tick(){
		$tickTime = microtime(true);
		if(($tickTime - $this->nextTick) < -0.025){ //Allow half a tick of diff
			return false;
		}

		Timings::$serverTickTimer->startTiming();

		++$this->tickCounter;

		$this->checkConsole();

		Timings::$connectionTimer->startTiming();
		$this->network->processInterfaces();
		
		if($this->rcon !== null){
			$this->rcon->check();
		}

		Timings::$connectionTimer->stopTiming();

		Timings::$schedulerTimer->startTiming();
		$this->scheduler->mainThreadHeartbeat($this->tickCounter);
		Timings::$schedulerTimer->stopTiming();

		$this->checkTickUpdates($this->tickCounter, $tickTime);

		foreach($this->players as $player){
			$player->checkNetwork();
		}

		if(($this->tickCounter & 0b1111) === 0){
			$this->titleTick();
			$this->currentTPS = 20;
			$this->currentUse = 0;

			if(($this->tickCounter & 0b111111111) === 0){
				if(($this->dserverConfig["enable"] and $this->dserverConfig["queryTickUpdate"]) or !$this->dserverConfig["enable"]){
					$this->updateQuery();
				}
			}

			$this->getNetwork()->updateName();
		}

		if($this->autoSave and ++$this->autoSaveTicker >= $this->autoSaveTicks){
			$this->autoSaveTicker = 0;
			$this->doAutoSave();
		}

		/*if($this->sendUsageTicker > 0 and --$this->sendUsageTicker === 0){
			$this->sendUsageTicker = 6000;
			$this->sendUsage(SendUsageTask::TYPE_STATUS);
		}*/

		if(($this->tickCounter % 100) === 0){
			foreach($this->levels as $level){
				$level->clearCache();
			}

			if($this->getTicksPerSecondAverage() < 1){
				$this->logger->warning($this->getLanguage()->translateString("pocketmine.server.tickOverload"));
			}
		}

		if($this->dispatchSignals and $this->tickCounter % 5 === 0){
			pcntl_signal_dispatch();
		}

		$this->getMemoryManager()->check();

		Timings::$serverTickTimer->stopTiming();

		$now = microtime(true);
		$this->currentTPS = min(20, 1 / max(0.001, $now - $tickTime));
		$this->currentUse = min(1, ($now - $tickTime) / 0.05);

		TimingsHandler::tick($this->currentTPS <= $this->profilingTickRate);

		array_shift($this->tickAverage);
		$this->tickAverage[] = $this->currentTPS;
		array_shift($this->useAverage);
		$this->useAverage[] = $this->currentUse;

		if(($this->nextTick - $tickTime) < -1){
			$this->nextTick = $tickTime;
		}else{
			$this->nextTick += 0.05;
		}

		return true;
	}
}
