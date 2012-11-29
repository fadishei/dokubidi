<?php
/**
 * Adds LTR and RTL buttons to toolbar.
 *
 * @author Hamid Fadishei <fadishei@yahoo.com>
 */
 
if (!defined('DOKU_INC')) die();
if (!defined('DOKU_PLUGIN')) define('DOKU_PLUGIN', DOKU_INC.'lib/plugins/');
require_once(DOKU_PLUGIN.'action.php');

class action_plugin_dokubidi extends DokuWiki_Action_Plugin
{
	function register(&$controller)
	{
		$controller->register_hook('TOOLBAR_DEFINE', 'AFTER', $this, 'insert_button', array ());
	}
 
	function insert_button(& $event, $param) 
	{
		$event->data[] = array (
			'type' => 'format',
			'title' => 'Left to Right',
			'icon' => '../../plugins/dokubidi/ltr.png',
			'open' => '<ltr>',
			'close' => '</ltr>',
			'sample' => 'Text Here',
		);
		$event->data[] = array (
			'type' => 'format',
			'title' => 'Right to Left',
			'icon' => '../../plugins/dokubidi/rtl.png',
			'open' => '<rtl>',
			'close' => '</rtl>',
			'sample' => 'Text Here',
		);
	}

}
