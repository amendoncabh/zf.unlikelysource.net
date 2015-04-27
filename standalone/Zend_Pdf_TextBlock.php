<?php
/**
 * Zend Framework
 *
 * LICENSE
 *
 * This source file is subject to the new BSD license that is bundled
 * with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://framework.zend.com/license/new-bsd
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please send an email
 * to license@zend.com so we can send you a copy immediately.
 *
 * @package    Zend_Pdf
 * @copyright  Copyright (c) 2005-2009 Zend Technologies USA Inc. (http://www.zend.com)
 * @license    http://framework.zend.com/license/new-bsd     New BSD License
 */

/** Zend_Pdf */
require_once 'Zend/Pdf.php';

/**
 * PDF Page
 *
 * @package    Zend_Pdf_TextBlock
 * @copyright  Copyright (c) 2005-2009 Zend Technologies USA Inc. (http://www.zend.com)
 * @license    http://framework.zend.com/license/new-bsd     New BSD License
 * @modified   2011-06-30 doug@unlikelysource.com
 */
class Zend_Pdf_TextBlock
{
  /**** Class Constants ****/


  /*  Cursor Directions */

    /**
     * Move cursor from left to right.
     */
    const CURSOR_DIRECTION_LEFT  = 'left';

    /**
     * Move cursor from right to left.
     */
    const CURSOR_DIRECTION_RIGHT = 'right';
    
  /* Text Block Alignment */
    
    /**
     * Left align text block.
     */
    const ALIGN_LEFT    = 'left';

    /**
     * Right align text block.
     */
    const ALIGN_RIGHT   = 'right';

    /**
     * Center text block.
     */
    const ALIGN_CENTER  = 'center';

    /**
     * Justify text in block.
     */
    const ALIGN_JUSTIFY = 'justify';


    /**
     * Reference to the object with page dictionary.
     *
     * @var Zend_Pdf_Element_Reference
     */
    protected $_pageDictionary;

    /**
     * PDF objects factory.
     *
     * @var Zend_Pdf_ElementFactory_Interface
     */
    protected $_objFactory = null;

    /**
     * Flag which signals, that page is created separately from any PDF document or
     * attached to anyone.
     *
     * @var boolean
     */
    protected $_attached;

    /**
     * Stream of the drawing instractions.
     *
     * @var string
     */
    protected $_contents = '';

    /**
     * Current style
     *
     * @var Zend_Pdf_Style
     */
    protected $_style = null;

    /**
     * Counter for the "Save" operations
     *
     * @var integer
     */
    protected $_saveCount = 0;

    /**
     * Safe Graphics State semafore
     *
     * If it's false, than we can't be sure Graphics State is restored withing
     * context of previous contents stream (ex. drawing coordinate system may be rotated).
     * We should encompass existing content with save/restore GS operators
     *
     * @var boolean
     */
    protected $_safeGS;

    /**
     * Current font
     *
     * @var Zend_Pdf_Resource_Font
     */
    protected $_font = null;

    /**
     * Current font size
     *
     * @var float
     */
    protected $_fontSize;

    /**
     * x position when the cursor was set. Used after line wrapping.
     */
    protected $_cursor_original_x = 0;
    
    /**
     * Current x position of cursor.
     */
    protected $_cursor_x = 0;

    /**
     * Current y position of cursor.
     */
    protected $_cursor_y = 0;
    
    /**
     * Set cursor direction.
     */
    protected $_cursor_direction = self::CURSOR_DIRECTION_LEFT;
    
    /**
     * Block width for text cursor.
     */
    protected $_cursor_width = 0;


    /**
     * Get current font.
     *
     * @return Zend_Pdf_Resource_Font $font
     */
    public function getFont()
    {
        return $this->_font;
    }

    /**
     * Extract resources attached to the page
     *
     * This method is not intended to be used in userland, but helps to optimize some document wide operations
     *
     * returns array of Zend_Pdf_Element_Dictionary objects
     *
     * @internal
     * @return array
     */
    public function extractResources()
    {
        return $this->_pageDictionary->Resources;
    }

