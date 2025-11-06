<?php

/* @author vk.com/sanekmelkov and vk.com/kirillmineproyt

█   ▀ ▀█▀ █▀▀ █▀▀ █▀█ █▀█ █▀▀   ▄▄   █ █ ▄▀▄ █▄ █ ▀ █   █   ▄▀▄
█▄▄ █  █  ██▄ █▄▄ █▄█ █▀▄ ██▄        ▀▄▀ █▀█ █ ▀█ █ █▄▄ █▄▄ █▀█
 *
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU Lesser General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * @author vk.com/sanekmelkov and vk.com/kirillmineproyt
 *
 *
*/

namespace pocketmine;

use pocketmine\network\mcpe\protocol\ProtocolInfo;
use pocketmine\plugin\PluginBase;
use pocketmine\plugin\PluginLoadOrder;
use pocketmine\utils\Utils;
use raklib\RakLib;
use pocketmine\plugin\PluginManager;

class CrashDump {

	/** @var Server */
	private $server;
	private $fp;
	private $time;
	private $data = [];
	/** @var string */
	private $encodedData = '';
	/** @var string */
	private $path;

	/**
	 * CrashDump constructor.
	 *
	 * @param Server $server
	 */
	public function __construct(Server $server){
		$this->time = time();
		$this->server = $server;
		$this->path = $this->server->getCrashPath() . 'CrashDump-' . date('D_M_j-H.i.s-T_Y', $this->time) . '.log';
		$this->fp = @fopen($this->path, 'wb');
		if(!is_resource($this->fp)) throw new \RuntimeException('Не удалось создать аварийный дамп!');
		$this->data['time'] = $this->time;
		try{
			$this->baseCrash();
		}catch(\Exception $e){
		}

		$this->generalData();
		$this->pluginsData();

//$this->extraData();
	}

	public function getPath() : string{
		return $this->path;
	}

	/**
	 * @return null
	 */
	public function getEncodedData(){
		return $this->encodedData;
	}

	public function getData() : array{
		return $this->data;
	}

	private function pluginsData(){
		if($this->server->getPluginManager() instanceof PluginManager){
			foreach($this->server->getPluginManager()->getPlugins() as $p){
				$d = $p->getDescription();
				$this->data['plugins'][$d->getName()] = [
					'name' => $d->getName(),
					'version' => $d->getVersion(),
					'authors' => $d->getAuthors(),
					'api' => $d->getCompatibleApis(),
					'enabled' => $p->isEnabled(),
					'depends' => $d->getDepend(),
					'softDepends' => $d->getSoftDepend(),
					'main' => $d->getMain(),
					'load' => $d->getOrder() === PluginLoadOrder::POSTWORLD ? 'POSTWORLD' : 'STARTUP',
					'website' => $d->getWebsite()
				];
			}
		}
	}

	private function baseCrash(){
		global $lastExceptionError, $lastError;

		if(isset($lastExceptionError)){
			$error = $lastExceptionError;
		}else{
			$error = (array) error_get_last();
			$error['trace'] = Utils::getTrace(3); //Skipping CrashDump->baseCrash, CrashDump->construct, Server->crashDump
			$errorConversion = [
				E_ERROR => 'E_ERROR',
				E_WARNING => 'E_WARNING',
				E_PARSE => 'E_PARSE',
				E_NOTICE => 'E_NOTICE',
				E_CORE_ERROR => 'E_CORE_ERROR',
				E_CORE_WARNING => 'E_CORE_WARNING',
				E_COMPILE_ERROR => 'E_COMPILE_ERROR',
				E_COMPILE_WARNING => 'E_COMPILE_WARNING',
				E_USER_ERROR => 'E_USER_ERROR',
				E_USER_WARNING => 'E_USER_WARNING',
				E_USER_NOTICE => 'E_USER_NOTICE',
				E_STRICT => 'E_STRICT',
				E_RECOVERABLE_ERROR => 'E_RECOVERABLE_ERROR',
				E_DEPRECATED => 'E_DEPRECATED',
				E_USER_DEPRECATED => 'E_USER_DEPRECATED',
			];
			$error['fullFile'] = $error['file'];
			$error['file'] = Utils::cleanPath($error['file']);
			$error['type'] = isset($errorConversion[$error['type']]) ? $errorConversion[$error['type']] : $error['type'];
			if(($pos = strpos($error['message'], '\n')) !== false) $error['message'] = substr($error['message'], 0, $pos);
		}

		if(isset($lastError)) $this->data['lastError'] = $lastError;

		$this->data['error'] = $error;
		unset($this->data['error']['fullFile']);
		unset($this->data['error']['trace']);
		$this->addLine('Ошибка: '. $error['message']);
		$this->addLine('Путь: ' . $error['file']);
		$this->addLine('Строка: ' . $error['line']);
		$this->addLine('Тип ошибки: ' . $error['type']);

		if(strpos($error['file'], 'src/pocketmine/') === false and strpos($error['file'], 'src/raklib/') === false and file_exists($error['fullFile'])){
			$this->data['plugin'] = true;

			$reflection = new \ReflectionClass(PluginBase::class);
			$file = $reflection->getProperty('file');
			$file->setAccessible(true);
			foreach($this->server->getPluginManager()->getPlugins() as $plugin){
				$filePath = Utils::cleanPath($file->getValue($plugin));
				if(strpos($error['file'], $filePath) === 0){
					$this->data['plugin'] = $plugin->getName();
					$this->addLine('Плагин: ' . $plugin->getDescription()->getFullName());
					break;
				}
			}
		}else $this->data['plugin'] = false;
		$this->addLine('Код:');
		$this->data['code'] = [];
if($this->server->getProperty('auto-report.send-code', true) !== false){
			$file = @file($error['fullFile'], FILE_IGNORE_NEW_LINES);
			for($l = max(0, $error['line'] - 5); $l < $error['line'] + 5; ++$l){
				$this->addLine('[' . ($l + 1) . '] ' . @$file[$l]);
				$this->data['code'][$l + 1] = @$file[$l];
			}
		}
 }

	private function generalData(){
		$this->data['general'] = [];
		$this->data['general']['protocol'] = ProtocolInfo::CURRENT_PROTOCOL;
		$this->data['general']['api'] = \pocketmine\API_VERSION;
		$this->data['general']['git'] = \pocketmine\GIT_COMMIT;
		$this->data['general']['raklib'] = RakLib::VERSION;
		$this->data['general']['uname'] = php_uname('a');
		$this->data['general']['php'] = phpversion();
		$this->data['general']['zend'] = zend_version();
		$this->data['general']['php_os'] = PHP_OS;
		$this->data['general']['os'] = Utils::getOS();
		$this->addLine('Версия PHP: '. phpversion());
		$this->addLine('OS: ' . PHP_OS .', ' . Utils::getOS());
		$this->addLine('Аптайм сервера: '. $this->server->getUptime());
		$this->addLine('Было загружено миров: ' . count($this->server->getLevels()));
		$this->addLine('Онлайн на сервере: '. count($this->server->getOnlinePlayers()) . '/' . $this->server->getMaxPlayers());
	}

	public function addLine($line = ''){
		fwrite($this->fp, $line . PHP_EOL);
	}

	public function add($str){
		fwrite($this->fp, $str);
	}

}
