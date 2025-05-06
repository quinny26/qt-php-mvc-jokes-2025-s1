<?php
/**
 * Static Page Controller
 *
 *
 * Filename:        Static Page Controller.php
 * File comment/description: this file displays the home, about and contact static page. 
 * Allow both regsitered and unregistered user to view with minor differences. 
 * Code was taken from the previous HomeController.php and modified. 
 * Used Claude AI for debugging: https://claude.ai/share/522b8507-0b15-4117-84c1-7d67278189a1
 * Location:        App/Controllers
 * Project:         SaaS-Vanilla-MVC
 * Date Created:    5/4/2025
 *
 * Author:          Quinny Trang <20026235@tafe.wa.edu.au>
 *
 */

namespace App\Controllers;

use Framework\Database;

class StaticPageController
{
    protected $db;

    public function __construct()
    {
        $config = require basePath('config/db.php');
        $this->db = new Database($config);
    }

    /*
     * Show the latest jokes
     *
     * @return void
     */
    public function index()
{
    $lastSixQuery = 'SELECT 
    jokes.id,
    jokes.title,
    jokes.body,
    jokes.category_id, 
    jokes.tags, 
    jokes.author_id, 
    users.id AS user_id,  
    users.prefer_name AS user_prefer_name,
    categories.name AS category_name
    FROM jokes  
    LEFT JOIN categories ON jokes.category_id = categories.id
    LEFT JOIN users ON jokes.author_id = users.id ORDER BY jokes.created_at DESC LIMIT 0,6';

    $randomJokeQuery = 'SELECT 
    jokes.id,
    jokes.title,
    jokes.body,
    jokes.category_id, 
    jokes.tags, 
    jokes.author_id, 
    users.id AS user_id,  
    users.prefer_name AS user_prefer_name,
    categories.name AS category_name
    FROM jokes  
    LEFT JOIN categories ON jokes.category_id = categories.id
    LEFT JOIN users ON jokes.author_id = users.id ORDER BY RAND() LIMIT 0,1';

    $jokes = $this->db->query($lastSixQuery)->fetchAll();
    $randomJoke = $this->db->query($randomJokeQuery)->fetch();

    $isAuthenticated = isset($_SESSION['user']);
        $jokeCount = 0;
        $userCount = 0;
            if ($isAuthenticated) {
                $jokeCount = $this->db->query('SELECT count(id) as total FROM jokes ') ->fetch();
                $userCount = $this->db->query('SELECT count(id) as total FROM users') ->fetch();
            }

        loadView('home', [
            'jokes' => $jokes,
            'randomJoke' => $randomJoke,
            'isAuthenticated' => $isAuthenticated,
            'jokeCount' => $jokeCount,
            'userCount' => $userCount,
            'userPreferredName' => $_SESSION['user']['prefer_name'] ?? ''
        ]);
    }
    
    public function about()
    {
        loadView('about');
    }


    public function contact()
    {
        loadView('contact');
    }

}