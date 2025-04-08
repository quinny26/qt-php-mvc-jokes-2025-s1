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
use League\HTMLToMarkdown\HtmlConverter;

class JokeController
{
    protected Database $db;

    /**
     * @throws \Exception
     */
    public function __construct()
    {
        $config = require basePath('config/db.php');
        $this->db = new Database($config);
    }

   /**
    * https://claude.ai/share/9626598f-5fac-49c8-a1fc-a3bf12004811
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

    //    /**
    //  * Show the create joke form
    //  *
    //  * @return void
    //  */
    public function create()
    {
        $sql = "SELECT * FROM categories ORDER BY name";
        $categories = $this->db->query($sql)->fetchAll();
        
        $joke = [];

        loadView('jokes/create', [
            'categories' => $categories,
            'joke' => $joke
        ]);
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

        loadView('jokes/index', [
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

    /**
     * https://claude.ai/share/7797d962-995e-41ad-836e-a9b142123671
     * Store data in database
     *
     * @return void
     * @throws \Exception
     */
    public function store()
{
    // Allowed fields from the form
    $allowedFields = ['title', 'body', 'category_id', 'tags'];

    // Get submitted data, limiting to the allowed fields
    $newJokeData = array_intersect_key($_POST, array_flip($allowedFields));

    // Add author_id from session
    $newJokeData['author_id'] = Session::get('user')['id'];
    
    // Add timestamps
    // $newJokeData['created_at'] = date('Y-m-d H:i:s');
    // $newJokeData['updated_at'] = date('Y-m-d H:i:s');

    // Sanitize all data
    $newJokeData = array_map('sanitize', $newJokeData);

    // Fields that must not be empty
    $requiredFields = ['title', 'category_id', 'body'];

    $errors = [];

    // Validate required fields
    foreach ($requiredFields as $field) {
        if (empty($newJokeData[$field])) {
            $errors[$field] = ucfirst($field) . ' is required';
        }
    }

    // If validation fails, show form again with errors
    if (!empty($errors)) {
        // Get categories for the dropdown
        $sql = "SELECT * FROM categories ORDER BY name";
        $categories = $this->db->query($sql)->fetchAll();
        
        // Reload view with errors
        loadView('jokes/create', [
            'errors' => $errors,
            'joke' => $newJokeData,
            'categories' => $categories
        ]);
        return;
    }

    // Process the body field if markdown conversion is needed
    if (isset($newJokeData['body'])) {
        $body = $newJokeData['body'];
        $markdown = htmlToMarkdown($body);
        $newJokeData['body'] = $markdown;
    }

    // Build the SQL query
    $fields = array_keys($newJokeData);
    $fieldsStr = implode(', ', $fields);

    $placeholders = [];
    foreach ($fields as $field) {
        $placeholders[] = ':' . $field;
    }
    $placeholdersStr = implode(', ', $placeholders);

    $insertQuery = "INSERT INTO jokes ({$fieldsStr}) VALUES ({$placeholdersStr})";
    $this->db->query($insertQuery, $newJokeData);

    Session::setFlashMessage('success_message', 'Joke created successfully');
    redirect('/jokes');
}

    /**
     * Show the joke edit form
     *
     * @param array $params
     * @return null
     * @throws \Exception
     */
    public function edit(array $params): null
    {
        $id = $params['id'] ?? '';

        $params = [
            'id' => $id
        ];

        $joke = $this->db->query('SELECT 
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
        LEFT JOIN categories ON jokes.category_id = categories.id WHERE jokes.id = :id', $params)->fetch();

        // Check if joke exists
        if (!$joke) {
            ErrorController::notFound('Joke not found');
            exit();
        }

        // Authorisation
        if (!Authorisation::isOwner($joke->user_id)) {
            Session::setFlashMessage('error_message',
                'You are not authorized to update this joke');
            return redirect('/jokes/' . $joke->id);
        }

        $converter = new HtmlConverter();

        $joke->body = $converter->convert($joke->body ?? '');

        loadView('jokes/edit', [
            'joke' => $joke
        ]);
        return null;
    }

    /**
     * Update a joke
     *
     * @param array $params
     * @return null
     * @throws \Exception
     */
    public function update(array $params): null
    {
        $id = $params['id'] ?? '';

        $params = [
            'id' => $id
        ];

        $joke = $this->db->query('SELECT 
        jokes.id,
        jokes.title,
        jokes.body,
        jokes.category_id, 
        jokes.tags,  
        users.id AS user_id,  
        categories.name AS category_name
        FROM jokes 
        LEFT JOIN users ON jokes.author_id = users.id
        LEFT JOIN categories ON jokes.category_id = categories.id WHERE jokes.id = :id', $params)->fetch();

        // Check if joke exists
        if (!$joke) {
            ErrorController::notFound('Joke not found');
            exit();
        }

        // Authorisation
        if (!Authorisation::isOwner($joke->user_id)) {
            Session::setFlashMessage('error_message',
                'You are not authorised to update this joke');
            return redirect('/jokes/' . $joke->id);
        }

        $allowedFields = ['title', 'body', 'category_id', 'tags'];

        $updateValues = array_intersect_key($_POST, array_flip($allowedFields)) ?? [];

        $updateValues = array_map('sanitize', $updateValues);

        $requiredFields = ['title', 'category_id', 'tags'];

        $errors = [];

        foreach ($requiredFields as $field) {
            if (empty($updateValues[$field]) || !Validation::string($updateValues[$field])) {
                $errors[$field] = ucfirst($field) . ' is required';
            }
        }

        if (!empty($errors)) {
            loadView('jokes/edit', [
                'joke' => $joke,
                'errors' => $errors
            ]);
            exit;
        }

        if (isset($updateValues['body'])) {
            $body = $updateValues['body'] ?? '';
            $markdown = htmlToMarkdown($body);
            $updateValues['body'] = $markdown;
        }

        //https://claude.ai/share/212a6db8-31c2-47d2-bc07-afb74c280d71
        $updateValues['updated_at'] = date('Y-m-d H:i:s') ?? '';

        // Submit to database
        $updateFields = [];

        foreach (array_keys($updateValues) as $field) {
            $updateFields[] = "{$field} = :{$field}";
        }

        $updateFields = implode(', ', $updateFields);

        $updateQuery = "UPDATE jokes SET $updateFields WHERE id = :id";

        $updateValues['updated_at'] = date('Y-m-d H:i:s') ?? '';


        //https://claude.ai/share/7b888cb5-649a-4d3a-99d6-cc93601f1a7f
        $updateValues['id'] = $id; // Add this line before executing the query
        $this->db->query($updateQuery, $updateValues);

        // Set flash message
        Session::setFlashMessage('success_message', 'Joke updated');

        redirect('/jokes/' . $id);

    }

/** 
 * https://www.traversymedia.com/php-from-scratch
  * delete a joke
  *
  * @param array $params 
  * @return void 
*/

  public function destroy($params){
    $id = $params['id'];

    $params = [
        'id'=> $id
    ];

    $joke = $this->db->query('SELECT 
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
        LEFT JOIN categories ON jokes.category_id = categories.id WHERE jokes.id = :id', $params)->fetch();

    //check if listing exist
    if(!$joke){
        ErrorController::notFound('Joke not found');
        return;
    }

    if(!Authorisation::isOwner($joke->user_id)){
        Session::setFlashMessage('error_message', 'You are not authorised to delete this joke');
        return redirect('/jokes/'.$joke->id);
    }

    $this->db->query('DELETE FROM jokes WHERE id = :id', $params);

    //set flash message
    Session::setFlashMessage('success_message', 'Joke deleted successfully');
    redirect('/jokes');
  }

}