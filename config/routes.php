<?php
// .... //

/// n-doptor SSO START
$route->get('/login', ['controller' => 'NDoptor', 'action' => 'showLoginForm'], 'show_login');
$route->get('/login_response', ['controller' => 'NDoptor', 'action' => 'loginResponse'],'login_response');
$route->get('/logout', ['controller' => 'NDoptor', 'action' => 'logout'], 'logout');
/// n-doptor SSO END


// .... //
?>