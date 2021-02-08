<?php

namespace NewMobs\Entity;

use NewMobs\NewMobs;
use NewMobs\Utils\Utils;
use pocketmine\block\Block;
use pocketmine\entity\Entity;
use pocketmine\math\Vector3;
use pocketmine\nbt\tag\{IntTag, StringTag, CompoundTag, ByteArrayTag};

class EntityManager{

    /** @var NewMobs */
    private $plugin;

    /**
     * EntityManager constructor.
     * @param NewMobs $plugin
     */
    public function __construct(NewMobs $plugin){
        $this->plugin = $plugin;
    }

    /**
     * @param Block $block
     * @return CompoundTag
     */
    public function gorillaSkin(Block $block){
        $path = $this->plugin->getServer()->getDataPath() . "plugin_data/NewMobs/Mobs/Texture/Gorilla.png";
        $skin = Utils::getSkinFromFile($path);
        $nbt = Entity::createBaseNBT(new Vector3($block->getX(), $block->getY() + 1, $block->getZ()));
        $nbt->setTag(new CompoundTag("Skin", [
            new StringTag("Data", $skin->getSkinData()),
            new StringTag("Name", "newmobs"),
            new StringTag("GeometryName", "geometry.gorilla"),
            new ByteArrayTag("GeometryData", file_get_contents($this->plugin->getDataFolder() . "Mobs/Geometry/Gorilla.json"))
        ]));
        $nbt->setTag(new IntTag("position"));
        $nbt->setTag(new StringTag("player", "0"));

        return $nbt;
    }

    /**
     * @param Block $block
     * @return CompoundTag
     */
    public function monkeySkin(Block $block){
        $path = $this->plugin->getServer()->getDataPath() . "plugin_data/NewMobs/Mobs/Texture/Monkey.png";
        $skin = Utils::getSkinFromFile($path);
        $nbt = Entity::createBaseNBT(new Vector3($block->getX(), $block->getY() + 1, $block->getZ()));
        $nbt->setTag(new CompoundTag("Skin", [
            new StringTag("Data", $skin->getSkinData()),
            new StringTag("Name", "newmobs"),
            new StringTag("GeometryName", "geometry.monkey"),
            new ByteArrayTag("GeometryData", file_get_contents($this->plugin->getDataFolder() . "Mobs/Geometry/Monkey.json"))
        ]));
        $nbt->setTag(new IntTag("position"));
        $nbt->setTag(new StringTag("player", "0"));

        return $nbt;
    }

    /**
     * @param Block $block
     * @return CompoundTag
     */
    public function giraffeSkin(Block $block){
        $path = $this->plugin->getServer()->getDataPath() . "plugin_data/NewMobs/Mobs/Texture/Giraffe.png";
        $skin = Utils::getSkinFromFile($path);
        $nbt = Entity::createBaseNBT(new Vector3($block->getX(), $block->getY() + 1, $block->getZ()));
        $nbt->setTag(new CompoundTag("Skin", [
            new StringTag("Data", $skin->getSkinData()),
            new StringTag("Name", "newmobs"),
            new StringTag("GeometryName", "geometry.giraffe"),
            new ByteArrayTag("GeometryData", file_get_contents($this->plugin->getDataFolder() . "Mobs/Geometry/Giraffe.json"))
        ]));
        $nbt->setTag(new IntTag("position"));
        $nbt->setTag(new StringTag("player", "0"));

        return $nbt;
    }
}
