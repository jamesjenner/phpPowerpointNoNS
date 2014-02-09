<?php

/**
 * PowerPoint is a class for representing a power point document as per the Office Open XML File Formats, Standard ECMA-376
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


/*
 * commented out to support drupal
function __autoload($class) {
    // convert namespace to full file path
    $class = str_replace('\\', '/', $class) . '.php';
    require_once($class);
}
*/
/* added to support drupal */
include_once 'lib/Slide.php';

/** location of the presentation relationship file */
const PRESENTATION_RELATIONSHIPS = '#ppt/_rels/presentation.xml.rels';
/** location of presentation xml file */
const PRESENTATION = '#ppt/presentation.xml';
// const FILE_SCHEME = 'zip://';

echo "PowerPoint.php - 2<br>";
/**
 * Powerpoint is a class for representing a powerpoint presentation as per the Office Open XML File Formats, Standard ECMA-376
 * 
 * @see OfficeDocument 
 * @package phpoffice  
 * @author James Jenner
 * @version 0.1    
 * @copyright 
 * @link http://www.ecma-international.org/publications/standards/Ecma-376.htm          
 */ 
class PowerPoint extends OfficeDocument {
    private $relationships;
    private $xml;
    private $slides;
    
    /**
     * Retrieves the number of slides for the power point document.
     * 
     * @return int the number of slides within the power point document
     */
    public function getNumberOfSlides() {
        return count($this->slides);
    }
    
    /**
     * Retreive the slide based on the specified number.
     * 
     * @param integer $number the slide to retrieve.
     */
    public function getSlide($number) {
        return $this->slides[$number];
    }

    /**
     * buildAll processes the various files to generate the powerpoint presentation for the current instance
     * 
     * @see PowerPoint          
     */ 
    public function buildAll() {
        echo "PowerPoint.php - buildAll 1";
        $this->buildRelationships();
        echo "PowerPoint.php - buildAll 2";
        $this->buildMasters();
        echo "PowerPoint.php - buildAll 3";
        $this->buildPresentation();
        echo "PowerPoint.php - buildAll 4";
    }
    
    /**
     * Retreives from all components of the power point instance producing a html markup representation of the presentation
     *      
     * @param string $pageTag the tag to insert to deliminate pages for the presentation, default is "div" 
     * @param string $tagLeftDelim the deliminator for the left of the page tag, default is "<"
     * @param string $tagRightDelim the deliminator for the right of the page tag, default is "<"
     *      
     * @return string the html markup for the powerpoint presentation.            
     */
    public function getHTML($pageTag = "div", $tagLeftDelim = "<", $tagRightDelim = ">") {
        $markup = '';
        
        if($this->getnumberOfSlides() > 0) {
            foreach($this->slides as $slide) {
                $markup .= $tagLeftDelim . $pageTag . $tagRightDelim . $slide->getHTML() . $tagLeftDelim . "/" . $pageTag . $tagRightDelim;
            }
        }
        
        return $markup;
    }         
    
    /**
     * Retreive the file for the Powerpoint instance.
     * 
     * @return string the file for the power point document. 
     * 
     * @see PowerPoint          
     */ 
    public function getfile() {
        return $this->file;
    }
    
    /**
     * Build the relationships for the presentation.
     * 
     * @see PowerPoint          
     */ 
    private function buildRelationships() {
        $xml = simplexml_load_file(Slide::FILE_SCHEME . $this->file . PRESENTATION_RELATIONSHIPS);

        if($xml === FALSE) {
            throw new Exception("Error opening file: " . Slide::FILE_SCHEME . $this->file . PRESENTATION_RELATIONSHIPS);
        }
        
        foreach ($xml->Relationship as $rel) {
            $relationship = new Relationship();
        
            $relationship->id = (string)$rel['Id'];
            $relationship->type = (string)$rel['Type'];
            $relationship->target = (string)$rel['Target'];

            $this->relationships[$relationship->id] = $relationship;
        }
    }


    
    /**
     * Build the masters for the presentation. 
     * 
     * @see PowerPoint          
     */ 
    private function buildMasters() {
    
    }
    
