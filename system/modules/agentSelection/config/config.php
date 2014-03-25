<?php

/**
 * Contao Open Source CMS
 *
 * @copyright  MEN AT WORK 2014
 * @package    agentSelection
 * @license    GNU/LGPL
 * @filesource
 */

// HOOKS
$GLOBALS['TL_HOOKS']['generatePage'][] = array('AgentSelection', 'generatePage');

// Set new entries for global operation systems array
if (array_search('iPad', array_keys($GLOBALS['TL_CONFIG']['os'])) !== false)
{
    $i = array_search('iPad', array_keys($GLOBALS['TL_CONFIG']['os']));
    $GLOBALS['TL_CONFIG']['os'] = array_merge
    (
            array_slice($GLOBALS['TL_CONFIG']['os'], 0, $i), array
            (
                'iOS' => array(
                    'os'       => 'ios',
                    'mobile'   => true
                ),
            ), 
            array_slice($GLOBALS['TL_CONFIG']['os'], $i)
    );
}