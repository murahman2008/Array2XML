class Array2XML
{
	private $_xmlObject;
	private $_xmlVersion = '1.0';
	private $_currentNode = false;

	public function __construct($root = false)
	{
		if($root === false || ($root = trim($root)) === '')
			throw new Exception("A Root Element Must Be Specified!");

		$this->_xmlObject = new SimpleXMLElement('<?xml version = "'.$this->_xmlVersion.'"?><'.$root.'></'.$root.'>');
	}

	private function _fixEncoding($name)
	{
		return $name;
	}

	public function reset()
	{
		$this->_xmlObject = false;
		return $this;
	}

	public function initialize($root = false)
	{
		if($root === false || ($root = trim($root)) === '')
			throw new Exception("A Root Element Must Be Specified!");

		$this->reset();
		$this->_xmlObject = new SimpleXMLElement('<?xml version = "'.$this->_xmlVersion.'"?><'.$root.'></'.$root.'>');

		return $this;
	}

	private function _array2xml(Array $input)
	{
		$inputArrayKeys = array_keys($input);
		if(count(array_diff(array('~name~', '~value~'), $inputArrayKeys)) <= 0)
		{
			if(!is_array($input['~value~']))
				$this->_currentNode->addChild($input['~name~'], $input['~value~']);
			else
			{						
				$oldCurrentNode = $this->_currentNode;
				$this->_currentNode = $this->_currentNode->addChild($input['~name~']);
				$this->_array2xml($input['~value~']);
				$this->_currentNode = $oldCurrentNode;
			}	
		}
		else	
		{
			foreach($input as $key => $value)
			{
				if(is_array($value))
				{
					if(count($value) > 0)
					{
						if(!is_numeric($key))
						{	
							//var_dump($key);
							//var_dump($value);
							//var_dump("<br/>------------------<br/>");

							$oldCurrentNode = $this->_currentNode;
							$this->_currentNode = $this->_currentNode->addChild($key);
							$this->_array2xml($value);
							$this->_currentNode = $oldCurrentNode;
						}
						else
							$this->_array2xml($value);
					}					
				}
				else
					$this->_currentNode->addChild($key, $value);
			}
		}	
	}

	public function convert(Array $input = array())
	{
		if(!$this->_xmlObject instanceof SimpleXMLElement)
			throw new Exception("A Root Element Must Be Specified To Initialize the XML");

		$outputXML = '';

		if(count($input) <= 0)
			$outputXML = $this->_xmlObject->asXML();
		else
		{
			$this->_currentNode = $this->_xmlObject;
			//var_dump($this->_currentNode instanceof SimpleXMLElement);
			//var_dump("fasfsd");
			 //die();

			$this->_array2xml($input);

			$outputXML = $this->_currentNode->asXML();
		}	

		return $outputXML;
	}

}
