<?php
/**
 * Adds <rtl> and <ltr> tags to syntax.
 *
 * @author Hamid Fadishei <fadishei@yahoo.com>
 */
 
if (!defined('DOKU_INC')) die();
if (!defined('DOKU_PLUGIN')) define('DOKU_PLUGIN', DOKU_INC.'lib/plugins/');
require_once(DOKU_PLUGIN.'syntax.php');
 
class syntax_plugin_dokubidi extends DokuWiki_Syntax_Plugin
{
	function getType()
	{
		return 'formatting';
	}
 
	function getAllowedTypes()
	{
		return array('baseonly', 'container', 'substition', 'protected', 'disabled', 'formatting');
	}
 
	function getPType()
	{
		return 'normal';
	}
 
	function getSort()
	{
		return 500;
	}
 
	function connectTo($mode)
	{
		$this->Lexer->addEntryPattern('<ltr>(?=.*?</ltr>)', $mode, 'plugin_dokubidi');
		$this->Lexer->addEntryPattern('<rtl>(?=.*?</rtl>)', $mode, 'plugin_dokubidi');
	}
 
	function postConnect()
	{
		$this->Lexer->addExitPattern('</ltr>', 'plugin_dokubidi');
		$this->Lexer->addExitPattern('</rtl>', 'plugin_dokubidi');
	}
 
	function handle($match, $state, $pos, &$handler)
	{
		switch ($state)
		{
			case DOKU_LEXER_ENTER:
				return array($state, substr($match, 1, 3));
			case DOKU_LEXER_UNMATCHED:
				return array($state, $match);
			case DOKU_LEXER_EXIT:
				return array($state, "");
		}
		return array();
	}
 
	function render($mode, &$renderer, $data) 
	{
		if($mode == 'xhtml')
		{
			list($state, $match) = $data;
			switch ($state) 
			{
				case DOKU_LEXER_ENTER:
					$renderer->doc .= "<div style='direction:".$match.";'>";
					break;
				case DOKU_LEXER_UNMATCHED:
					$renderer->doc .= $renderer->_xmlEntities($match);
					break;
				case DOKU_LEXER_EXIT:
					$renderer->doc .= "</div>";
					break;
			}
			return true;
		}
		return false;
	}
}
