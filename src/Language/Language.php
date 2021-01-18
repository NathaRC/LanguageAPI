<?php

namespace Language;

use pocketmine\Player;
use pocketmine\utils\Config;
use pocketmine\plugin\Plugin;
use pocketmine\plugin\PluginBase;
use pocketmine\utils\TextFormat as TF;
use pocketmine\command\Command;
use pocketmine\command\CommandSender;

class Language extends PluginBase {

        public static::$plugin;

	public function onEnable() {
		static::$plugin = $this;
		$this->saveDefaultConfig();
		$this->getLogger()->info(TF::DARK_PURPLE.'Loaded successfully!');
	}

	public static function getInstance() : Language{
		return static::$plugin;
	}

	public function setTranslate(Plugin $plugin, Player $player, string $params, array $datos = []) : string{
		$dir = $plugin->getDataFolder() . '/languages/';
		if (!is_dir($dir)) {
			mkdir($dir, 0477);
		}

		$language = $this->getLanguage($player);
		$lang = new Config($dir . $language . '.yml');

		if ($lang->exists($params)) {
		    $value = $lang->get($params);
		    foreach ($datos as $dato => $data){
		        $value = str_replace("{%$dato}", $data, $value);
            }
			return TF::colorize($value);
		}

		foreach (array_diff(scandir($dir), [".", ".."]) as $filelang) {
			$config = new Config($dir . $filelang, Config::YAML);
			if ($config->exists($params)) {
			    $value = $config->get($params);
			    foreach ($datos as $dato => $data){
			        $value = str_replace("{%$dato}", $data, $value);
                }
				return TF::colorize($value);
			}
		}
		
		return TF::colorize($params);
	}

	public function getLanguage(Player $player) : string{
		return (new Config($this->getDataFolder() . 'languages.yml', Config::YAML))->get($player->getName(), 'eng');
	}

	public function getLanguages() : array{
		return (new Config($this->getDataFolder() . 'config.yml', Config::YAML))->getAll();
	}

	public function onCommand(CommandSender $sender, Command $command, string $label, array $args) : bool{
		if ($sender instanceof Player) {
			$config = new Config($this->getDataFolder() . 'languages.yml', Config::YAML);
			
			if (count($args) < 1) {
				$sender->sendMessage(TF::RED . 'Usage: /lang list');
				return true;
			}

			$default = $args[0];

			if ($default == 'list') {
				$sender->sendMessage(TF::GREEN . 'Language list: ');
				foreach ($this->getLanguages() as $key => $value) {
					$sender->sendMessage(TF::GREEN . $key . ' - ' . $value);
				}
			}elseif (array_key_exists($default, $this->getLanguages())) {
				$config->set($sender->getName(), $default);
				$config->save();
				$sender->sendMessage(TF::GREEN . 'Your language change to ' . $default . '.');
			}else{
				$sender->sendMessage(TF::RED . 'The language ' . $default . ' not exists.');
			}
			return true;
		}
		return true;
	}
}
