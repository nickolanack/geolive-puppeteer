<?php 


class PuppeteerScriptWidget extends \core\extensions\Widget{

	use \core\extensions\plugin\PluginMemberTrait;
	protected $description = "Create a script for Puppeteer";

	public function runScript($args){


		$hash=md5($args->url);


		$outdir=GetPath("{front}/../puppeteer/{domain}/");
		if(!file_exists($outdir)){
			if(!mkdir($outdir, 0700, true)){
				throw new \Exception('Failed to create: '.$outdir);
			}
		}

		$out=$outdir.'/'.$hash.'.png';
		if(file_exists($out)){
			return $out;
		}


		$dir=getcwd();
		chdir(__DIR__);

		echo shell_exec('node test.js '.escapeshellarg(json_encode(array(
			"url"=>$args->url,
			"out"=>$out
		))));

		chdir($dir);

		return $out;
	}
	
}