<?php


/**
 * Relationship is a class for representing a relationship from rel files within the Office Open XML File Formats, Standard ECMA-376
 * A relationship defines a path to an xml file that is tied to the id, so that in other xml, only the id is required. 
 *
 * @todo implement fully the specification for masters
 * @package phpoffice
 * @version 0.1
 * @author James Jenner
 * @copyright Copyright (c) 2011, James Jenner
 * @license http://opensource.org/licenses/gpl-3.0.html GNU General Public License, version 3 (GPL-3.0) 
 * @link http://www.ecma-international.org/publications/standards/Ecma-376.htm
 * @link http://msdn.microsoft.com/en-us/library/gg278321.aspx
 */
class Relationship {

	public $id;
	public $target;
	public $type;
}

?>