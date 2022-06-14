<?php 


class PuppeteerScriptWidget extends \core\extensions\Widget{

	use \core\extensions\plugin\PluginMemberTrait;
	protected $description = "Create a script for Puppeteer";

	public function runScript($args){


		$dir=getcwd();
		chdir(__DIR__);

		echo shell_exec('node test.js '.escapeshellarg(json_encode(array("url"=>$args->url)));

		chdir($dir);
	}
	
}