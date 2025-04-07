<?php
/**
 * Joke Controller
 *
 *
 * Filename:        Joke Controller.php
 * Location:        App/Controllers
 * Project:         SaaS-Vanilla-MVC
 * Date Created:    5/4/2025
 *
 * Author:          Quinny Trang <20026235@tafe.wa.edu.au>
 *
 */

namespace App\Controllers;

use Framework\Authorisation;
use Framework\Database;
use Framework\Session;
use Framework\Validation;

class JokeController
{
    protected $db;

    public function __construct()
    {
        $config = require basePath('config/db.php');
        $this->db = new Database($config);
    }
   /**
     * Produce home page
     *
     * @return void
     * @throws \Exception
     */
    public function index(): void
    {
        $sql = "SELECT 
        jokes.id,
        jokes.title,
        jokes.category_id, 
        jokes.tags, 
        jokes.author_id, 
        users.id AS user_id,  
        users.prefer_name AS user_prefer_name,
        categories.name AS category_name
        FROM jokes  
        LEFT JOIN categories ON jokes.category_id = categories.id
        LEFT JOIN users ON jokes.author_id = users.id";
            
        $jokes = $this->db->query($sql)->fetchAll();

        // print_r($jokes); die();

        loadView('jokes/index', [
            'jokes' => $jokes
        ]);
    }

       /**
     * Show the create joke form
     *
     * @return void
     */
    public function create(): void
    {
        loadView('jokes/create');
    }

     /**
     * Search jokes by keywords
     *
     * @return void
     * @throws \Exception
     */
    public function search(): void
    {
        $keywords = isset($_GET['keywords']) ? trim($_GET['keywords']) : '';

        $query = "SELECT 
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
        LEFT JOIN users ON jokes.author_id = users.id
        LEFT JOIN categories ON jokes.category_id = categories.id
        WHERE jokes.body LIKE :keywords OR jokes.title LIKE :keywords";

        $params = [
            'keywords' => "%{$keywords}%",
        ];

        $jokes = $this->db->query($query, $params)->fetchAll();

        loadView('/jokes/index', [
            'jokes' => $jokes,
            'keywords' => $keywords,
        ]);
    }

     /**
     * Show a single joke
     *
     * @param array $params
     * @return void
     * @throws \Exception
     */
    public function show(array $params): void
    {
        $id = $params['id'] ?? '';

        $params = [
            'id' => $id
        ];

        $sql = "SELECT 
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
        LEFT JOIN users ON jokes.author_id = users.id
        LEFT JOIN categories ON jokes.category_id = categories.id WHERE jokes.id = :id";
        $joke = $this->db->query($sql, $params)->fetch();


        // Check if joke exists
        if (!$joke) {
            ErrorController::notFound('Jokes not found');
            return;
        }
        
        loadView('jokes/show', [
            'joke' => $joke
        ]);
    }

}