    /**
     * Build the slides for the presentation 
     * 
     * @see PowerPoint          
     */ 
    private function buildPresentation() {
        $xml = simplexml_load_file(Slide::FILE_SCHEME . $this->file . PRESENTATION);
        
        if($xml === FALSE) {
            throw new Exception("Error opening file: " . Slide::FILE_SCHEME . $this->file . PRESENTATION);
        }

        // iterate through the presentation structure 
        $entries = $xml->children('p', TRUE);
        foreach ($entries as $entry) {
            switch($entry->getName()) {
                 case 'sldMasterIdLst':
                      // slide master id list
                      $this->processMasterIdList($entry);
                       break;
                 case 'sldIdLst':
                      // slide id list
                      // processSlideIdList($entry);
                      $this->processSlideIdList($entry);
                       break;
                 case 'sldSz':
                      // ???
                       break;
                 case 'notesSz':
                      // ???
                       break;
                 case 'defaultTextStyle':
                      // default text styles
                      // processDefaultTextStyles();  
                      // this will most prob have things like font size, hanging indent, etc.
                      // may not be required as not editing slides, just extracting 
                       break;
                  default:
                       // unknown type, so ignore
            }
        }
        /*
         * the following is the old code which has been replaced with the above foreach/switch.
         * when fully implemented, remove the following (kept for reference purposes). 
        // build slides
        $sldIdLst = $xml->children('p', TRUE)->sldIdLst->children('p', TRUE)->sldId;
        $this->slides = array();
        
        foreach ($sldIdLst as $sldId) {
            $attributes = $sldId->attributes();
            $attributes2 = $sldId->attributes("r", 1);
            
            $id = (string) $attributes->id;
            $rid = (string) $attributes2->id;
            
            $slideId = (string) $attributes->id;
            $slideFilename = $this->relationships[(string) $attributes2->id]->target;

            $slide = new Slide($this, $slideId, $slideFilename);
            
            $slide->build();
            
            $this->slides[] = $slide;
        }
         */
        foreach($this->masters as $master) {
            $master->build();
        }
        foreach($this->slides as $slide) {
            $slide->build();
        }
    }

    /**
     * Builds the slides
     * 
     * @param object $slideIdsNodes
     */
    private function processSlideIdList($slideIdsNodes) {
        foreach($slideIdsNodes->children("p", TRUE) as $slideIdNode) {
            if($slideIdNode->getName() === 'sldId') {
                $attributes = $slideIdNode->attributes();
                $attributes2 = $slideIdNode->attributes("r", 1);

                $slideId = (string) $attributes->id;
                $slideFilename = $this->relationships[(string) $attributes2->id]->target;
                // echo "slide - id: " . $slideId . " filename: " . $slideFilename . "<br>";
                $this->slides[] = new Slide($this, $slideId, $slideFilename);
            }
        }
    }
    
    /**
     * Builds the masters from the master ids node
     * 
     * @param object $masterIdsNodes the master ids node
     */
    private function processMasterIdList($masterIdsNodes) {
        foreach($masterIdsNodes->children("p", TRUE) as $masterIdNode) {
            if($masterIdNode->getName() === 'sldMasterId') {
                $attributes = $masterIdNode->attributes();
                $attributes2 = $masterIdNode->attributes("r", 1);

                $masterId = (string) $attributes->id;
                $masterFilename = $this->relationships[(string) $attributes2->id]->target;
                $this->masters[] = new Master($this, $masterId, $masterFilename);
                // echo "master - id: " . $masterId . " rid: " . (string) $attributes2->id . " filename: " . $masterFilename . "<br>"; 
            }
        }
    }
    
    /**
     * Get the target from the relatiomnships based on the specified id 
     * 
     * @param string $id the id to lookup to find the correct relationships
     * @return target the target that is mapped to the specified id
     *            
     * @see buildRelationships          
     */ 
    protected function getTarget($id) {
        return $relationships[$id]->target;
    }
}

echo "PowerPoint.php - 3<br>";
?>
