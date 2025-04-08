<?php
/**
 * User Controller
 *
 * Provides the Register, Login and Logout capabilities
 * of the application
 *
 * Filename:        UserController.php
 * Location:        App/Controllers
 * Project:         SaaS-Vanilla-MVC
 * Date Created:    3/4/2025
 *
 * Author:          Quinny Trang <20026235@tafe.wa.edu.au>
 *
 */

namespace App\Controllers;

use Framework\Database;
use Framework\Session;
use Framework\Validation;
use Framework\Authorisation;

class UserController
{

    /* Properties */

    /**
     * @var Database
     */
    protected $db;

    /**
     * UserController Constructor
     *
     * Instantiate the database connection for use in this class
     * storing the connection in the protected <code>$db</code>
     * property.
     *
     * @throws \Exception
     */
    public function __construct()
    {
        $config = require basePath('config/db.php');
        $this->db = new Database($config);
    }

    /**
     * Show the login page
     *
     * @return void
     */
    public function login()
    {
        loadView('users/login');
    }

    /**
     * Show the register page
     *
     * @return void
     */
    public function create()
    {
        loadView('users/create');
    }

    // Need help with debugging validation error(ChatGPT): https://chatgpt.com/share/67ed2334-cda0-8012-b85c-c0c7381e2817
    /**
     * Store user in database
     *
     * @return void
     */
    public function store()
    {
        $given_name = $_POST['given_name'] ?? '';
        $family_name = $_POST['family_name'] ?? '';
        $prefer_name = $_POST['prefer_name'] ?? $given_name;

        $email = $_POST['email'];
        $password = $_POST['password'];
        $passwordConfirmation = $_POST['password_confirmation'];

        $city = $_POST['city'] ?? 'Unknown';
        $state = $_POST['state'] ?? 'Unknown';
        $country = $_POST['country'] ?? 'Unknown';

        $created_at = date('Y-m-d H:i:s');


        $errors = [];

        // Validation
        if (!Validation::email($email)) {
            $errors['email'] = 'Please enter a valid email address';
        }
        
        if (!Validation::string($given_name, 2, 50)) {
            $errors['given_name'] = 'Given Name must be between 2 and 50 characters';
        }

        if (!Validation::string($family_name, 2, 50)) {
            $errors['family_name'] = 'Family must be between 2 and 50 characters';
        }

        if (!Validation::string($prefer_name, 2, 50)) {
            $errors['prefer_name'] = 'Preferred Name must be between 2 and 50 characters';
        }

        if (!Validation::string($city, 2, 50)) {
            $errors['city'] = 'City must be between 2 and 50 characters';
        }

        if (!Validation::string($state, 2, 50)) {
            $errors['state'] = 'State must be between 2 and 50 characters';
        }

        if (!Validation::string($country, 2, 50)) {
            $errors['country'] = 'Country must be between 2 and 50 characters';
        }

        if (!Validation::string($password, 6, 50)) {
            $errors['password'] = 'Password must be at least 6 characters';
        }

        if (!Validation::match($password, $passwordConfirmation)) {
            $errors['password_confirmation'] = 'Passwords do not match';
        }

        if (!empty($errors)) {
            loadView('users/create', [
                'errors' => $errors,
                'user' => [
                    'given_name' => $given_name,
                    'family_name' => $family_name,
                    'prefer_name' => $prefer_name,
                    'email' => $email,
                    'city' => $city,
                    'state' => $state,
                    'country' => $country,
                    'password' => password_hash($password, PASSWORD_DEFAULT),
                    'password_confirmation' => password_hash($passwordConfirmation, PASSWORD_DEFAULT)
                ]
            ]);
            exit;
        }

        // Check if email exists
        $params = [
            'email' => $email
        ];

        $user = $this->db->query('SELECT * FROM users WHERE email = :email', $params)->fetch();

        if ($user) {
            $errors['email'] = 'That email already exists';
            loadView('users/create', [
                'errors' => $errors
            ]);
            exit;
        }

        // Create user account
        $params = [
            'given_name' => $given_name,
            'family_name' => $family_name,
            'prefer_name' => $prefer_name,
            'email' => $email,
            'city' => $city,
            'state' => $state,
            'country' => $country,
            'password' => password_hash($password, PASSWORD_DEFAULT),
            'created_at' => $created_at
        ];

        $this->db->query('INSERT INTO users (given_name, family_name, prefer_name, email, city, state, country, password, created_at) 
        VALUES (:given_name, :family_name, :prefer_name, :email, :city, :state, :country, :password, :created_at)', $params);

        // Get new user ID
        $userId = $this->db->conn->lastInsertId();

        // Set user session
        Session::set('user', [
            'id' => $userId,
            'given_name' => $given_name,
            'family_name' => $family_name,
            'prefer_name' => $prefer_name,
            'email' => $email,
            'city' => $city,
            'state' => $state,
            'country'=>$country
        ]);

        redirect('/dashboard');
    }

    //Taken from ProductController in products
     /**
     * Show the user edit form
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

        $user = $this->db->query('SELECT * FROM users WHERE id = :id', $params)->fetch();

        // Authorisation
        if (!Authorisation::isOwner($user->id)) {
            Session::setFlashMessage('error_message',
                'You are not authorized to update this user');
            return redirect('/users/' . $user->id);
        }

        loadView('users/edit', [
            'user' => $user
        ]);
        return null;
    }

    /**
     * Update a user
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

        $user = $this->db->query('SELECT * FROM users WHERE id = :id', $params)->fetch();

        // Authorisation
        if (!Authorisation::isOwner($user->id)) {
            Session::setFlashMessage('error_message',
                'You are not authorised to update this user');
            return redirect('/users/' . $user->id);
        }

        $allowedFields = ['given_name', 'family_name', 'prefer_name', 'city', 'state', 'country', 'email', 'password'];

        $updateValues = array_intersect_key($_POST, array_flip($allowedFields)) ?? [];

        $updateValues = array_map('sanitize', $updateValues);

        $requiredFields = ['given_name', 'prefer_name', 'city', 'state', 'country', 'email', 'password'];

        $errors = [];

        foreach ($requiredFields as $field) {
            if (empty($updateValues[$field]) || !Validation::string($updateValues[$field])) {
                $errors[$field] = ucfirst($field) . ' is required';
            }
        }

        if (!empty($errors)) {
            loadView('users/edit', [
                'user' => $user,
                'errors' => $errors
            ]);
            exit;
        }

        if (isset($updateValues['password'])) {
            $password = $updateValues['password'] ?? '';
            $updateValues['password'] = password_hash($password, PASSWORD_DEFAULT);
        }

        $updateValues['updated_at'] = date('Y-m-d H:i:s') ?? '';

        // Submit to database
        $updateFields = [];

        foreach (array_keys($updateValues) as $field) {
            $updateFields[] = "{$field} = :{$field}";
        }

        $updateFields = implode(', ', $updateFields);

        $updateQuery = "UPDATE users SET $updateFields WHERE id = :id";

        //Debug by Claude AI https://claude.ai/share/c567ee21-075e-4715-9cc5-0d4f751a606a
        $updateValues['id'] = $id;

        $this->db->query($updateQuery, $updateValues);

        // Set flash message
        Session::setFlashMessage('success_message', 'User updated');

        redirect('/users/'. $id . '/edit');

    }

    /**
     * Logout a user and kill session
     *
     * @return void
     */
    public function logout()
    {
        Session::clearAll();

        $params = session_get_cookie_params();
        setcookie('PHPSESSID', '', time() - 86400, $params['path'], $params['domain']);

        redirect('/auth/login');
    }

    /**
     * Authenticate a user with email and password
     *
     * @return void
     */
    public function authenticate()
    {
        $email = $_POST['email'];
        $password = $_POST['password'];

        $errors = [];

        // Validation
        if (!Validation::email($email)) {
            $errors['email'] = 'Please enter a valid email';
        }

        if (!Validation::string($password, 6, 50)) {
            $errors['password'] = 'Password must be at least 6 characters';
        }

        // Check for errors
        if (!empty($errors)) {
            loadView('users/login', [
                'errors' => $errors
            ]);
            exit;
        }

        // Check for email
        $params = [
            'email' => $email
        ];

        $user = $this->db->query('SELECT * FROM users WHERE email = :email', $params)->fetch();

        if (!$user) {
            $errors['email'] = 'Incorrect credentials';
            loadView('users/login', [
                'errors' => $errors
            ]);
            exit;
        }

        // Check if password is correct
        if (!password_verify($password, $user->password)) {
            $errors['email'] = 'Incorrect credentials';
            loadView('users/login', [
                'errors' => $errors
            ]);
            exit;
        }

        // Set user session
        Session::set('user', [
            'id' => $user->id,
            'given_name' => $user->given_name,
            'family_name' => $user->family_name,
            'prefer_name' => $user->prefer_name,
            'email' => $user->email,
            'city' => $user->city,
            'state' => $user->state,
            'country' => $user->country
        ]);

        redirect('/dashboard');
    }
}