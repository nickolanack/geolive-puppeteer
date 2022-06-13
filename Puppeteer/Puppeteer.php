<?php


namespace Plugin;

class Puppeteer extends \core\extensions\Plugin implements
	\core\extensions\widget\WidgetProvider,
	\core\DatabaseProvider{

	use \core\extensions\widget\WidgetProviderTrait;
	use \core\DatabaseProviderTrait;

	protected $description = 'Manages Puppeteer Tests and Scripts via API calls';



	public function queueJob($name, $args=array()){

		try{
			$widget=GetWidget($name);
			if(!($widget instanceof PuppeteerScriptWidget)){
				throw new \Exception('Not a PuppeteerScript: '.$name);
			}


		}catch(\Exception $e){

			throw new \Exception('Not a PuppeteerScript: '.$name);

		}


		$id=$this->getDatabase()->createQueue(array(
			'name'=>$name,
			'arguments'=>json_encode((object)$args)
		));

		return $id;


	}


}
