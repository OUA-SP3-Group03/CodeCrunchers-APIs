<?php
/**
 * Copyright Jack Harris
 * Peninsula Interactive - CodeCrunchers
 * Last Updated - 4/10/2021
 */

//**** DEFINE CONSTANTS ****\\
define('ROOT', dirname(__DIR__) . DIRECTORY_SEPARATOR);
const APP = ROOT . 'app' . DIRECTORY_SEPARATOR;
const CONTROLLERS = ROOT. APP. 'Controllers'.DIRECTORY_SEPARATOR;
const CORE = ROOT . 'app' . DIRECTORY_SEPARATOR . 'core' . DIRECTORY_SEPARATOR;
const DATABASE = ROOT.'Database'.DIRECTORY_SEPARATOR;
const PROVIDERS = ROOT.'Providers'.DIRECTORY_SEPARATOR;
const ROUTES = ROOT.'Routes'.DIRECTORY_SEPARATOR;
const VIEWS = ROOT.'Views'.DIRECTORY_SEPARATOR;
const RULES = ROOT.'Rules'.DIRECTORY_SEPARATOR;

//**** PHP CLASS AUTO LOADER ****\\
//create array of folders to be auto-loaded by PHP.
$modules = [ROOT,APP,CONTROLLERS,CORE,DATABASE,PROVIDERS,ROUTES,VIEWS,RULES];
//set to include path of each of the folders specified in the modules array
set_include_path(get_include_path() . PATH_SEPARATOR . implode(PATH_SEPARATOR, $modules));
//call spl auto-load
spl_autoload_register('spl_autoload');

//**** CREATE WEB APPLICATION ****\\
//ERROR: Application cannot auto-load from index.php when part of the app\ namespace! WTF..
new Application();


