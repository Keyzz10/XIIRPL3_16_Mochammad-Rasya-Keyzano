<?php

class Router {
    private $routes = [];
    private $currentController = 'DashboardController';
    private $currentMethod = 'index';
    private $params = [];

    public function __construct() {
        $this->setupRoutes();
        $url = $this->getUrl();
        $this->route($url);
    }

    private function setupRoutes() {
        // Define application routes
        $this->routes = [
            '' => ['controller' => 'DashboardController', 'method' => 'index'],
            'dashboard' => ['controller' => 'DashboardController', 'method' => 'index'],
            'activities' => ['controller' => 'DashboardController', 'method' => 'activities'],
            'login' => ['controller' => 'AuthController', 'method' => 'login'],
            'logout' => ['controller' => 'AuthController', 'method' => 'logout'],
            'register' => ['controller' => 'AuthController', 'method' => 'register'],
            'profile' => ['controller' => 'UserController', 'method' => 'profile'],
            'users' => ['controller' => 'UserController', 'method' => 'index'],
            'users/create' => ['controller' => 'UserController', 'method' => 'create'],
            'users/edit' => ['controller' => 'UserController', 'method' => 'edit'],
            'users/delete' => ['controller' => 'UserController', 'method' => 'delete'],
            'users/activate' => ['controller' => 'UserController', 'method' => 'activate'],
            'users/deactivate' => ['controller' => 'UserController', 'method' => 'deactivate'],
            'users/activity' => ['controller' => 'UserController', 'method' => 'activity'],
            'users/search' => ['controller' => 'UserController', 'method' => 'search'],
            'users/export' => ['controller' => 'UserController', 'method' => 'export'],
            'users/check-username' => ['controller' => 'UserController', 'method' => 'checkUsername'],
            'projects' => ['controller' => 'ProjectController', 'method' => 'index'],
            'projects/view' => ['controller' => 'ProjectController', 'method' => 'viewProject'],
            'projects/create' => ['controller' => 'ProjectController', 'method' => 'create'],
            'projects/edit' => ['controller' => 'ProjectController', 'method' => 'edit'],
            'projects/delete' => ['controller' => 'ProjectController', 'method' => 'delete'],
            'projects/complete' => ['controller' => 'ProjectController', 'method' => 'complete'],
            'projects/reopen' => ['controller' => 'ProjectController', 'method' => 'reopen'],
            'tasks' => ['controller' => 'TaskController', 'method' => 'index'],
            'tasks/view' => ['controller' => 'TaskController', 'method' => 'viewTask'],
            'tasks/create' => ['controller' => 'TaskController', 'method' => 'create'],
            'tasks/edit' => ['controller' => 'TaskController', 'method' => 'edit'],
            'tasks/delete' => ['controller' => 'TaskController', 'method' => 'delete'],
            'tasks/comment' => ['controller' => 'TaskController', 'method' => 'comment'],
            'tasks/edit-comment' => ['controller' => 'TaskController', 'method' => 'editComment'],
            'tasks/delete-comment' => ['controller' => 'TaskController', 'method' => 'deleteComment'],
            'tasks/deleted-comments' => ['controller' => 'TaskController', 'method' => 'deletedComments'],
            'tasks/restore-comment' => ['controller' => 'TaskController', 'method' => 'restoreComment'],
            'tasks/update-status' => ['controller' => 'TaskController', 'method' => 'updateStatus'],
            'tasks/approve-estimated' => ['controller' => 'TaskController', 'method' => 'approveEstimated'],
            'bugs' => ['controller' => 'BugController', 'method' => 'index'],
            'bugs/view' => ['controller' => 'BugController', 'method' => 'viewBug'],
            'bugs/create' => ['controller' => 'BugController', 'method' => 'create'],
            'bugs/edit' => ['controller' => 'BugController', 'method' => 'edit'],
            'bugs/delete' => ['controller' => 'BugController', 'method' => 'delete'],
            'bugs/update-status' => ['controller' => 'BugController', 'method' => 'updateStatus'],
            'bugs/comment' => ['controller' => 'BugController', 'method' => 'comment'],
            'bugs/add-comment' => ['controller' => 'BugController', 'method' => 'addComment'],
            'bugs/edit-comment' => ['controller' => 'BugController', 'method' => 'editComment'],
            'bugs/delete-comment' => ['controller' => 'BugController', 'method' => 'deleteComment'],
            'bugs/deleted-comments' => ['controller' => 'BugController', 'method' => 'deletedComments'],
            'bugs/restore-comment' => ['controller' => 'BugController', 'method' => 'restoreComment'],
            'bugs/assign' => ['controller' => 'BugController', 'method' => 'assignBug'],
            'bugs/reopen' => ['controller' => 'BugController', 'method' => 'reopenBug'],
            'qa' => ['controller' => 'QAController', 'method' => 'index'],
            'qa/test-cases' => ['controller' => 'QAController', 'method' => 'testCases'],
            'qa/test-suites' => ['controller' => 'QAController', 'method' => 'testSuites'],
            'qa/test-suite' => ['controller' => 'QAController', 'method' => 'viewTestSuite'],
            'qa/completed-tests' => ['controller' => 'QAController', 'method' => 'completedTests'],
            'qa/run-suite' => ['controller' => 'QAController', 'method' => 'runSuite'],
            'qa/delete-test-case' => ['controller' => 'QAController', 'method' => 'deleteTestCase'],
            'qa/delete-test-suite' => ['controller' => 'QAController', 'method' => 'deleteTestSuite'],
            'qa/edit-test-case' => ['controller' => 'QAController', 'method' => 'editTestCase'],
            'qa/edit-test-suite' => ['controller' => 'QAController', 'method' => 'editTestSuite'],
            'qa/test-case' => ['controller' => 'QAController', 'method' => 'viewTestCase'],
            'qa/run-test' => ['controller' => 'QAController', 'method' => 'runTest'],
            'qa/create-test-case' => ['controller' => 'QAController', 'method' => 'createTestCase'],
            'qa/create-test-suite' => ['controller' => 'QAController', 'method' => 'createTestSuite'],
            'reports' => ['controller' => 'ReportController', 'method' => 'index'],
            'reports/projects' => ['controller' => 'ReportController', 'method' => 'projects'],
            'reports/tasks' => ['controller' => 'ReportController', 'method' => 'tasks'],
            'reports/bugs' => ['controller' => 'ReportController', 'method' => 'bugs'],
            'reports/qa' => ['controller' => 'ReportController', 'method' => 'qa'],
            'reports/export' => ['controller' => 'ReportController', 'method' => 'export'],
            'reports/print' => ['controller' => 'ReportController', 'method' => 'print'],
            'api' => ['controller' => 'ApiController', 'method' => 'index'],
            'api/check-auth' => ['controller' => 'ApiController', 'method' => 'checkAuth'],
        ];
    }

