<?php

echo "Hello World!";
// Enable error reporting for debugging
// error_reporting(E_ALL);
// ini_set('display_errors', 1);
// error_log("[FrankenPHP Worker] Starting Moodle worker initialization");

// try {
//     // Core Moodle setup
//     require_once(__DIR__ . '/config.php');
//     require_once($CFG->dirroot . '/lib/setup.php');
    
//     // Essential libraries for page rendering
//     require_once($CFG->dirroot . '/lib/outputlib.php');
//     require_once($CFG->dirroot . '/lib/weblib.php');
//     require_once($CFG->dirroot . '/lib/navigationlib.php');
//     require_once($CFG->dirroot . '/lib/pagelib.php');
    
//     // Authentication and session handling
//     require_once($CFG->dirroot . '/lib/sessionlib.php');
//     require_once($CFG->dirroot . '/lib/authlib.php');
    
//     // Course related
//     require_once($CFG->dirroot . '/course/lib.php');
//     require_once($CFG->dirroot . '/course/format/lib.php');
    
//     // Frontend components
//     require_once($CFG->dirroot . '/lib/outputrenderers.php');
//     require_once($CFG->dirroot . '/lib/outputcomponents.php');
    
//     error_log("[FrankenPHP Worker] Successfully loaded core Moodle components");
    
//     // Basic database test to ensure connectivity
//     global $DB;
//     $DB->get_record('config', array('name' => 'version'));
//     error_log("[FrankenPHP Worker] Database connection verified");
    
//     return true;
    
// } catch (Exception $e) {
//     error_log("[FrankenPHP Worker] Error during initialization: " . $e->getMessage());
//     return false;
// }