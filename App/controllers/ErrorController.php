<?php
/**
 * Error Controller 
 *
 * This file handle the error when a page cannot be found or unathorised access error
 *
 * Filename:        ErrorController.php
 * Location:
 * Project:         SaaS-Vanilla-MVC
 * Date Created:    5/4/2025
 *
 * Author:          Quinny Trang <20026235@tafe.wa.edu.au>
 *
 */

namespace App\Controllers;

/**
 * Error Controller Class
 *
 * Provides static methods for the display of common
 * HTTP error codes including 404 and 403.
 */
class ErrorController
{
    /**
     * 404 not found error
     *
     * Provides the error view with the 404 (not found) error code
     * and a suitable message.
     *
     * @param string $message an optional message string
     * @return void
     */
    public static function notFound($message = 'Resource not found')
    {
        http_response_code(404);

        loadView('error', [
            'status' => '404',
            'message' => $message
        ]);
    }

    /**
     * 403 unauthorized error
     *
     * Provides the error view with the status of 403
     * and a suitable message.
     *
     * @param string $message an optional message string
     * @return void
     */
    public static function unauthorized($message = 'You are not authorized to view this resource')
    {
        http_response_code(403);

        loadView('error', [
            'status' => '403',
            'message' => $message
        ]);
    }

}