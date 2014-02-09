<?php

include_once 'Paragraph.php';

/**
 * Slide is a class for representing a slide as per the Office Open XML File Formats, Standard ECMA-376
 * 
 * @todo implement fully the specification for slides 
 * @see PowerPoint 
 * @package phpoffice  
 * @version 0.1    
 * @author James Jenner
 * @copyright Copyright (c) 2011, James Jenner
 * @license http://opensource.org/licenses/gpl-3.0.html GNU General Public License, version 3 (GPL-3.0) 
 * @link http://www.ecma-international.org/publications/standards/Ecma-376.htm	 	 
 */ 
class Slide {

    /** the file scheme */
    const FILE_SCHEME = 'zip://';
    /** slide prefix */
    const SLIDE_PREFIX = '#ppt/';

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
	 * getHTML retreives from all components of the page instance producing a html markup representation of the page
	 * 	 
	 * @return string the html markup for the page
	 */
	public function getHTML() {
	    $markup = '';
	    $prevParagraph = NULL;
	    // iterate through each paragraph and generate the html markup
        foreach($this->paragraphs as $paragraph) {
            $markup .= $paragraph->getHTML($prevParagraph);
            $prevParagraph = $paragraph;
		}
		
		// TODO: check if there is a memory leak problem due to assigning $paragraph to $prevParagraph
		
		return $markup;
	}	 	

	/**
	 * Processes the file to generate the slide for the current instance
	 * 
	 * @see Paragraph	 	 
	 */ 
	public function build() {
		// echo "slide: " . $this->filename . "<br>";

		$xml = simplexml_load_file(Slide::FILE_SCHEME . $this->powerpoint->getFile() . Slide::SLIDE_PREFIX . $this->filename);

		if($xml === FALSE) {
			// echo "Error opening file: " . Slide::FILE_SCHEME . $this->powerpoint->getFile() . Slide::SLIDE_PREFIX . $this->filename;
			throw new Exception("Error opening file: " . Slide::FILE_SCHEME . $this->powerpoint->getFile() . Slide::SLIDE_PREFIX . $this->filename);
		}

		$zOrderTree = $xml->children('p', TRUE)->cSld->children('p', TRUE)->spTree;
		
		foreach($zOrderTree->children("p", TRUE) as $node) {
			
			// if the node is a shape
			if($node->getName() === "sp") {
				
				// we need to get the text bodies
				foreach($node->children("p", TRUE) as $node2) {

					// if the node is a text body
					if($node2->getName() === "txBody") {
						
						foreach($node2->children("a", TRUE) as $node3) {

							// if the node is a paragraph
							if($node3->getName() === "p") {
							    // create the paragraph from the node
								$this->paragraphs[] = new Paragraph($node3);
							}
						} 
					}
				}
			}
		}
	}
}

?>