<?php

/**
 * Extension for Contao Open Source CMS
 *
 * @copyright  MEN AT WORK 2015
 * @package    agentSelection
 * @license    GNU/LGPL http://opensource.org/licenses/LGPL-3.0
 * @filesource
 */

/**
 * Class AgentSelection
 */
class AgentSelection
{

    protected static $_arrIOs = array('iPad', 'iPhone', 'iPod');
    
    /**
     * Initialize the object
     */
    public function __construct()
    {
        if (version_compare(VERSION, '2.11', '<'))
        {
            require_once TL_ROOT . '/system/config/agents.php';
        }
    }    

    /**
     * Check if the operation system has permission
     * 
     * @param mixed $mixedConfig
     * @param stdClass $objUa
     * @return boolean 
     */
    public static function checkOsPermission($mixedConfig, $objUa)
    {
        $arrIOs = array('iPad', 'iPhone', 'iPod');

        if ($mixedConfig != '')
        {
            if ($mixedConfig['config']['os'] == $objUa->os)
            {

                if (in_array($mixedConfig['value'], self::$_arrIOs))
                {
                    if (strpos($objUa->string, $mixedConfig['value']) !== false)
                    {
                        return true;
                    }
                }
                else
                {

                    return true;
                }
            }
            return false;
        }
        
        return true;
    }
    
    public function getOsClass()
    {
        $objUa = Environment::getInstance()->agent;
        
        $arrIOs = self::$_arrIOs;
        
        foreach($arrIOs as $strIOs)
        {
            if (strpos($objUa->string, $strIOs) !== false)
            {
                return strtolower($strIOs);
            }
        }
        
        return '';
    }
    
    /**
     * Check if the browser version has permission
     * 
     * @param mixed $mixedConfig
     * @param stdClass $objUa
     * @param string $strOperator
     * @return boolean
     */
    public static function checkBrowserVerPermission($mixedConfig, $objUa, $strOperator)
    {
        if($mixedConfig != '')
        {
            switch ($strOperator)
            {
                case 'lt':
                    if($objUa->version < $mixedConfig) return true;
                    break;
                case 'lte':
                    if($objUa->version <= $mixedConfig) return true;
                    break;
                case 'gte':
                    if($objUa->version >= $mixedConfig) return true;
                    break;
                case 'gt':
                    if($objUa->version > $mixedConfig) return true;
                    break;
                default:
                    if($objUa->version == $mixedConfig) return true;
                    break;
            }            
            return false;
        }

        return true;
    }

    /**
     * Return option array for operation systems
     * 
     * @return array
     */
    public function getClientOs()
    {
        $arrOptions = array();

        foreach ($GLOBALS['TL_CONFIG']['os'] as $strLabel => $arrOs)
        {
            $arrOptions[$strLabel] = $strLabel;
        }

        return $arrOptions;
    }

    /**
     * Return browser array for operation systems
     * 
     * @return array
     */
    public function getClientBrowser()
    {
        $arrOptions = array();

        foreach ($GLOBALS['TL_CONFIG']['browser'] as $strLabel => $arrBrowser)
        {
            $arrOptions[$strLabel] = $strLabel;
        }

        return $arrOptions;
    }
    
    public function generatePage($objPage, $objLayout, $objPageRegular)
    {
        $strClass = $this->getOsClass();
        $objPage->cssClass .= ($strClass)? ' '.$strClass : '';
    }

}

?>