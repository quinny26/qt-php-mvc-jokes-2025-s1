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

//Edit page for users
$router->get('/users/{id}/edit', 'UserController@edit', ['auth']);
$router->put('/users/{id}', 'UserController@update',['auth']);

$router->get('/auth/register', 'UserController@create', ['guest']);
$router->get('/auth/login', 'UserController@login', ['guest']);

$router->post('/auth/register', 'UserController@store', ['guest']);
$router->post('/auth/logout', 'UserController@logout', ['auth']);
$router->post('/auth/login', 'UserController@authenticate', ['guest']);

