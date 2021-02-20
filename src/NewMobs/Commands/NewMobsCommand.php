<?php

namespace NewMobs\Commands;

use pocketmine\math\Vector3;
use pocketmine\nbt\tag\{IntTag, StringTag, CompoundTag, ByteArrayTag};
use NewMobs\NewMobs;
use NewMobs\Utils\Utils;
use pocketmine\command\{PluginCommand, CommandSender};
use pocketmine\entity\Entity;
use pocketmine\item\Item;
use pocketmine\Player;
use pocketmine\utils\TextFormat as C;

class NewMobsCommand extends PluginCommand{

    /** @var NewMobs */
    private $plugin;

    /**
     * NewMobsCommand constructor.
     * @param NewMobs $plugin
     */
    public function __construct(NewMobs $plugin){
        parent::__construct("newmobs", $plugin);
        $this->setAliases(['nm']);
        $this->setDescription("New Mobs Commands");
        $this->setUsage("/nm help");
        $this->plugin = $plugin;
    }

    /**
     * @param CommandSender $p
     * @param string $commandLabel
     * @param array $args
     * @return bool|mixed
     */
    public function execute(CommandSender $p, string $commandLabel, array $args){
        if (!$p instanceof Player){
            $p->sendMessage("Please Use This Command In-Game!");
            return false;
        }
        if (!$p->isOp()){
            $p->sendMessage("You haven't permissions!");
            return false;
        }

        $config = $this->plugin->onSettings();
        $title = $this->plugin->onTitle();
        $successgivemessage = $config->get("Success-Give-Message");
        $notfoundmessage = $config->get("Not-Found-Message");
        $notnumericmessage = $config->get("Not-Numeric-Message");
        $fullinventorymessage = $config->get("Full-Inventory-Message");

        $title = str_replace("&", "§", $title);
        $successgivemessage = str_replace("&", "§", $successgivemessage);
        $notfoundmessage = str_replace("&", "§", $notfoundmessage);
        $notnumericmessage = str_replace("&", "§", $notnumericmessage);
        $fullinventorymessage = str_replace("&", "§", $fullinventorymessage);

        $mobs = $this->plugin->onMobs();
        $item = $config->get("Mobs-Item");

        if (isset($args[0])) {
            switch ($args[0]) {
                case "help":
                    $p->sendMessage(C::BOLD . C::DARK_GREEN . "NEWMOBS" . C::RESET);
                    $p->sendMessage(C::GRAY . "/nm help");
                    $p->sendMessage(C::GRAY . "/nm give [mobs] [count]");
                    $p->sendMessage(C::GRAY . "/nm list");
                    break;
                case "give":
                    if (isset($args[1])){
                        if (isset($args[2])){
                            if (!in_array($args[1], $mobs)){
                                $p->sendMessage($title . $notfoundmessage);
                                return false;
                            }
                            if (!is_numeric($args[2])){
                                $p->sendMessage($title . $notnumericmessage);
                                return false;
                            }

                            $explode = explode(",", $item);
                            $item = Item::get($explode[0], $explode[1], $args[2]);
                            $item->setCustomName(C::GREEN . $args[1] . C::GRAY . " Mob");
                            $item->setLore(["NewMobs"]);

                            if ($p->getInventory()->canAddItem($item)){
                                $p->getInventory()->addItem($item);
                                $p->sendMessage($title . $successgivemessage);
                                return true;
                            }else{
                                $p->sendMessage($title . $fullinventorymessage);
                                return false;
                            }
                        }
                    }
                    break;
                case "list":
                    $p->sendMessage(C::BOLD . C::DARK_GREEN . "NEWMOBS" . C::RESET);

                    $implode = null;
                    foreach ($mobs as $data){
                        $implode = C::GRAY . $data . "\n";

                        $p->sendMessage($implode);
                    }
                    break;
            }
        }else{
            $p->sendMessage(C::DARK_GREEN . "Usage: " . C::GRAY . $this->getUsage());
        }
        return true;
    }
}
