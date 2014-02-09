<?php

/*
 * (The MIT License)
 * 
 * Copyright (c) 2012-2014 James Jenner
 * 
 * Permission is hereby granted, free of charge, to any person obtaining a copy
 * of this software and associated documentation files (the "Software"), to deal
 * in the Software without restriction, including without limitation the rights
 * to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
 * copies of the Software, and to permit persons to whom the Software is
 * furnished to do so, subject to the following conditions:
 * 
 * The above copyright notice and this permission notice shall be included in
 * all copies or substantial portions of the Software.
 * 
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
 * IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
 * FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
 * AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
 * LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
 * OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN
 * THE SOFTWARE.
 */

/**
 * OfficeDocument is a class for representing an office document as per the Office Open XML File Formats, Standard ECMA-376
 * 
 * @todo implement fully the specification for masters
 * @see PowerPoint 
 * @package phpoffice  
 * @version 0.1    
 * @author James Jenner
 * @copyright Copyright (c) 2011, James Jenner
 * @license see above
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
