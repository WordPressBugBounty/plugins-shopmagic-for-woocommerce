<?php

namespace ShopMagicVendor\Sabberworm\CSS\Value;

use ShopMagicVendor\Sabberworm\CSS\OutputFormat;
use ShopMagicVendor\Sabberworm\CSS\Parsing\ParserState;
use ShopMagicVendor\Sabberworm\CSS\Parsing\UnexpectedEOFException;
use ShopMagicVendor\Sabberworm\CSS\Parsing\UnexpectedTokenException;
class LineName extends ValueList
{
    /**
     * @param array<int, RuleValueList|CSSFunction|CSSString|LineName|Size|URL|string> $aComponents
     * @param int $iLineNo
     */
    public function __construct(array $aComponents = [], $iLineNo = 0)
    {
        parent::__construct($aComponents, ' ', $iLineNo);
    }
    /**
     * @return LineName
     *
     * @throws UnexpectedTokenException
     * @throws UnexpectedEOFException
     */
    public static function parse(ParserState $oParserState)
    {
        $oParserState->consume('[');
        $oParserState->consumeWhiteSpace();
        $aNames = [];
        do {
            if ($oParserState->getSettings()->bLenientParsing) {
                try {
                    $aNames[] = $oParserState->parseIdentifier();
                } catch (UnexpectedTokenException $e) {
                    if (!$oParserState->comes(']')) {
                        throw $e;
                    }
                }
            } else {
                $aNames[] = $oParserState->parseIdentifier();
            }
            $oParserState->consumeWhiteSpace();
        } while (!$oParserState->comes(']'));
        $oParserState->consume(']');
        return new LineName($aNames, $oParserState->currentLine());
    }
    /**
     * @return string
     */
    public function __toString()
    {
        return $this->render(new OutputFormat());
    }
    /**
     * @param OutputFormat|null $oOutputFormat
     *
     * @return string
     */
    public function render($oOutputFormat)
    {
        return '[' . parent::render(OutputFormat::createCompact()) . ']';
    }
}
