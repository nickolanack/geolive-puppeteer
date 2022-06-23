<?php

class PuppeteerScriptWidget extends \core\extensions\Widget {

	use \core\extensions\plugin\PluginMemberTrait;
	protected $description = "Create a script for Puppeteer";

	public function runScript($args) {

		$hash = $this->getHash($args);
		if ($this->exists($hash)) {
			return $hash;
		}

		$dir = getcwd();
		chdir(__DIR__);

		$cmd='node test.js ' . escapeshellarg(json_encode(array(
			"url" => $args->url,
			"out" => $this->getImagePath($hash),
		)));

		$this->info('puppeteer', $cmd);

		echo shell_exec($cmd);

		chdir($dir);

		return $hash;
	}

	public function exists($hash) {

		$file = $this->getImagePath($hash);

		if (!file_exists($file)) {
			return false;
		}

		if (strpos($hash, '_') === 0) {
			return true;
		}

		if (time() - filectime($file) > 2*60) {
			$lastFile = dirname($file) . '/_' . basename($file);
			if (file_exists($lastFile)) {
				unlink($lastFile);
			}
			rename($file, $lastFile);
			return false;
		}

		return true;

	}

	public function getImagePath($hash) {

		$outdir = GetPath("{front}/../puppeteer/{domain}/");
		if (!file_exists($outdir)) {
			if (!mkdir($outdir, 0700, true)) {
				throw new \Exception('Failed to create: ' . $outdir);
			}
		}

		$out = $outdir . '/' . $hash . '.png';
		return $out;

	}

	public function getHash($args) {

		if (is_array($args)) {
			$args = (object) $args;
		}

		if (is_object($args) && isset($args->url)) {
			$args = $args->url;
		}

		if (is_string($args)) {
			return md5($args);
		}

		throw new \Exception('Expected string, or object: {"url":<string>}');

	}

}