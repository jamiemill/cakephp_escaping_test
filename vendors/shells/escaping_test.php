<?php

/**
* Another way of doing this would be to output a known unescaped string e.g. &&& and check for its presence when we know it should be &amp;&amp;&amp;
* Then we could prepend our existing data and keep things looking more readable.
*/


class EscapingTestShell extends Shell{
	
	var $whitelist = array(
		'Client.slug',
		'Campaign.slug',
		'Agency.slug',
		'Share.model',
		'Client.title',
		'Agency.title'
	);
	
	function infect_with_js() {
		
		$models = App::objects('model');
		foreach($models as $model) {
			$Model = ClassRegistry::init($model);
			$schema = $Model->schema();
			
			$listRecords = $Model->find('list');
			foreach($listRecords as $id => $displayField) {
				$Model->create();
				$Model->id = $id;
				foreach($schema as $fieldName => $fieldParams) {
					
					if(in_array($model.'.'.$fieldName, $this->whitelist)) {
						$this->out("SKIPPING $model.$fieldName");
						continue;
					}
					
					if($fieldParams['type'] == 'string' || $fieldParams['type'] == 'text') {
						if(!preg_match('/_id$/',$fieldName)) {
							$nastyValue = "<script>EscTest.chk('$model.$fieldName')</script>";
							if(!$Model->saveField($fieldName, $nastyValue)) {
								$this->out("ERROR saving $model Field: $fieldName VALUE: $nastyValue Record: $displayField");
								$this->out(print_r($Model->validationErrors,true));
							} else {
								$this->out("OK! Infected model:$model Field: $fieldName VALUE: $nastyValue Record: $displayField");
							}
						}
					}
				}
				
			}
			
		}
		
	}
	
}

?>