    /**
     * Extract fonts attached to the page
     *
     * returns array of Zend_Pdf_Resource_Font_Extracted objects
     *
     * @return array
     */
    public function extractFonts()
    {
        if ($this->_pageDictionary->Resources->Font === null) {
            // Page doesn't have any font attached
            // Return empty array
            return array();
        }

        $fontResources = $this->_pageDictionary->Resources->Font;

        $fontResourcesUnique = array();
        foreach ($fontResources->getKeys() as $fontResourceName) {
            $fontDictionary = $fontResources->$fontResourceName;

            if (! ($fontDictionary instanceof Zend_Pdf_Element_Reference  ||
                   $fontDictionary instanceof Zend_Pdf_Element_Object) ) {
                // Font dictionary has to be an indirect object or object reference
                continue;
            }

            $fontResourcesUnique[$fontDictionary->toString($this->_objFactory)] = $fontDictionary;
        }

        $fonts = array();
        require_once 'Zend/Pdf/Exception.php';
        foreach ($fontResourcesUnique as $resourceReference => $fontDictionary) {
            try {
                // Try to extract font
                $extractedFont = new Zend_Pdf_Resource_Font_Extracted($fontDictionary);

                $fonts[$resourceReference] = $extractedFont;
            } catch (Zend_Pdf_Exception $e) {
                if ($e->getMessage() != 'Unsupported font type.') {
                    throw $e;
                }
            }
        }

        return $fonts;
    }

    /**
     * Extract font attached to the page by specific font name
     *
     * $fontName should be specified in UTF-8 encoding
     *
     * @return Zend_Pdf_Resource_Font_Extracted|null
     */
    public function extractFont($fontName)
    {
        if ($this->_pageDictionary->Resources->Font === null) {
            // Page doesn't have any font attached
            return null;
        }

        $fontResources = $this->_pageDictionary->Resources->Font;

        require_once 'Zend/Pdf/Exception.php';
        foreach ($fontResources->getKeys() as $fontResourceName) {
            $fontDictionary = $fontResources->$fontResourceName;

            if (! ($fontDictionary instanceof Zend_Pdf_Element_Reference  ||
                   $fontDictionary instanceof Zend_Pdf_Element_Object) ) {
                // Font dictionary has to be an indirect object or object reference
                continue;
            }

            if ($fontDictionary->BaseFont->value != $fontName) {
                continue;
            }

            try {
                // Try to extract font
                return new Zend_Pdf_Resource_Font_Extracted($fontDictionary);
            } catch (Zend_Pdf_Exception $e) {
                if ($e->getMessage() != 'Unsupported font type.') {
                    throw $e;
                }

                // Continue searhing font with specified name
            }
        }

        return null;
    }

    /**
     * Get current font size
     *
     * @return float $fontSize
     */
    public function getFontSize()
    {
        return $this->_fontSize;
    }

    /**
     * Calculate the width for the given string.
     *
     * @param string $string
     * @param string $charset charset of the string
     * @return int width of string
     */
    public function widthForString($string, $charset = 'ISO-8859-1') {
        $drawingString = iconv($charset, 'UTF-16BE//IGNORE', $string);
        $characters = array();
        for ($i = 0; $i < strlen($drawingString); $i++) {
            $characters[] = (ord($drawingString[$i++]) << 8) | ord($drawingString[$i]);
        }

        $glyphs = $this->_font->glyphNumbersForCharacters($characters);
        $widths = $this->_font->widthsForGlyphs($glyphs);

        $stringWidth = (array_sum($widths) / $this->_font->getUnitsPerEm()) * $this->_fontSize;      
        return $stringWidth;
    }

    /**
     * Get height of one or more line(s) in with current font and font size.
     *
     * @param int $lines number of lines
     * @param int $extraSpacing spaceing between lines
     * @return int line height
     */
    public function getLineHeight($lines = 1, $extraSpacing = 1) {
        return $lines * $this->_fontSize * $this->_font->getLineHeight() / $this->_font->getUnitsPerEm() + $extraSpacing;
    }

    /**
     * Set position of text cursor.
     *
     * @param int $x x position
     * @param int $y y position
     * @return Zend_Pdf_Page fluid interface
     */
    public function setTextCursor($x = null, $y = null) {
        if ($x !== null) {
            $this->_cursor_original_x = $x;
            $this->_cursor_x = $x;
        }
        if ($y !== null) {
            $this->_cursor_y = $y;
        }
        
        return $this;
    }
    
    /**
     * Move text cursor in relation to current position
     *
     * @param float $x_offset x offset
     * @param float $y_offset y offset
     * @return Zend_Pdf_Page fluid interface
     */ 
    public function textCursorMove($x_offset = null, $y_offset = null) { 
        if ($x_offset !== null) {
            $this->_cursor_x += $x_offset;
        }
        if ($y_offset !== null) {
            $this->_cursor_y += $y_offset;
        }
        
        return $this;
    }
    
    /**
     * Set width of block used for cursor. If the width is reached a newline is started.
     * Wrapping happens at whitespace.
     *
     * @param float|null $width block width. null to deactivate
     * @return Zend_Pdf_Page fluid interface
     */ 
    public function setTextCursorWidth($width) {
        $this->_cursor_width = $width;
        return $this;
    }
    
