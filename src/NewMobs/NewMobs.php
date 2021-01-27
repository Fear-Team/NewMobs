<?php

namespace NewMobs;

use NewMobs\Commands\NewMobsCommand;
use NewMobs\Entity\Gorilla;
use NewMobs\Listener\NewMobsEventListener;
use pocketmine\entity\Entity;
use pocketmine\plugin\PluginBase;
use pocketmine\utils\Config;

class NewMobs extends PluginBase{

    /** @var Config */
    private $config;

    /** @var static */
    private static $instance;

    /** @var string[] */
    private static $mobsdata = ["Gorilla"];

    public function onEnable(){
        $this->getLogger()->info("Plugin Enable - ByAlperenS (Fear-Team)");
        $this->getLogger()->info("Team's Github: https://github.com/Fear-Team");
        $this->getLogger()->info("My Github: https://github.com/ByAlperenS");
        $this->getServer()->getPluginManager()->registerEvents(new NewMobsEventListener($this), $this);
        $this->getServer()->getCommandMap()->register("newmobs", new NewMobsCommand($this));
        @mkdir($this->getDataFolder());
        @mkdir($this->getDataFolder() . "Mobs/Geometry/");
        @mkdir($this->getDataFolder() . "Mobs/Texture/");
        $this->saveResource("Mobs/Texture/Gorilla.png");
        $this->saveResource("Mobs/Geometry/Gorilla.json");
        $this->saveResource("config.yml");
        $this->config = new Config($this->getDataFolder() . "config.yml", Config::YAML);
        // Gorilla
        Entity::registerEntity(Gorilla::class, true);

        if (!$this->config->get("Mobs")){
            $this->getLogger()->alert("Please do not delete the necessary parts in 'config.yml'");
            $this->getServer()->getPluginManager()->disablePlugin($this);
        }

        foreach (self::$mobsdata as $mobs){
            if (!$this->config->get($mobs)){
                $this->getLogger()->alert("Please do not delete the necessary parts in 'config.yml'");
                $this->getServer()->getPluginManager()->disablePlugin($this);
            }
        }
    }

    /**
     * @return Config
     */
    public function onSettings(){
        return $this->config;
    }

    /**
     * @return bool|mixed
     */
    public function onTitle(){
        return $this->config->get("Title");
    }

    /**
     * @return bool|mixed
     */
    public function onMobs(){
        return $this->config->get("Mobs");
    }

    public function onLoad(){
        self::$instance = $this;
    }

    /**
     * @return NewMobs
     */
    public static function getInstance(): NewMobs{
        return self::$instance;
    }
}
