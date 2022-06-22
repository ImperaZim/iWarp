<?php

namespace iWarp\Commands;

use iWarp\Loader;

use pocketmine\ {
 Utils\Config, 
 player\Player,
 command\Command,
 command\CommandSender,
 command\PluginCommand,
 Utils\TextFormat as C,
};

class WarpCommand extends Command {

 public function __construct() {
  parent::__construct("warp", "§7Warp's menu!");
 }

 public function execute(CommandSender $player, string $commandLabel, array $args) : bool {

  $plugin = Loader::getInstance();
  $player = $plugin->getServer()->getPlayerExact($player->getName());
  $config = new Config($plugin->getDataFolder() . "warps.yml");
  $warps = $config->getAll(); 
  
  $message = $plugin->getConfig();
  
  $permission = $message->get("command.permission");
  $permissiable = $message->get("command.permission");
  
  if($player->hasPermission($permission) == true){
    $permission = "true";
   }else{
    $permission = "false";
    if($permissiable == "default"){
     $permission = "true";
    }
    if($plugin->getServer()->isOp($player->getName()) == true){
     $permission = "true";
    }
   } 
  
  if ($player instanceof Player) {
   if (isset($args[0])) {
    switch ($args[0]) {
     case "tp": case "teleport": 
      if(isset($args[1])){
       $plugin->getWarpEvents()->teleport($player, $args[1]);
      }else{
       $player->sendMessage($message->get("command.teleport.help")); #OK
      }
      break;
     case "set": case "setar":
      if ($permission == "false") {
        $player->sendMessage($message->get("command.nopermission")); #OK
        return true;
       } 
      if (isset($args[1])) {
       $warp = $args[1];
       $world = $player->getWorld()->getDisplayName();
       $x = (int)$player->getPosition()->getX();
       $y = (int)$player->getPosition()->getY();
       $z = (int)$player->getPosition()->getZ();
       $permission = null;
       if (isset($args[2])) $permission = $args[2];
       $plugin->getWarpEvents()->create($player, $warp, $world, [$x, $y, $z], $permission, "");
      } else {
       $player->sendMessage($message->get("command.set.help")); #OK
      }
      break;
      case "del": case "delete":
       if ($permission == "false") {
        $player->sendMessage($message->get("command.nopermission")); #OK
        return true;
       }
       if (isset($args[1])) {
        $warp = $args[1];
        $plugin->getWarpEvents()->delete($player, $warp);
       } else {
        $player->sendMessage($message->get("command.del.help") ); #OK
       }
       break;
       case "list": case "lista":
        $plugin->getWarpEvents()->list($player);
        break;
      }
    } else {
     if($permission == "true" || $plugin->getServer()->isOp($player->getName()) == true){
      $player->sendMessage($message->get("command.help.op")); #OK
     }else{
      $player->sendMessage($message->get("command.help.player")); #OK
     }
    }
   } else {
    $plugin->getLogger()->warning("Esté comando só está disponivel no servidor!");
   }
   return true;
  }

 }
