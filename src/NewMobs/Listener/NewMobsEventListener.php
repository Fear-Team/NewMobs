<?php

namespace NewMobs\Listener;

use NewMobs\Entity\EntityManager;
use NewMobs\Entity\Gorilla;
use NewMobs\NewMobs;
use pocketmine\event\Listener;
use pocketmine\math\Vector3;
use pocketmine\nbt\tag\{IntTag, StringTag, CompoundTag, ByteArrayTag};
use pocketmine\event\player\PlayerInteractEvent;

class NewMobsEventListener implements Listener{

    /** @var NewMobs */
    private $plugin;

    /**
     * NewMobsEventListener constructor.
     * @param NewMobs $plugin
     */
    public function __construct(NewMobs $plugin){
        $this->plugin = $plugin;
    }

    /**
     * @param PlayerInteractEvent $e
     */
    public function interactEvent(PlayerInteractEvent $e){
        $p = $e->getPlayer();
        $item = $e->getItem();
        $block = $e->getBlock();
        $action = $e->getAction();
        $config = $this->plugin->onSettings();
        $mobsitem = $config->get("Mobs-Item");
        $explode = explode(",", $mobsitem);

        if ($action == PlayerInteractEvent::RIGHT_CLICK_BLOCK){
            if ($item->getId() == $explode[0] && $item->getDamage() == $explode[1] && $item->getLore() == ["NewMobs"]){

                $manager = new EntityManager($this->plugin);
                $nbt = $manager->gorillaSkin($block);
                $npc = new Gorilla($p->getLevel(), $nbt);
                $npc->spawnToAll();

                $item->setCount(1);
                $p->getInventory()->removeItem($item);
            }
        }
    }
}