    private function getUrl() {
        // For file-based navigation, check for different URL patterns
        if (isset($_GET['url'])) {
            return rtrim($_GET['url'], '/');
        }
        
        // Check if accessing via file path
        $requestUri = $_SERVER['REQUEST_URI'] ?? '';
        $scriptName = $_SERVER['SCRIPT_NAME'] ?? '';
        
        // Extract the path after index.php
        if (strpos($requestUri, $scriptName) !== false) {
            $url = substr($requestUri, strlen($scriptName));
            $url = ltrim($url, '/');
            
            // Remove query string
            if (($pos = strpos($url, '?')) !== false) {
                $url = substr($url, 0, $pos);
            }
            
            return rtrim($url, '/');
        }
        
        return '';
    }

    private function route($url) {
        // Handle query parameters first
        $queryParams = [];
        if (isset($_GET['id'])) {
            $queryParams[] = $_GET['id'];
        }
        
        $urlParts = $url ? explode('/', $url) : [''];
        
        // First check for exact route matches (including slashes)
        if (array_key_exists($url, $this->routes)) {
            $this->currentController = $this->routes[$url]['controller'];
            $this->currentMethod = $this->routes[$url]['method'];
            $this->params = $queryParams;
        } else {
            // Handle dynamic routes like users/edit/1, users/activity/1
            if (count($urlParts) >= 2) {
                $baseRoute = $urlParts[0] . '/' . $urlParts[1];
                if (array_key_exists($baseRoute, $this->routes)) {
                    $this->currentController = $this->routes[$baseRoute]['controller'];
                    $this->currentMethod = $this->routes[$baseRoute]['method'];
                    // Pass the remaining parts as parameters, plus any query params
                    $this->params = array_merge(array_slice($urlParts, 2), $queryParams);
                } else {
                    // Check for base route matches
                    $route = $urlParts[0];
                    if (array_key_exists($route, $this->routes)) {
                        $this->currentController = $this->routes[$route]['controller'];
                        $this->currentMethod = $this->routes[$route]['method'];
                        // Remove the matched route part
                        array_shift($urlParts);
                        $this->params = array_merge(array_values($urlParts), $queryParams);
                    } else {
                        // Try to find controller and method from URL
                        if (!empty($urlParts[0])) {
                            $controllerName = ucfirst($urlParts[0]) . 'Controller';
                            if (file_exists(ROOT_PATH . '/app/controllers/' . $controllerName . '.php')) {
                                $this->currentController = $controllerName;
                                unset($urlParts[0]);
                            }
                        }

                        if (!empty($urlParts[1])) {
                            $this->currentMethod = $urlParts[1];
                            unset($urlParts[1]);
                        }
                        
                        // Get parameters
                        $this->params = array_merge($urlParts ? array_values($urlParts) : [], $queryParams);
                    }
                }
            } else {
                // Check for base route matches
                $route = $urlParts[0];
                if (array_key_exists($route, $this->routes)) {
                    $this->currentController = $this->routes[$route]['controller'];
                    $this->currentMethod = $this->routes[$route]['method'];
                    // Remove the matched route part
                    array_shift($urlParts);
                    $this->params = array_merge(array_values($urlParts), $queryParams);
                } else {
                    // Try to find controller and method from URL
                    if (!empty($urlParts[0])) {
                        $controllerName = ucfirst($urlParts[0]) . 'Controller';
                        if (file_exists(ROOT_PATH . '/app/controllers/' . $controllerName . '.php')) {
                            $this->currentController = $controllerName;
                            unset($urlParts[0]);
                        }
                    }

                    if (!empty($urlParts[1])) {
                        $this->currentMethod = $urlParts[1];
                        unset($urlParts[1]);
                    }
                    
                    // Get parameters
                    $this->params = array_merge($urlParts ? array_values($urlParts) : [], $queryParams);
                }
            }
        }

        // Call controller method with parameters
        $this->callController();
    }

