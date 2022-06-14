<?php


namespace Plugin;

class Puppeteer extends \core\extensions\Plugin implements
	\core\extensions\widget\WidgetProvider,
	\core\DatabaseProvider,
	\core\EventListener{

	use \core\extensions\widget\WidgetProviderTrait;
	use \core\DatabaseProviderTrait;
	use \core\EventListenerTrait;

	protected $description = 'Manages Puppeteer Tests and Scripts via API calls';



	public function queueJob($name, $args=array()){

		try{

			$widget=GetWidget($name);
			
		}catch(\Exception $e){
			throw new \Exception('PuppeteerScript does not exist: '.$name.' '.$e->getMessage());
		}

		if(!($widget instanceof \PuppeteerScriptWidget)){
			throw new \Exception('Widget is not a PuppeteerScript: '.$name);
		}


		$id=$this->getDatabase()->createQueue(array(
			'name'=>$name,
			'arguments'=>json_encode((object)$args)
		));


		Throttle('onTriggerProccessPuppeteerJobs', array('job'=>$id), array('interval' => 5), 2);


		return array('values'=>$this->getDatabase()->getQueueList());


	}



	protected function onTriggerProccessPuppeteerJobs($args){


		$records=$this->getDatabase()->getQueueList();

		if(empty($records)){
			return;
		}

		$counter=0;
		$time=microtime(true);


		$maxItems=10;
		$maxProcessTime=30;

		while((!empty($records))&&$counter<$maxItems&&microtime(true)-$time<$maxProcessTime){


			$row=array_shift($records);
			$this->getDatabase()->deleteQueue($row->id);
			$counter++;


			$widget=GetWidget($row->name);
			$widget->runScript(json_decode($row->arguments));


		}


		if(!empty($records)){
			//Throttle('onTriggerProccessPuppeteerJobs', array('job'=>$id), array('interval' => 30), 2);
		}



	}


}

