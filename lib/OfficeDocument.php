<?php

/**
 * OfficeDocument is a class for representing an office document as per the Office Open XML File Formats, Standard ECMA-376
 * 
 * @todo implement fully the specification for masters
 * @see PowerPoint 
 * @package phpoffice  
 * @version 0.1    
 * @author James Jenner
 * @copyright Copyright (c) 2011, James Jenner
 * @license http://opensource.org/licenses/gpl-3.0.html GNU General Public License, version 3 (GPL-3.0) 
 * @link http://www.ecma-international.org/publications/standards/Ecma-376.htm
 * @link http://msdn.microsoft.com/en-us/library/gg278321.aspx 	 	 
 */ 
abstract class OfficeDocument {
	protected $file;
	
	public function __construct($filename) {
		$this->file = $filename;
	}
	
	public abstract function buildAll();

	/*
	public function __destruct() {
		// unset all attributes
		foreach ($this as $key => $value ) {
			unset ($this->$key);
		}
	}
	*/
}

?>