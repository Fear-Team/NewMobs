<?php

namespace NewMobs\Entity;

use NewMobs\NewMobs;
use pocketmine\entity\Human;
use pocketmine\entity\Skin;
use pocketmine\item\Item;

class Monkey extends Human{

    /** @var float */
    public $height = 1.8;

    /** @var float */
    public $width = 0.6;

    /**
     * @param Skin $skin
     */
    public function setSkin(Skin $skin) : void{
        parent::setSkin(new Skin($skin->getSkinId(), $skin->getSkinData(), '', 'geometry.monkey', file_get_contents(NewMobs::getInstance()->getDataFolder() . "Mobs/Geometry/Monkey.json")));
    }

    /**
     * @return array
     */
    public function getDrops(): array{
        $config = NewMobs::getInstance()->onSettings();
        $item = [];

        foreach ($config->getNested("Monkey.Drops") as $dropsitem){
            $explode = explode(",", $dropsitem);
            $id = $explode[0];
            $meta = $explode[1];
            $count  = $explode[2];
            $item[] = Item::get($id, $meta, $count);
        }

        return $item;
    }
}
