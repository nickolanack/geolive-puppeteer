<?php


namespace Plugin;

class Puppeteer extends \core\extensions\Plugin implements
	\core\extensions\widget\WidgetProvider,
	\core\DatabaseProvider{

	use \core\extensions\widget\WidgetProviderTrait;
	use \core\DatabaseProviderTrait;

	protected $description = 'Manages Puppeteer Tests and Scripts via API calls';


}