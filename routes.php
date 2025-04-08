<?php
/**
 * FILE TITLE GOES HERE
 *
 * DESCRIPTION OF THE PURPOSE AND USE OF THE CODE
 * MAY BE MORE THAN ONE LINE LONG
 * KEEP LINE LENGTH TO NO MORE THAN 96 CHARACTERS
 *
 * Filename:        routes.php
 * Location:        ${FILE_LOCATION}
 * Project:         SaaS-Vanilla-MVC
 * Date Created:    2/4/2025
 *
 * Author:          Quinny Trang <20026235@nmtafe.wa.edu.au>
 *
 */

 //Static pages 
$router->get('home', 'StaticPageController@index');
$router->get('about', 'StaticPageController@about');
$router->get('contact', 'StaticPageController@contact');

//Jokes pages
$router->get('/jokes', 'JokeController@index');


$router->get('/jokes/create', 'JokeController@create', ['auth']);
$router->get('/jokes/edit/{id}', 'JokeController@edit', ['auth']);
$router->post('/jokes', 'JokeController@store', ['auth']);
$router->get('/jokes/search', 'JokeController@search');
$router->get('/jokes/{id}', 'JokeController@show');

$router->put('/jokes/{id}', 'JokeController@update', ['auth']);
$router->delete('/jokes/{id}', 'JokeController@destroy', ['auth']);

$router->get('/dashboard', 'HomeController@dashboard');

//Edit page for users
$router->get('/users/{id}/edit', 'UserController@edit', ['auth']);
$router->put('/users/{id}', 'UserController@update',['auth']);

$router->get('/auth/register', 'UserController@create', ['guest']);
$router->get('/auth/login', 'UserController@login', ['guest']);

$router->post('/auth/register', 'UserController@store', ['guest']);
$router->post('/auth/logout', 'UserController@logout', ['auth']);
$router->post('/auth/login', 'UserController@authenticate', ['guest']);

/**
 * Example Routes for a feature (Feature)
 *
 * $router->HTTP_METHOD('PATH', 'CONTROLLER_NAME@METHOD', OPTIONAL_MIDDLEWARE)
 *
 * PATH is based on the pluralised version of the FEATURE_NAME
 * CONTROLLER_NAME is usually in the form "NAME" in Pascal Case with Controller added
 * METHOD is the Controller Class method (function) that is called
 * OPTIONAL_MIDDLEWARE indicates if middleware is used for example to ensure a user is authenticated, or is a guest
 */
$router->get('/features', 'FeatureController@index');
$router->get('/features/create', 'FeatureController@create', ['auth']);
$router->get('/features/edit/{id}', 'FeatureController@edit', ['auth']);
$router->get('/features/search', 'FeatureController@search');
$router->get('/features/{id}', 'FeatureController@show');

$router->post('/features', 'FeatureController@store', ['auth']);
$router->put('/features/{id}', 'FeatureController@update', ['auth']);
$router->delete('/features/{id}', 'FeatureController@destroy', ['auth']);

/** 
 * Example Product Feature Routes 
 */
$router->get('/products', 'ProductController@index');
$router->get('/products/create', 'ProductController@create', ['auth']);
$router->get('/products/edit/{id}', 'ProductController@edit', ['auth']);
$router->get('/products/search', 'ProductController@search');
$router->get('/products/{id}', 'ProductController@show');

$router->post('/products', 'ProductController@store', ['auth']);
$router->put('/products/{id}', 'ProductController@update', ['auth']);
$router->delete('/products/{id}', 'ProductController@destroy', ['auth']);