    private function callController() {
        // Check if controller file exists
        $controllerFile = ROOT_PATH . '/app/controllers/' . $this->currentController . '.php';
        
        // Debug logging (remove in production)
        error_log("FlowTask Router Debug - Controller: {$this->currentController}, Method: {$this->currentMethod}, File: {$controllerFile}");
        
        if (file_exists($controllerFile)) {
            require_once $controllerFile;
            
            // Check if class exists
            if (class_exists($this->currentController)) {
                // Instantiate controller
                $controller = new $this->currentController();
                
                // Convert dash-separated method names to camelCase
                $methodName = $this->convertMethodName($this->currentMethod);
                
                // Check if method exists
                if (method_exists($controller, $methodName)) {
                    error_log("FlowTask Router Debug - Calling method: {$methodName} with params: " . implode(',', $this->params));
                    call_user_func_array([$controller, $methodName], $this->params);
                } else {
                    error_log("FlowTask Router Error - Method {$methodName} not found in {$this->currentController}");
                    $this->show404();
                }
            } else {
                error_log("FlowTask Router Error - Class {$this->currentController} not found");
                $this->show404();
            }
        } else {
            error_log("FlowTask Router Error - Controller file not found: {$controllerFile}");
            $this->show404();
        }
    }

    private function show404() {
        http_response_code(404);
        require_once ROOT_PATH . '/app/views/errors/404.php';
    }
    
    private function convertMethodName($method) {
        // Convert dash-separated method names to camelCase
        // e.g., "edit-comment" -> "editComment", "delete-task-comment" -> "deleteTaskComment"
        if (strpos($method, '-') !== false) {
            $parts = explode('-', $method);
            $camelCase = $parts[0];
            for ($i = 1; $i < count($parts); $i++) {
                $camelCase .= ucfirst($parts[$i]);
            }
            return $camelCase;
        }
        return $method;
    }
}
?>