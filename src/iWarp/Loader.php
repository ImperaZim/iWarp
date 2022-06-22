<?php

namespace iWarp;

use pocketmine\ {
 Server,
 utils\Config,
 player\Player,
 plugin\Plugin,
 plugin\PluginBase,
 utils\TextFormat as C,
};

class Loader extends PluginBase {

 public static $instance = null;

 public static function getInstance() : Loader {
  return self::$instance;
 }

 public function onEnable() : void {
  self::$instance = $this;
  $this->loadWorlds();
  $this->getWarpEvents();
  $this->registerCommands();
  $this->getConfig()->get("command.permission");
  $this->getServer()->getLogger()->info(C::GREEN . "Plugin iWarp ativado!");
 }

 public function onDisable() : void {
  self::$instance = $this;
  $this->getServer()->getLogger()->info(C::GREEN . "Plugin iWarp desativado!");
 }
 
 public function registerCommands() {
  $map = $this->getServer()->getCommandMap();
		$map->register("warp", new Commands\WarpCommand($this));   
 }
 
 public function getWarpEvents() {
  new Config($this->getDataFolder() . "warps.yml"); 
 }
 
 public function getProcessedTags($message, $warp = null) {
  $tags = ["{warp}", "{warps}", "{prefix}"];
  $processed = [$warp, $warp, "§l§bWARP§r"];
  $message = str_replace($tags, $processed, $message);
  return $message;
 }
 
 public function loadWorlds(){
  $levelNamesArray = scandir($this->getServer()->getDataPath() . "worlds/");
  foreach($levelNamesArray as $levelName){
   if($levelName === "." || $levelName === ".."){continue;}
   $this->getServer()->getWorldManager()->loadWorld($levelName);
  } $levels = $this->getServer()->getWorldManager()->getWorlds(); 
 }  
 
 public function getConfig() {
  return $this->getConfig();
 }
 
 public function getDataFolder() {
  return $this->getDataFolder();
 }
 
 public function getServer() {
  return $this->getServer();
 }

}
