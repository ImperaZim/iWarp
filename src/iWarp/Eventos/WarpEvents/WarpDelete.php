<?php

namespace iWarp\Eventos\WarpEvents;

use iWarp\Loader;
use pocketmine\utils\Config; 

class WarpDelete {
 
 public function __construct($player, $warp) {
  $plugin = Loader::getInstance();
  $config = new Config($plugin->getDataFolder() . "warps.yml");
  $warps = $config->getAll();
  $data = $plugin->getDataFolder();
  
  $message = $plugin->getConfig();  
  
  if(!isset($warps[$warp])){
   $player->sendMessage($plugin->getProcessedTags($message->get("command.del.nowarp"), $warp));
  }else{
   unset($warps[$warp]);
   $config->setAll($warps); 
   $config->save(); 
   $player->sendMessage("\n§l§bWARP§r A warp §b{$warp}§r foi deletada com sucesso!\n §a"); 
   $player->sendMessage($plugin->getProcessedTags($message->get("command.del.sucess"), $warp));
  } 
 }
 
}
