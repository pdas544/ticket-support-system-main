<?php
/**
 * This is a simple test script to debug the routes.php file
 * Set breakpoints in routes.php and run this script with the debugger
 */

// Display all errors for debugging purposes
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Add a debug message
echo "Starting debug test for routes.php...\n";

// Include the routes file
require_once __DIR__ . '/config/routes.php';

// Test that the router was created successfully
if (isset($router) && $router instanceof AltoRouter) {
    echo "Router created successfully!\n";
    
    // Print some information about the routes
    echo "Routes defined: " . count($router->getRoutes()) . "\n";
    
    // You can set a breakpoint here to inspect the $router object
    $routes = $router->getRoutes();
    
    // Display route information
    echo "\nRoute details:\n";
    echo "-------------\n";
    foreach ($routes as $route) {
        echo "Name: " . $route['name'] . "\n";
        echo "Method: " . $route['method'] . "\n";
        echo "Pattern: " . $route['pattern'] . "\n";
        echo "Controller: " . $route['target']['controller'] . "\n";
        echo "Action: " . $route['target']['action'] . "\n";
        echo "-------------\n";
    }
} else {
    echo "Error: Router not created or not an instance of AltoRouter\n";
}

echo "Debug test completed.\n";