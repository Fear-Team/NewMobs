<?php

namespace FearTeam\NewMobs;

use FearTeam\NewMobs\Commands\NewMobsCommand;
use FearTeam\NewMobs\Entity\{Giraffe, Gorilla, Monkey};
use FearTeam\NewMobs\Listener\NewMobsEventListener;
use pocketmine\entity\Entity;
use pocketmine\plugin\PluginBase;
use pocketmine\utils\Config;

class Main extends PluginBase{

    /** @var Config */
    private $config;

    /** @var static */
    private static $instance;

    /** @var string[] */
    private static $mobsdata = ["Gorilla", "Monkey", "Giraffe"];

    public function onEnable(){
        $this->getServer()->getPluginManager()->registerEvents(new NewMobsEventListener($this), $this);
        $this->getServer()->getCommandMap()->register("newmobs", new NewMobsCommand($this));
        @mkdir($this->getDataFolder());
        @mkdir($this->getDataFolder() . "Mobs/Geometry/");
        @mkdir($this->getDataFolder() . "Mobs/Texture/");
        foreach (self::$mobsdata as $mobs){
            $this->saveResource("Mobs/Texture/{$mobs}.png");
            $this->saveResource("Mobs/Geometry/{$mobs}.json");
        }
        $this->saveResource("config.yml");
        $this->config = new Config($this->getDataFolder() . "config.yml", Config::YAML);

        Entity::registerEntity(Gorilla::class, true);
        Entity::registerEntity(Monkey::class, true);
        Entity::registerEntity(Giraffe::class, true);

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
     * @return Main
     */
    public static function getInstance(): Main{
        return self::$instance;
    }
}