    /**
     * Start a newline. The x position is reset and line height is added to the y position
     * 
     * @return Zend_Pdf_Page fluid interface
     */ 
    public function textCursorNewline() { 
        $this->setTextCursor($this->_cursor_original_x);
        $this->textCursorMove(null, -$this->getLineHeight());
        return $this;
    }

    /**
     * Set if cursor moves from left to right or from right to left
     * 
     * @param string $direction self::CURSOR_DIRECTION_LEFT or self::CURSOR_DIRECTION_RIGHT
     * @return Zend_Pdf_Page fluid interface
     */ 
    public function setTextCursorDirection($direction) { 
        $this->_cursor_direction = $direction;
        return $this;
    }

    /**
     * Helper method to wrap text to lines. The wrapping is done at whitespace if the text gets longer
     * as $width.
     * 
     * @param string $text the text to wrap
     * @param int $width
     * @param int $initial_line_offset x offset for start position in first line
     * @return array array with lines as array('words' => array(...), 'word_lengths' => array(...), 'total_length' => <int>)
     */
    protected function _wrapText($text, $width, $initial_line_offset = 0) {
        $lines = array();
        $line_init = array(
            'words'        => array(),
            'word_lengths' => array(),
            'total_length' => 0
        );
        $line = $line_init;
        $line['total_length'] = $initial_line_offset;
        
        $text = preg_split('%[\n\r ]+%', $text, -1, PREG_SPLIT_NO_EMPTY);
        $space_length = $this->widthForString(' ');
        foreach ($text as $word) {
            $word_length = $this->widthForString($word);
            if ($word_length > $width) {
                if ($line['words']) {
                    $lines[] = $line;
                }
                $lines[] = array(
                    'words'        => array($word),
                    'word_lengths' => array($word_length),
                    'total_length' => array($word_length)
                );
                $line = $line_init;
                continue;
            }
            if ($line['total_length'] + $word_length > $width) {
                $line['total_length'] -= $space_length;
                $lines[] = $line;
                $line = $line_init;
            }
            $line['words'][]        = $word;
            $line['word_lengths'][] = $word_length;
            $line['total_length']  += $word_length + $space_length;
        }
        if ($line) {
            $line['total_length'] -= $space_length;
            $lines[] = $line;
        }
        
        return $lines;
    }
    
    /**
     * Draw a text in a block with a fixed width and an optional fixed height. The text can be left or right
     * aligned, centered of justified. If height is given, but the text would be longer an exception is thrown.
     *
     * This method may also be called as drawTextBlock($text, $width). The block is than drawn to the current
     * cursor position.
     *
     * @param Zend_Pdf_Page $page
     * @param string $text
     * @param int $x x position
     * @param int $y y position
     * @param int $width block width
     * @param int|null $height optional height to check for
     * @param string $align one of: self::ALIGN_LEFT, self::ALIGN_RIGHT, self::ALIGN_CENTER, self::ALIGN_JUSTIFY
     * @throws Zend_Pdf_Exception
     */
    public function drawTextBlock($page, $text, $x, $y = null, $width = null, $height = null, $align = self::ALIGN_LEFT) {
        if ($width === null) {
            $widht = $x;
            $this->textCursorNewline();
            $x = $this->_cursor_x;
            $y = $this->_cursor_y;
        }
        
        $lines = $this->_wrapText($text, $width);   
        
        if ($height !== null && $this->getLineHeight(count($lines)) > $height) {
            throw new Zend_Pdf_Exception('height overflow');
        }
        $line_height = $this->getLineHeight();
        foreach ($lines as $k => $line) {
            switch($align) {
                case self::ALIGN_JUSTIFY:
                    if (count($line['words']) < 2 || $k == count($lines) - 1) {
                        $this->drawText(implode(' ', $line['words']), $x, $y);
                        break;                      
                    }
                    $space_width = ($width - array_sum($line['word_lengths'])) / (count($line['words']) - 1);
                    $pos = $x;
                    foreach ($line['words'] as $k => $word) {
                        $this->drawText($word, $pos, $y);
                        $pos += $line['word_lengths'][$k] + $space_width;
                    }
                    break;
                case self::ALIGN_CENTER:
                    $this->drawText(implode(' ', $line['words']), $x + ($width - $line['total_length']) / 2, $y);
                    break;
                case self::ALIGN_RIGHT:
                    $this->drawText(implode(' ', $line['words']), $x + $width - $line['total_length'], $y);
                    break;
                case self::ALIGN_LEFT:
                default:
                    $this->drawText(implode(' ', $line['words']), $x, $y);
                    break;
            }
            $y -= $line_height;
        }
    }
}

