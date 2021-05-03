# N DOPTOR SSO
CakePHP Integration
--

1. Copy `config/ndoptor.php` in `config` folder


2. Update `config/ndoptor.php` with this value
   ```
   return [
       'ndoptor' => [
           'api_domain' => 'http://n-doptor-api-stage.nothi.gov.bd/',
           'login_sso_url' => 'http://n-doptor-accounts-stage.nothi.gov.bd/login',
           'logout_sso_url' => 'http://n-doptor-accounts-stage.nothi.gov.bd/logout',
       ]
   ];
   ```
3. Add below line in `config/bootstrap.php` in `try` block
   `Configure::load('ndoptor', 'default');`


4. Copy `src/Controller/NDoptorController.php` in `src/Controller/` folder


5. Extend your application main controller in `src/Controller/NDoptorController.php` file like
   `class NDoptorController extends EFileController`


6. Remove `login` & `logout` route if exists.


7. Add below routes in `config/routes.php` file
   ```
   $builder->get('/login', ['controller' => 'NDoptor', 'action' => 'showLoginForm'], 'show_login');
   $builder->get('/login_response', ['controller' => 'NDoptor', 'action' => 'loginResponse'],'login_response');
   $builder->get('/logout', ['controller' => 'NDoptor', 'action' => 'logout'], 'logout');
   ```