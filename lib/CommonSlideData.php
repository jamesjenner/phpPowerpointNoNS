<?php

include_once 'Shape.php';

/**
 * CommonSlideData is a class for representing common slide data as per the Office Open XML File Formats, Standard ECMA-376
 * 
 * Common slide data is used by handout master, notes, notes master, slide,
 * slide layout, slide master.
 *  
 * @todo implement fully the specification for common slide data 
 *  
 * @see PowerPoint 
 * @package phpoffice  
 * @version 0.1    
 * @author James Jenner
 * @copyright Copyright (c) 2011, James Jenner
 * @license http://opensource.org/licenses/gpl-3.0.html GNU General Public License, version 3 (GPL-3.0) 
 * @link http://www.ecma-international.org/publications/standards/Ecma-376.htm
 * @link http://msdn.microsoft.com/en-us/library/documentformat.openxml.presentation.commonslidedata.aspx 	 	 
 */ 
class CommonSlideData {

	private $node;
	private $parentNode;
	
	/** an array of shapes for the common slide data instance */
	public $shapes;

	public function __construct($parentNode, $node) {
		$this->parentNode = $parentNode;
		$this->node = $node;
		$this->processCommonSlideData($node);
	}

	/**
	 * Retreives from all components of the page instance producing a html markup representation of the page
	 * 	 
	 * @return string the html markup for the page
	 */
	public function getHTML() {
	/*
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
     * Process the node for the common slide data
     *
     * @param $node the node that represents the common slide data 	      
     */	     
	private function processCommonSlideData($node) {

		// iterate through each child
		foreach($node->children("p", TRUE) as $subNode) {
		    // echo "--> " . $subNode->getName() . "<br>";
			switch($subNode->getName()) {
		        case 'bg':
		            // background
		            $this->processBackground($subNode);
		            break;
		        case 'spTree':
		            $this->processShapeTree($subNode);
		            // shape tree
		            break;
		        case 'custDataLst':
		            // customer data list
		            // @todo: not implemented
		            break;
		        case 'controls':
		            // control list
		            // @todo: not implemented
		            break;
		        case 'extLst':
		            // common slide data extension list
		            // @todo: not implemented
		            break;
            }
        }
	}

    /**
     * Process the background node
     * 
     * @param $node the node that represents the background
     */	     
    private function processBackground($node) {
		// iterate through each child
		foreach($node->children("p", TRUE) as $subNode) {
		    // echo "---> " . $subNode->getName() . "<br>";
			switch($subNode->getName()) {
		        case 'bgRef':
		            // background style reference
		            $this->processBackgroundStyleReference($subNode);
		            break;
		        case 'bgPr':
		            // background properties
		            // @todo: not implemented
		            break;
            }
        }
	}
	
    /**
     * Process the background style reference node
     * 
     * The background style reference defines the type of style to fill the background for slides	      
     * 
     * @param $node the node that represents the background style reference
     * 
     * @link http://msdn.microsoft.com/en-us/library/documentformat.openxml.presentation.backgroundstylereference.aspx	      
     */	     
	private function processBackgroundStyleReference($node) {
		foreach($node->children("a", TRUE) as $subNode) {
			switch($subNode->getName()) {
		        case 'scrgbClr':
		            // Rgb Color Model Percentage
		            // @todo: not implemented
		            break;

		        case 'srgbClr':
		            // Rgb Color Model Hex
		            // @todo: not implemented
		            break;

		        case 'hslClr':
		            // Hsl Color
		            // @todo: not implemented
		            break;

		        case 'sysClr':
		            // System Color
		            // @todo: not implemented
		            break;

		        case 'schemeClr':
		            // Scheme Color
		            // @todo: not implemented
		            break;
     
		        case 'prstClr':
		            // Preset Color
		            // @todo: not implemented
		            break;
            }
        }
	}
	
    /**
     * Process the shape tree node
     * 
     * Specifies all shape based objects, either grouped or not grouped,
     * that can be referenced on a given slide. The majority of content
     * within a slide is defined in reference to a shape, including text.	   	 	      
     * 
     * @param $node the node that represents the shape tree
     * 
     * @see http://msdn.microsoft.com/en-us/library/documentformat.openxml.presentation.shapetree.aspx
     */	     
    private function processShapeTree($node) {
		// iterate through each child
		foreach($node->children("p", TRUE) as $subNode) {
		    // echo "---> " . $subNode->getName() . "<br>";
			switch($subNode->getName()) {
		        case 'nvGrpSpPr':
                    // non visual group shape properties 
		            // @todo: not implemented
		            break;
     
		        case 'grpSpPr':
		            // group shape properties
		            $this->processGroupShapeProperties($subNode);
		            break;

		        case 'sp':
    	            // shape 
    	            // create a new instance of the shape, parsing the current sub node 
		            $this->shapes[] = new Shape($this, $subNode);
		            break;

		        case 'grpSp':
    	            // group shape 
		            // @todo: not implemented
		            break;

		        case 'graphicFrame':
    	            // graphic frame 
		            // @todo: not implemented
		            break;

		        case 'cxnSp':
    	            // connection shape 
		            // @todo: not implemented
		            break;

		        case 'pic':
    	            // picture 
		            // @todo: not implemented
		            break;

		        case 'contentPart':
    	            // content part 
		            // @todo: not implemented
		            break;
		            
		        case 'extLst':
    	            // extension list with modification  
		            // @todo: not implemented
		            break;
            }
        }
	}
	
    /**
     * Process the group shape properties node
     * 
     * @param $node the node that represents the group shape properties 
     * 
     * @see http://msdn.microsoft.com/en-us/library/documentformat.openxml.presentation.groupshapeproperties.aspx
     */	     
	private function processGroupShapeProperties($node) {
		foreach($node->children("a", TRUE) as $subNode) {
		    // echo "----> " . $subNode->getName() . "<br>";
			switch($subNode->getName()) {
		        case 'xfrm':
		            // transform group
		            // @todo: not implemented
		            break;

		        case 'noFill':
		            // no fill
		            // @todo: not implemented
		            break;

		        case 'solidFill':
		            // solid fill
		            // @todo: not implemented
		            break;

		        case 'gradFill':
		            // gradient fill
		            // @todo: not implemented
		            break;

		        case 'blipFill':
		            // blip fill
		            // @todo: not implemented
		            break;

		        case 'pattFill':
		            // pattern fill
		            // @todo: not implemented
		            break;

		        case 'grpFill':
		            // group fill 
		            // @todo: not implemented
		            break;

		        case 'effectLst':
		            // effect list 
		            // @todo: not implemented
		            break;

		        case 'effectDag':
		            // effect dag
		            // @todo: not implemented
		            break;

		        case 'scene3d':
		            // scene 3d type 
		            // @todo: not implemented
		            break;

		        case 'extLst':
		            // extension list
		            // @todo: not implemented
		            break;
            }
        }	
	}
}

?>
