<?php

namespace FearTeam\NewMobs\Entity;

use FearTeam\NewMobs\Main;
use FearTeam\NewMobs\Utils\Utils;
use pocketmine\block\Block;
use pocketmine\entity\Entity;
use pocketmine\math\Vector3;
use pocketmine\nbt\tag\{IntTag, StringTag, CompoundTag, ByteArrayTag};

class EntityManager{

    /** @var Main */
    private $plugin;

    /**
     * EntityManager constructor.
     * @param Main $plugin
     */
    public function __construct(Main $plugin){
        $this->plugin = $plugin;
    }

    /**
     * @param Block $block
     * @param string $texture
     * @param string $name
     * @param string $geometry
     * @param string $geometry_file
     * @return CompoundTag
     */
    public function setMobSkin(Block $block, string $texture, string $name = "nebmobs", string $geometry, string $geometry_file){
        $path = $this->plugin->getServer()->getDataPath() . "plugin_data/NewMobs/Mobs/Texture/{$texture}.png";
        $skin = Utils::getSkinFromFile($path);
        $nbt = Entity::createBaseNBT(new Vector3($block->getX(), $block->getY() + 1, $block->getZ()));
        $nbt->setTag(new CompoundTag("Skin", [
            new StringTag("Data", $skin->getSkinData()),
            new StringTag("Name", $name),
            new StringTag("GeometryName", "geometry.{$geometry}"),
            new ByteArrayTag("GeometryData", file_get_contents($this->plugin->getDataFolder() . "Mobs/Geometry/{$geometry_file}.json"))
        ]));
        $nbt->setTag(new IntTag("position"));
        $nbt->setTag(new StringTag("player", "0"));

        return $nbt;
    }
}
