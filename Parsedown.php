<?php
//
//
// Parsedown
// http://parsedown.org
//
// (c) Emanuil Rusev
// http://erusev.com
//
// For the full license information, view the LICENSE file that was distributed
// with this source code.
//
//

class Parsedown
{
    # ~
    const version = '1.7.4';
    # ~
    function text($text)
    {
        $Elements = $this->textElements($text);
        $markup = $this->elements($Elements);
        $markup = trim($markup, "\n");
        return $markup;
    }
    protected function textElements($text)
    {
        $this->DefinitionData = array();
        $text = str_replace(array("\r\n", "\r"), "\n", $text);
        $text = trim($text, "\n");
        $lines = explode("\n", $text);
        return $this->linesElements($lines);
    }
    #
    # Elements
    #
    protected $BlockTypes = array(
        '#' => array('Header'),
        '*' => array('Rule', 'List'),
        '+' => array('List'),
        '-' => array('SetextHeader', 'Table', 'Rule', 'List'),
        '0' => array('List'),
        '1' => array('List'),
        '2' => array('List'),
        '3' => array('List'),
        '4' => array('List'),
        '5' => array('List'),
        '6' => array('List'),
        '7' => array('List'),
        '8' => array('List'),
        '9' => array('List'),
        ':' => array('Table'),
        '<' => array('Comment', 'Markup'),
        '=' => array('SetextHeader'),
        '>' => array('Quote'),
        '[' => array('Reference'),
        '_' => array('Rule'),
        '`' => array('FencedCode'),
        '|' => array('Table'),
        '~' => array('FencedCode'),
    );
    protected $unmarkedBlockTypes = array(
        'Code',
    );
    #
    # Blocks
    #
    protected function lines(array $lines)
    {
        return $this->elements($this->linesElements($lines));
    }
    protected function linesElements(array $lines)
    {
        $Elements = array();
        $CurrentBlock = null;
        foreach ($lines as $line)
        {
            if (chop($line) === '')
            {
                if (isset($CurrentBlock))
                {
                    $CurrentBlock['interrupted'] = true;
                }
                continue;
            }
            if (strpos($line, "\t") !== false)
            {
                $parts = explode("\t", $line);
                $line = $parts[0];
                unset($parts[0]);
                foreach ($parts as $part)
                {
                    $shortage = 4 - mb_strlen($line, 'utf-8') % 4;
                    $line .= str_repeat(' ', $shortage);
                    $line .= $part;
                }
            }
            $indent = 0;
            while (isset($line[$indent]) and $line[$indent] === ' ')
            {
                $indent ++;
            }
            $text = $indent > 0 ? substr($line, $indent) : $line;
            # ~
            $Line = array('body' => $line, 'indent' => $indent, 'text' => $text);
            # ~
            if (isset($CurrentBlock['continuable']))
            {
                $Block = $this->{'block'.$CurrentBlock['type'].'Continue'}($Line, $CurrentBlock);
                if (isset($Block))
                {
                    $CurrentBlock = $Block;
                    continue;
                }
                else
                {
                    if ($this->isBlockCompletable($CurrentBlock['type']))
                    {
                        $CurrentBlock = $this->{'block'.$CurrentBlock['type'].'Complete'}($CurrentBlock);
                    }
                }
            }
            # ~
            $marker = $text[0];
            # ~
            $BlockTypes = $this->unmarkedBlockTypes;
            if (isset($this->BlockTypes[$marker]))
            {
                foreach ($this->BlockTypes[$marker] as $blockType)
                {
                    $BlockTypes []= $blockType;
                }
            }
            # ~
            foreach ($BlockTypes as $blockType)
            {
                $Block = $this->{'block'.$blockType}($Line, $CurrentBlock);
                if (isset($Block))
                {
                    $Block['type'] = $blockType;
                    if ( ! isset($Block['identified']))
                    {
                        $Elements []= $CurrentBlock;
                        $Block['identified'] = true;
                    }
                    if ($this->isBlockContinuable($blockType))
                    {
                        $Block['continuable'] = true;
                    }
                    $CurrentBlock = $Block;
                    continue 2;
                }
            }
            # ~
            if (isset($CurrentBlock) and ! isset($CurrentBlock['type']) and ! isset($CurrentBlock['interrupted']))
            {
                $CurrentBlock['element']['text'] .= "\n".$text;
            }
            else
            {
                $Elements []= $CurrentBlock;
                $CurrentBlock = $this->paragraph($Line);
                $CurrentBlock['identified'] = true;
            }
        }
        # ~
        if (isset($CurrentBlock['continuable']) and $this->isBlockCompletable($CurrentBlock['type']))
        {
            $CurrentBlock = $this->{'block'.$CurrentBlock['type'].'Complete'}($CurrentBlock);
        }
        # ~
        $Elements []= $CurrentBlock;
        unset($Elements[0]);
        # ~
        return $Elements;
    }
    protected function isBlockContinuable($Type)
    {
        return method_exists($this, 'block'.$Type.'Continue');
    }
    protected function isBlockCompletable($Type)
    {
        return method_exists($this, 'block'.$Type.'Complete');
    }
    #
    # Code
    protected function blockCode($Line, $Block = null)
    {
        if (isset($Block) and ! isset($Block['type']) and ! isset($Block['interrupted']))
        {
            return;
        }
        if ($Line['indent'] >= 4)
        {
            $text = substr($Line['body'], 4);
            $Block = array(
                'element' => array(
                    'name' => 'pre',
                    'handler' => 'element',
                    'text' => array(
                        'name' => 'code',
                        'text' => $text,
                    ),
                ),
            );
            return $Block;
        }
    }
    protected function blockCodeContinue($Line, $Block)
    {
        if ($Line['indent'] >= 4)
        {
            if (isset($Block['interrupted']))
            {
                $Block['element']['text']['text'] .= "\n";
                unset($Block['interrupted']);
            }
            $text = substr($Line['body'], 4);
            $Block['element']['text']['text'] .= "\n".$text;
            return $Block;
        }
    }
    protected function blockCodeComplete($Block)
    {
        $text = $Block['element']['text']['text'];
        $Block['element']['text']['text'] = $text;
        return $Block;
    }
    #
    # Comment
    protected function blockComment($Line)
    {
        if ($this->markupEscaped or $this->safeMode)
        {
            return;
        }
        if (strpos($Line['text'], '<!--') === 0)
        {
            $Block = array(
                'markup' => $Line['body'],
            );
            if (strpos($Line['text'], '-->') !== false)
            {
                $Block['closed'] = true;
            }
            return $Block;
        }
    }
    protected function blockCommentContinue($Line, array $Block)
    {
        if (isset($Block['closed']))
        {
            return;
        }
        $Block['markup'] .= "\n" . $Line['body'];
        if (strpos($Line['text'], '-->') !== false)
        {
            $Block['closed'] = true;
        }
        return $Block;
    }
    #
    # Fenced Code
    protected function blockFencedCode($Line)
    {
        if (preg_match('/^['.$Line['text'][0].']{3,}[ ]*([\w-]+)?[ ]*$/', $Line['text'], $matches))
        {
            $Element = array(
                'name' => 'code',
                'text' => '',
            );
            if (isset($matches[1]))
            {
                $class = 'language-'.$matches[1];
                $Element['attributes'] = array(
                    'class' => $class,
                );
            }
            $Block = array(
                'char' => $Line['text'][0],
                'element' => array(
                    'name' => 'pre',
                    'handler' => 'element',
                    'text' => $Element,
                ),
            );
            return $Block;
        }
    }
    protected function blockFencedCodeContinue($Line, $Block)
    {
        if (isset($Block['complete']))
        {
            return;
        }
        if (isset($Block['interrupted']))
        {
            $Block['element']['text']['text'] .= "\n";
            unset($Block['interrupted']);
        }
        if (preg_match('/^'.$Block['char'].'{3,}[ ]*$/', $Line['text']))
        {
            $Block['element']['text']['text'] = substr($Block['element']['text']['text'], 1);
            $Block['complete'] = true;
            return $Block;
        }
        $Block['element']['text']['text'] .= "\n".$Line['body'];
        return $Block;
    }
    protected function blockFencedCodeComplete($Block)
    {
        $text = $Block['element']['text']['text'];
        $Block['element']['text']['text'] = $text;
        return $Block;
    }
    #
    # Header
    protected function blockHeader($Line)
    {
        if (isset($Line['text'][1]))
        {
            $level = 1;
            while (isset($Line['text'][$level]) and $Line['text'][$level] === '#')
            {
                $level ++;
            }
            if ($level > 6)
            {
                return;
            }
            $text = trim($Line['text'], '# ');
            $Block = array(
                'element' => array(
                    'name' => 'h' . min(6, $level),
                    'text' => $text,
                    'handler' => 'line',
                ),
            );
            return $Block;
        }
    }
    #
    # List
    protected function blockList($Line)
    {
        list($name, $pattern) = $Line['text'][0] <= '-' ? array('ul', '[*+-]') : array('ol', '[0-9]+[.]');
        if (preg_match('/^('.$pattern.'[ ]+)(.*)/', $Line['text'], $matches))
        {
            $Block = array(
                'indent' => $Line['indent'],
                'pattern' => $pattern,
                'element' => array(
                    'name' => $name,
                    'elements' => array(),
                ),
            );
            if($name === 'ol')
            {
                $listStart = stristr($matches[0], '.', true);
                if($listStart !== '1')
                {
                    $Block['element']['attributes'] = array('start' => $listStart);
                }
            }
            $Block['li'] = array(
                'name' => 'li',
                'handler' => 'li',
                'text' => array(
                    $matches[2],
                ),
            );
            $Block['element']['elements'] []= & $Block['li'];
            return $Block;
        }
    }
    protected function blockListContinue($Line, array $Block)
    {
        if ($Block['indent'] === $Line['indent'] and preg_match('/^'.$Block['pattern'].'[ ]+(.*)/', $Line['text'], $matches))
        {
            if (isset($Block['interrupted']))
            {
                $Block['li']['text'] []= '';
                unset($Block['interrupted']);
            }
            unset($Block['li']);
            $Block['li'] = array(
                'name' => 'li',
                'handler' => 'li',
                'text' => array(
                    $matches[1],
                ),
            );
            $Block['element']['elements'] []= & $Block['li'];
            return $Block;
        }
        if ( ! isset($Block['interrupted']))
        {
            $text = substr($Line['body'], $Block['indent']);
            $Block['li']['text'] []= $text;
            return $Block;
        }
        if ($Line['indent'] > 0)
        {
            $Block['li']['text'] []= '';
            $text = substr($Line['body'], $Block['indent']);
            $Block['li']['text'] []= $text;
            unset($Block['interrupted']);
            return $Block;
        }
    }
    #
    # Quote
    protected function blockQuote($Line)
    {
        if (preg_match('/^>[ ]?(.*)/', $Line['text'], $matches))
        {
            $Block = array(
                'element' => array(
                    'name' => 'blockquote',
                    'handler' => 'lines',
                    'text' => (array) $matches[1],
                ),
            );
            return $Block;
        }
    }
    protected function blockQuoteContinue($Line, array $Block)
    {
        if ($Line['text'][0] === '>' and preg_match('/^>[ ]?(.*)/', $Line['text'], $matches))
        {
            if (isset($Block['interrupted']))
            {
                $Block['element']['text'] []= '';
                unset($Block['interrupted']);
            }
            $Block['element']['text'] []= $matches[1];
            return $Block;
        }
        if ( ! isset($Block['interrupted']))
        {
            $Block['element']['text'] []= $Line['text'];
            return $Block;
        }
    }
    #
    # Rule
    protected function blockRule($Line)
    {
        if (preg_match('/^(['.$Line['text'][0].'])([ ]*\1){2,}[ ]*$/', $Line['text']))
        {
            $Block = array(
                'element' => array(
                    'name' => 'hr',
                ),
            );
            return $Block;
        }
    }
    #
    # Setext
    protected function blockSetextHeader($Line, array $Block = null)
    {
        if ( ! isset($Block) or isset($Block['type']) or isset($Block['interrupted']))
        {
            return;
        }
        if (chop($Line['text'], $Line['text'][0]) === '')
        {
            $Block['element']['name'] = $Line['text'][0] === '=' ? 'h1' : 'h2';
            return $Block;
        }
    }
    #
    # Markup
    protected function blockMarkup($Line)
    {
        if ($this->markupEscaped or $this->safeMode)
        {
            return;
        }
        if (preg_match('/^<(\w[\w-]*)(?:[ ]*'.$this->regexHtmlAttribute.')*[ ]*(\/?)>/', $Line['text'], $matches))
        {
            $element = strtolower($matches[1]);
            if (in_array($element, $this->textLevelElements))
            {
                return;
            }
            $Block = array(
                'name' => $matches[1],
                'depth' => 0,
                'markup' => $Line['text'],
            );
            $length = strlen($matches[0]);
            $remainder = substr($Line['text'], $length);
            if (trim($remainder) === '')
            {
                if (isset($matches[2]) or in_array($matches[1], $this->voidElements))
                {
                    $Block['closed'] = true;
                    $Block['void'] = true;
                }
            }
            else
            {
                if (preg_match('/<\/'.$matches[1].'>[ ]*$/i', $remainder))
                {
                    $Block['closed'] = true;
                }
            }
            return $Block;
        }
    }
    protected function blockMarkupContinue($Line, array $Block)
    {
        if (isset($Block['closed']))
        {
            return;
        }
        if (preg_match('/^<'.$Block['name'].'(?:[ ]*'.$this->regexHtmlAttribute.')*[ ]*>/i', $Line['text'])) # open
        {
            $Block['depth'] ++;
        }
        if (preg_match('/(.*?)<\/'.$Block['name'].'>/i', $Line['text'], $matches)) # close
        {
            if ($Block['depth'] > 0)
            {
                $Block['depth'] --;
            }
            else
            {
                $Block['closed'] = true;
            }
        }
        if (isset($Block['interrupted']))
        {
            $Block['markup'] .= "\n";
            unset($Block['interrupted']);
        }
        $Block['markup'] .= "\n".$Line['body'];
        return $Block;
    }
    #
    # Reference
    protected function blockReference($Line)
    {
        if (preg_match('/^\[(.+?)\]:[ ]*<?(\S+?)>?(?:[ ]+["\'(](.+)["\')])?[ ]*$/', $Line['text'], $matches))
        {
            $id = strtolower($matches[1]);
            $Data = array(
                'url' => $matches[2],
                'title' => null,
            );
            if (isset($matches[3]))
            {
                $Data['title'] = $matches[3];
            }
            $this->DefinitionData['Reference'][$id] = $Data;
            $Block = array(
                'hidden' => true,
            );
            return $Block;
        }
    }
    #
    # Table
    protected function blockTable($Line, array $Block = null)
    {
        if ( ! isset($Block) or isset($Block['type']) or isset($Block['interrupted']))
        {
            return;
        }
        if (strpos($Block['element']['text'], '|') !== false and chop($Line['text'], ' -:|') === '')
        {
            $alignments = array();
            $divider = $Line['text'];
            $divider = trim($divider);
            $divider = trim($divider, '|');
            $dividerCells = explode('|', $divider);
            foreach ($dividerCells as $dividerCell)
            {
                $dividerCell = trim($dividerCell);
                if ($dividerCell === '')
                {
                    continue;
                }
                $alignment = null;
                if ($dividerCell[0] === ':')
                {
                    $alignment = 'left';
                }
                if (substr($dividerCell, - 1) === ':')
                {
                    $alignment = $alignment === 'left' ? 'center' : 'right';
                }
                $alignments []= $alignment;
            }
            # ~
            $HeaderElements = array();
            $header = $Block['element']['text'];
            $header = trim($header);
            $header = trim($header, '|');
            $headerCells = explode('|', $header);
            foreach ($headerCells as $index => $headerCell)
            {
                $headerCell = trim($headerCell);
                $HeaderElement = array(
                    'name' => 'th',
                    'text' => $headerCell,
                    'handler' => 'line',
                );
                if (isset($alignments[$index]))
                {
                    $alignment = $alignments[$index];
                    $HeaderElement['attributes'] = array(
                        'style' => 'text-align: '.$alignment.';',
                    );
                }
                $HeaderElements []= $HeaderElement;
            }
            # ~
            $Block = array(
                'alignments' => $alignments,
                'identified' => true,
                'element' => array(
                    'name' => 'table',
                    'elements' => array(),
                ),
            );
            $Block['element']['elements'] []= array(
                'name' => 'thead',
                'elements' => array(),
            );
            $Block['element']['elements'] []= array(
                'name' => 'tbody',
                'elements' => array(),
            );
            $Block['element']['elements'][0]['elements'] []= array(
                'name' => 'tr',
                'elements' => $HeaderElements,
            );
            return $Block;
        }
    }
    protected function blockTableContinue($Line, array $Block)
    {
        if (isset($Block['interrupted']))
        {
            return;
        }
        $row = $Line['text'];
        $row = trim($row);
        $row = trim($row, '|');
        $cells = explode('|', $row);
        $RowElements = array();
        foreach ($cells as $index => $cell)
        {
            $cell = trim($cell);
            $RowElement = array(
                'name' => 'td',
                'text' => $cell,
                'handler' => 'line',
            );
            if (isset($Block['alignments'][$index]))
            {
                $alignment = $Block['alignments'][$index];
                $RowElement['attributes'] = array(
                    'style' => 'text-align: '.$alignment.';',
                );
            }
            $RowElements []= $RowElement;
        }
        $RowElement = array(
            'name' => 'tr',
            'elements' => $RowElements,
        );
        $Block['element']['elements'][1]['elements'] []= $RowElement;
        return $Block;
    }
    #
    # ~
    #
    protected function paragraph($Line)
    {
        $Block = array(
            'element' => array(
                'name' => 'p',
                'text' => $Line['text'],
                'handler' => 'line',
            ),
        );
        return $Block;
    }
    #
    # Inlines
    #
    protected $InlineTypes = array(
        '"' => array('Quote'),
        '!' => array('Image'),
        '&' => array('SpecialCharacter'),
        '*' => array('Emphasis'),
        ':' => array('Url'),
        '<' => array('UrlTag', 'EmailTag', 'Markup'),
        '[' => array('Link'),
        '_' => array('Emphasis'),
        '`' => array('Code'),
        '~' => array('Strikethrough'),
        '\\' => array('EscapeSequence'),
    );
    protected $inlineMarkerList = '!"*_&[:<`~\\';
    #
    # ~
    #
    public function line($text, $nonNestables = array())
    {
        return $this->elements($this->lineElements($text, $nonNestables));
    }
    protected function lineElements($text, $nonNestables = array())
    {
        $Elements = array();
        $nonNestables = (empty($nonNestables)
            ? array()
            : array_flip($nonNestables)
        );
        # ~
        while ($excerpt = strpbrk($text, $this->inlineMarkerList))
        {
            $marker = $excerpt[0];
            $markerPosition = strpos($text, $marker);
            $Excerpt = array('text' => $excerpt, 'context' => $text);
            foreach ($this->InlineTypes[$marker] as $inlineType)
            {
                if (isset($nonNestables[$inlineType]))
                {
                    continue;
                }
                $Inline = $this->{'inline'.$inlineType}($Excerpt);
                if ( ! isset($Inline))
                {
                    continue;
                }
                if (isset($Inline['position']) and $Inline['position'] > $markerPosition)
                {
                    continue;
                }
                if ( ! isset($Inline['position']))
                {
                    $Inline['position'] = $markerPosition;
                }
                $nonNestables[$inlineType] = true;
                $unmarkedText = substr($text, 0, $Inline['position']);
                $Elements[] = $this->unmarkedText($unmarkedText);
                $Elements[] = $this->extractElement($Inline);
                $text = substr($text, $Inline['position'] + $Inline['extent']);
                continue 2;
            }
            $unmarkedText = substr($text, 0, $markerPosition + 1);
            $Elements[] = $this->unmarkedText($unmarkedText);
            $text = substr($text, $markerPosition + 1);
        }
        $Elements[] = $this->unmarkedText($text);
        return $Elements;
    }
    #
    # ~
    #
    protected function inlineCode($Excerpt)
    {
        $marker = $Excerpt['text'][0];
        if (preg_match('/^('.$marker.'+)(.+?)\1(?!\1)/s', $Excerpt['text'], $matches))
        {
            $text = $matches[2];
            $text = preg_replace('/[ ]{2,}/', ' ', $text);
            return array(
                'extent' => strlen($matches[0]),
                'element' => array(
                    'name' => 'code',
                    'text' => $text,
                ),
            );
        }
    }
    protected function inlineEmailTag($Excerpt)
    {
        if (strpos($Excerpt['text'], '>') !== false and preg_match('/^<((mailto:)?\S+?@\S+?)>/i', $Excerpt['text'], $matches))
        {
            $url = $matches[1];
            if ( ! isset($matches[2]))
            {
                $url = 'mailto:' . $url;
            }
            return array(
                'extent' => strlen($matches[0]),
                'element' => array(
                    'name' => 'a',
                    'text' => $matches[1],
                    'attributes' => array(
                        'href' => $url,
                    ),
                ),
            );
        }
    }
    protected function inlineEmphasis($Excerpt)
    {
        if ( ! isset($Excerpt['text'][1]))
        {
            return;
        }
        $marker = $Excerpt['text'][0];
        if ($Excerpt['text'][1] === $marker and preg_match($this->StrongRegex[$marker], $Excerpt['text'], $matches))
        {
            $emphasis = 'strong';
        }
        elseif (preg_match($this->EmRegex[$marker], $Excerpt['text'], $matches))
        {
            $emphasis = 'em';
        }
        else
        {
            return;
        }
        return array(
            'extent' => strlen($matches[0]),
            'element' => array(
                'name' => $emphasis,
                'handler' => 'line',
                'text' => $matches[1],
            ),
        );
    }
    protected function inlineEscapeSequence($Excerpt)
    {
        if (isset($Excerpt['text'][1]) and in_array($Excerpt['text'][1], $this->specialCharacters))
        {
            return array(
                'markup' => $Excerpt['text'][1],
                'extent' => 2,
            );
        }
    }
    protected function inlineImage($Excerpt)
    {
        if ( ! isset($Excerpt['text'][1]) or $Excerpt['text'][1] !== '[')
        {
            return;
        }
        $Excerpt['text']= substr($Excerpt['text'], 1);
        $Link = $this->inlineLink($Excerpt);
        if ($Link === null)
        {
            return;
        }
        $Inline = array(
            'extent' => $Link['extent'] + 1,
            'element' => array(
                'name' => 'img',
                'attributes' => array(
                    'src' => $Link['element']['attributes']['href'],
                    'alt' => $Link['element']['text'],
                ),
            ),
        );
        $Inline['element']['attributes'] += $Link['element']['attributes'];
        unset($Inline['element']['attributes']['href']);
        return $Inline;
    }
    protected function inlineLink($Excerpt)
    {
        $Element = array(
            'name' => 'a',
            'handler' => 'line',
            'nonNestables' => array('Url', 'Link'),
            'text' => null,
            'attributes' => array(
                'href' => null,
                'title' => null,
            ),
        );
        $extent = 0;
        $remainder = $Excerpt['text'];
        if (preg_match('/\[((?:[^][]|(?R))*)\]/', $remainder, $matches))
        {
            $Element['text'] = $matches[1];
            $extent += strlen($matches[0]);
            $remainder = substr($remainder, $extent);
        }
        else
        {
            return;
        }
        if (preg_match('/^\s*\( *<?((?:\([^)]*\)|[^ ()])*)>? *(".*?"|\'.*?\'|)? *\)/', $remainder, $matches))
        {
            $Element['attributes']['href'] = $matches[1];
            if (isset($matches[2]))
            {
                $Element['attributes']['title'] = substr($matches[2], 1, - 1);
            }
            $extent += strlen($matches[0]);
        }
        else
        {
            if (preg_match('/^\s*\[(.*?)\]/', $remainder, $matches))
            {
                $definition = strlen($matches[1]) ? $matches[1] : $Element['text'];
                $definition = strtolower($definition);
                $extent += strlen($matches[0]);
            }
            else
            {
                $definition = strtolower($Element['text']);
            }
            if ( ! isset($this->DefinitionData['Reference'][$definition]))
            {
                return;
            }
            $Definition = $this->DefinitionData['Reference'][$definition];
            $Element['attributes']['href'] = $Definition['url'];
            $Element['attributes']['title'] = $Definition['title'];
        }
        return array(
            'extent' => $extent,
            'element' => $Element,
        );
    }
    protected function inlineMarkup($Excerpt)
    {
        if ($this->markupEscaped or $this->safeMode or strpos($Excerpt['text'], '>') === false)
        {
            return;
        }
        if ($Excerpt['text'][1] === '/' and preg_match('/^<\/\w[\w-]*[ ]*>/', $Excerpt['text'], $matches))
        {
            return array(
                'markup' => $matches[0],
                'extent' => strlen($matches[0]),
            );
        }
        if ($Excerpt['text'][1] === '!' and preg_match('/^<!---?[^>-](?:-?+[^-])*-->/', $Excerpt['text'], $matches))
        {
            return array(
                'markup' => $matches[0],
                'extent' => strlen($matches[0]),
            );
        }
        if ($Excerpt['text'][1] !== ' ' and preg_match('/^<\w[\w-]*(?:[ ]*'.$this->regexHtmlAttribute.')*[ ]*\/?>/', $Excerpt['text'], $matches))
        {
            $element = strtolower(substr($matches[0], 1));
            if (in_array($element, $this->textLevelElements))
            {
                return array(
                    'markup' => $matches[0],
                    'extent' => strlen($matches[0]),
                );
            }
        }
    }
    protected function inlineQuote($Excerpt)
    {
        if (preg_match('/^"(?=\S)(.+?)(?<=\S)"/', $Excerpt['text'], $matches))
        {
            return array(
                'extent' => strlen($matches[0]),
                'element' => array(
                    'name' => 'q',
                    'handler' => 'line',
                    'text' => $matches[1],
                ),
            );
        }
    }
    protected function inlineSpecialCharacter($Excerpt)
    {
        if ($Excerpt['text'][1] !== ' ' and strpos($Excerpt['text'], ';') !== false
            and preg_match('/^&(#?x?[0-9a-f]+);/i', $Excerpt['text'], $matches)
        ) {
            return array(
                'markup' => $matches[0],
                'extent' => strlen($matches[0]),
            );
        }
    }
    protected function inlineStrikethrough($Excerpt)
    {
        if ( ! isset($Excerpt['text'][1]))
        {
            return;
        }
        if ($Excerpt['text'][1] === '~' and preg_match('/^~~(?=\S)(.+?)(?<=\S)~~/', $Excerpt['text'], $matches))
        {
            return array(
                'extent' => strlen($matches[0]),
                'element' => array(
                    'name' => 'del',
                    'text' => $matches[1],
                    'handler' => 'line',
                ),
            );
        }
    }
    protected function inlineUrl($Excerpt)
    {
        if ($this->urlsLinked !== true or ! isset($Excerpt['text'][2]) or $Excerpt['text'][2] !== '/')
        {
            return;
        }
        if (preg_match('/\bhttps?:[\/]{2}[^\s<]+\b\/*/ui', $Excerpt['context'], $matches, PREG_OFFSET_CAPTURE))
        {
            $Inline = array(
                'extent' => strlen($matches[0][0]),
                'position' => $matches[0][1],
                'element' => array(
                    'name' => 'a',
                    'text' => $matches[0][0],
                    'attributes' => array(
                        'href' => $matches[0][0],
                    ),
                ),
            );
            return $Inline;
        }
    }
    protected function inlineUrlTag($Excerpt)
    {
        if (strpos($Excerpt['text'], '>') !== false and preg_match('/^<(\w+:\/{2}[^ >]+)>/i', $Excerpt['text'], $matches))
        {
            $url = $matches[1];
            return array(
                'extent' => strlen($matches[0]),
                'element' => array(
                    'name' => 'a',
                    'text' => $url,
                    'attributes' => array(
                        'href' => $url,
                    ),
                ),
            );
        }
    }
    #
    # ~
    #
    protected function unmarkedText($text)
    {
        $text = $this->codeSpan($text);
        return array('markup' => $text);
    }
    #
    # Handlers
    #
    protected function element(array $Element)
    {
        $markup = '<'.$Element['name'];
        if (isset($Element['attributes']))
        {
            foreach ($Element['attributes'] as $name => $value)
            {
                if ($value === null)
                {
                    continue;
                }
                $markup .= ' '.$name.'="'.$this->escape($value).'"';
            }
        }
        if (isset($Element['text']))
        {
            $markup .= '>';
            if (isset($Element['handler']))
            {
                $markup .= $this->{$Element['handler']}($Element['text']);
            }
            else
            {
                $markup .= $this->escape($Element['text'], true);
            }
            $markup .= '</'.$Element['name'].'>';
        }
        else
        {
            $markup .= ' />';
        }
        return $markup;
    }
    protected function elements(array $Elements)
    {
        $markup = '';
        foreach ($Elements as $Element)
        {
            if ($Element === null)
            {
                continue;
            }
            if (isset($Element['hidden']))
            {
                continue;
            }
            $markup .= "\n";
            if (isset($Element['markup']))
            {
                $markup .= $Element['markup'];
            }
            elseif(isset($Element['name']))
            {
                $markup .= $this->element($Element);
            }
            else
            {
                $markup .= $this->element($Element['element']);
            }
        }
        $markup .= "\n";
        return $markup;
    }
    protected function li($lines)
    {
        $markup = $this->lines($lines);
        $trimmedMarkup = trim($markup);
        if ( ! in_array('', $lines) and substr($trimmedMarkup, 0, 3) === '<p>')
        {
            $markup = $trimmedMarkup;
            $markup = substr($markup, 3);
            $markup = substr($markup, 0, - 4);
        }
        return $markup;
    }
    #
    # Util
    #
    protected function escape($text, $allowQuotes = false)
    {
        return htmlspecialchars($text, $allowQuotes ? ENT_NOQUOTES : ENT_QUOTES, 'UTF-8');
    }
    protected $voidElements = array(
        'area', 'base', 'br', 'col', 'command', 'embed', 'hr', 'img', 'input', 'keygen', 'link', 'meta', 'param', 'source', 'track', 'wbr',
    );
    protected $textLevelElements = array(
        'a', 'br', 'bdo', 'abbr', 'blink', 'nextid', 'acronym', 'ins',
        'cite', 'em', 'dfn', 'i', 'kbd', 'strong', 'samp', 'var',
        'del', 'b', 'code', 'q', 'select', 'small', 'sub', 'sup',
        'textarea', 'label', 'map', 'object', 'span', 'img',
        'input', 'button'
    );
    #
    # ~
    #
    protected $DefinitionData;
    #
    # Read-Only
    #
    protected $specialCharacters = array(
        '\\', '`', '*', '_', '{', '}', '[', ']', '(', ')', '>', '#', '+', '-', '.', '!', '|',
    );
    protected $StrongRegex = array(
        '*' => '/^[*]{2}((?:\\\\\*|[^*]|[*][^*]*[*])+?)[*]{2}(?![*])/s',
        '_' => '/^__((?:\\\\_|[^_]|_[^_]*_)+?)__(?!_)/us',
    );
    protected $EmRegex = array(
        '*' => '/^[*]((?:\\\\\*|[^*]|[*][*][^*]+?[*][*])+?)[*](?![*])/s',
        '_' => '/^_((?:\\\\_|[^_]|__[^_]*__)+?)_(?!_)\b/us',
    );
    protected $regexHtmlAttribute = '[a-zA-Z_:][\w:.-]*(?:\s*=\s*(?:[^"\'=<>`\s]+|"[^"]*"|\'[^\']*\'))?';
    protected $markupEscaped = false;
    protected $safeMode = false;
    protected $urlsLinked = true;
    #
    # ~
    #
    public function setMarkupEscaped($markupEscaped)
    {
        $this->markupEscaped = $markupEscaped;
        return $this;
    }
    public function setSafeMode($safeMode)
    {
        $this->safeMode = $safeMode;
        return $this;
    }
    public function setUrlsLinked($urlsLinked)
    {
        $this->urlsLinked = $urlsLinked;
        return $this;
    }
    #
    # Static
    #
    protected function codeSpan($text)
    {
        $text = htmlspecialchars($text, ENT_NOQUOTES, 'UTF-8');
        return $text;
    }
    protected function extractElement(array $Component)
    {
        if ( ! isset($Component['element']))
        {
            return array('markup' => $Component['markup']);
        }
        if (isset($Component['element']['handler']))
        {
            $Component['element']['text'] = $this->{$Component['element']['handler']}($Component['element']['text']);
        }
        return $Component['element'];
    }
}
