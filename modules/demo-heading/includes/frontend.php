<?php
use ToolboxModules\Frontend;
/**
 * Process the frontend of this module using Timber
 */
Frontend::beaverbuilderFrontend( __FILE__ , '/frontend.twig',  $settings, $id, $module);