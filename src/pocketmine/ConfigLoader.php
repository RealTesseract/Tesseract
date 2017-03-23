<?php

namespace pocketmine;

use pocketmine\utils\Config;

class ConfigLoader{
    /** Advanced Config */
    public $advancedConfig = null;

    public $weatherEnabled = true;
    public $foodEnabled = true;
    public $expEnabled = true;
    public $keepInventory = false;
    public $netherEnabled = false;
    public $netherName = "nether";
    public $weatherRandomDurationMin = 6000;
    public $weatherRandomDurationMax = 12000;
    public $lightningTime = 200;
    public $lightningFire = false;
    public $version;
    //public $playerMsgType = self::PLAYER_MSG_TYPE_MESSAGE;
    public $playerLoginMsg = "";
    public $playerLogoutMsg = "";
    public $autoClearInv = true;
    public $dserverConfig = [];
    public $dserverPlayers = 0;
    public $dserverAllPlayers = 0;
    public $anvilEnabled = false;
    public $asyncChunkRequest = true;
    public $keepExperience = false;
    public $limitedCreative = true;
    public $chunkRadius = -1;
    public $allowSplashPotion = true;
    public $fireSpread = false;
    public $advancedCommandSelector = false;
    public $enchantingTableEnabled = true;
    public $countBookshelf = false;
    public $allowInventoryCheats = false;
    public $raklibDisable = false;
    public $checkMovement = true;
    public $antiFly = true;
    public $allowInstabreak = false;
    public $folderpluginloader = false;

    public function getAdvancedConfig(){
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
        //$this->getLogger()->setWrite(!$this->getAdvancedProperty("server.disable-log", false));
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
        $this->folderpluginloader = $this->getAdvancedProperty("developer.folder-plugin-loader", false);
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
}