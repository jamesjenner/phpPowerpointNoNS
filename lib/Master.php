<?php

include_once 'CommonSlideData.php';

/**
 * Master is a class for representing a master as per the Office Open XML File Formats, Standard ECMA-376
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
class Master {

    /** the file scheme */
    const FILE_SCHEME = 'zip://';
    /** slide prefix */
    const MASTER_PREFIX = '#ppt/';

    // TODO: can these be private?

    /** slide id */
	public $id;
    /** slide filename */
	public $filename;
    /** paragraphs within the slide */
	public $paragraphs;


	private $powerpoint;

	public function __construct($powerpoint, $id, $filename) {
		$this->powerpoint = $powerpoint;
		$this->id = $id;
		$this->filename = $filename;
	}

	/**
	 * Retreives from all components of the page instance producing a html markup representation of the page
	 * 	 
	 * @return string the html markup for the page
	 */
	public function getHTML() {
	/* TODO: not required for master, but mechanism to merge is required 
	    $markup = '';
	    $prevParagraph = NULL;
	    // iterate through each paragraph and generate the html markup
        foreach($this->paragraphs as $paragraph) {
            $markup .= $paragraph->getHTML($prevParagraph);
            $prevParagraph = $paragraph;
		}
		
		// TODO: check if there is a memory leak problem due to assigning $paragraph to $prevParagraph
		
		return $markup;
		*/
	}	 	

	/**
	 * Processes the file to generate the master for the current instance
	 * 
	 * iterates through the master and processes the key tags. Note that the current 
	 * implementation does not process timing, transition, extention list 
	 * with modification and header footer tags.	  
	 * 	 	  	 
	 * @todo implement timing, transition, extention list and header footer tags 
	 * with modification tags
	 */ 
	public function build() {
		// echo "slide: " . $this->filename . "<br>";

		$xml = simplexml_load_file(Master::FILE_SCHEME . $this->powerpoint->getFile() . Master::MASTER_PREFIX . $this->filename);

		if($xml === FALSE) {
			// echo "Error opening file: " . Master::FILE_SCHEME . $this->powerpoint->getFile() . Master::SLIDE_PREFIX . $this->filename;
			throw new Exception("Error opening file: " . Master::FILE_SCHEME . $this->powerpoint->getFile() . Master::SLIDE_PREFIX . $this->filename);
		}
		
		// $zOrderTree = $xml->children('p', TRUE)->cSld->children('p', TRUE)->spTree;
		$slideMaster = $xml->children('p', TRUE);
		// echo "> " . "master " . $this->filename . "<br>";
		// echo "name : " . $zOrderTree->getName() . "<br>";
		
		foreach($xml->children("p", TRUE) as $node) {
		    // echo "-> " . $node->getName() . "<br>";
			switch($node->getName()) {
		        case 'cSld':
		            // common slide data
		            // $this->processCommonSlideData($node);
		            $this->commonSlideData[] = new CommonSlideData($this, $node);
		            break;
		        case 'clrMap':
		            // color map
		            $this->processColorMap($node);
		            break;
		        case 'extLst':
		            // extension list with modification
		            // @todo: not implemented
		            break;
		        case 'hf':
		            // header footer
		            // @todo: not implemented
		            break;
		        case 'sldLayoutLst':
		            // slide layout id list
		            $this->processSlideLayoutIdList($node);
		            break;
		        case 'txStyles':
		            // text styles
		            $this->processTextStyles($node);
		            break;
		        case 'timing':
		            // timing
		            // @todo: not implemented
		            break;
		        case 'transition':
		            // transition
		            // @todo: not implemented
		            break;
			}
		}
	    // echo "> " . "end master " . $this->filename . "<br>";
	}

    /**
     * Process the node for the color map
     * 
     * @param $node the node that represents the color map
     */	     
    private function processColorMap($node) {
        // todo: implement, though this is may not be required
	}

    /**
     * Process the node for the slide layout id list
     * 
     * @param $node the node that represents the slide layout id list 	      
     */	     
    private function processSlideLayoutIdList($node) {
        // todo: implement
	}

    /**
     * Process the node for the text styles
     * 
     * @param $node the node that represents the text styles 	      
     */	     
    private function processTextStyles($node) {
        // todo: implement
	}
	
}

?>
