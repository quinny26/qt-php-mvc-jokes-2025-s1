<?php
/**
 * Home Page View
 *
 * Filename:        home.view.php
 * File comment/description:   Showing random jokes and 6 latest jokes when users are not logged in and show statistic when users are logged in. 
 * The code for this view is a combination of dashboard.view.php, show.view.php, and the original home.view.php
 * Location:        /App/views
 * Project:         SaaS-Vanilla-MVC
 * Date Created:    23/08/2024
 *
 * Author:          Quinny Trang <20206235@nmtafe.wa.edu.au>
 *
 */

loadPartial('header');
loadPartial('navigation');

?>


<main class="container mx-auto bg-zinc-50 py-8 px-4 shadow shadow-black/25 rounded-lg">
    <article class="grid grid-cols-1">
        <header class="bg-zinc-700 text-zinc-200 -mx-4 -mt-8 mb-4 p-8 text-2xl font-bold rounded-t-lg">
            <h1>Home</h1>
        </header>
    </article>

    <?php if($isAuthenticated): ?>
    <section class="grid grid-cols-2 mx-4 md:grid-cols-2 gap-6 mb-8">
        <div class="bg-gray-100 dark:bg-gray-800 rounded-lg shadow overflow-hidden flex">
            <div class="bg-prussianblue-500 dark:bg-prussianblue-800 text-prussianblue-800 dark:text-prussianblue-500 p-4 flex flex-col items-center justify-center w-24">
                <i class="fa fa-mug-saucer text-4xl"></i>
                <span class="text-xs font-medium mt-2">Jokes</span>
            </div>
            <div class="p-6 flex items-center justify-center flex-grow">
                <p class="text-4xl font-semibold text-gray-700 dark:text-gray-200">
                    <?= $jokeCount->total ?>
                </p>
            </div>
        </div>

        <div class="bg-gray-100 dark:bg-gray-800 rounded-lg shadow overflow-hidden flex">
            <div class="bg-prussianblue-500 dark:bg-prussianblue-800 text-prussianblue-800 dark:text-prussianblue-500 p-4 flex flex-col items-center justify-center w-24">
                <i class="fa fa-users text-4xl"></i>
                <span class="text-xs font-medium mt-2">Users</span>
            </div>
            <div class="p-6 flex items-center justify-center flex-grow">
                <p class="text-4xl font-semibold text-gray-700 dark:text-gray-200">
                    <?= $userCount->total ?>
                </p>
            </div>
        </div>
    </section>
    <?php endif ?>

        <!-- Display random joke section -->
    <article class="mb-8">

        <h2 class="text-xl font-bold mb-4">Random Joke</h2>
        <a href="/home" class="bg-green-500 hover:bg-green-600 text-white px-4 py-2 rounded focus:outline-none"></i><span>New Random Joke</span></a>
        
        <?php if(empty($randomJoke)): ?>
            <div class="bg-yellow-100 border border-yellow-400 text-yellow-700 p-4 rounded">
                <p>No jokes are currently available in the database. Check back later!</p>
            </div>
        <?php else: ?>
            <article class="bg-gray-100 border border-gray-400 shadow rounded overflow-hidden">
                <header class="bg-gray-700 text-gray-200 text-lg rounded-t">
                    <h4 class="px-6 py-2">
                        <?= $randomJoke->title ?>
                    </h4>
                </header>
                <section class="p-4">
                    <p class="mb-4"><?= $randomJoke->body ?></p>
                    
                    <div class="grid grid-cols-2 gap-2 text-sm">
                        <div>
                            <span class="font-bold">Category:</span> 
                            <?= $randomJoke->category_name ?>
                        </div>
                        <div>
                            <span class="font-bold">Author:</span> 
                            <?= $randomJoke->user_prefer_name ?>
                        </div>
                        <div class="col-span-2">
                            <span class="font-bold">Tags:</span> 
                            <?= $randomJoke->tags ?>
                        </div>
                    </div>
                </section>
                <footer class="bg-gray-200 text-gray-900 text-sm px-4 py-2 flex justify-end">
                    <a href="/jokes/<?= $randomJoke->id ?>" class="btn">
                        More details...
                    </a>
                </footer>
            </article>
        <?php endif; ?>
    </article>

    <!-- Recent jokes section -->
    <article>
        <h2 class="text-xl font-bold mb-4">Recent Jokes</h2>
        
        <?php if(empty($jokes)): ?>
            <div class="bg-yellow-100 border border-yellow-400 text-yellow-700 p-4 rounded">
                <p>No jokes are currently available in the database. Check back later!</p>
            </div>
        <?php else: ?>
            <section class="my-8 grid grid-cols-1 md:grid-cols-3 lg:grid-cols-4 gap-8 justify-center">
                <?php foreach ($jokes as $joke): ?>
                    <article class="bg-gray-100 border border-gray-400 shadow rounded flex flex-col overflow-hidden">
                        <header class="-mx-2 bg-gray-700 text-gray-200 text-lg rounded-t">
                            <h4 class="px-6 py-2">
                                <?= $joke->title ?>
                            </h4>
                        </header>
                        <div class="p-4">
                            <!-- Image section -->
                            <div class="mb-6">
                                <h5 class="text-lg font-bold mb-2">Image:</h5>
                                <div>
                                    <img class="w-full h-64 object-cover rounded-lg"
                                        src="https://dummyimage.com/200x200/<?php printf( "%06X", mt_rand( 0, 0xFFFFFF )); ?>/fff&text=Image+Here"
                                        alt="">
                                </div>
                            </div>

                            <!-- Joke Body section -->
                            <div class="mb-4">
                                <h5 class="text-lg font-bold mb-2">Joke Body</h5>
                                <div class="description">
                                    <?= $joke->body ?>
                                </div>
                            </div>

                            <!-- Category section -->
                            <div class="mb-4">
                                <h5 class="text-lg font-bold mb-2">Joke Category</h5>
                                <div class="description">
                                    <?= $joke->category_name ?>
                                </div>
                            </div>

                            <!-- Tags section -->
                            <div class="mb-4">
                                <h5 class="text-lg font-bold mb-2">Joke tags</h5>
                                <div class="description">
                                    <?= $joke->tags ?>
                                </div>
                            </div>

                            <!-- Author section -->
                            <div class="mb-4">
                                <h5 class="text-lg font-bold mb-2">Author</h5>
                                <div class="description">
                                    <?= $joke->user_prefer_name ?>
                                </div>
                            </div>
                        </div>
                  
                                <footer class="-mx-2 bg-gray-200 text-gray-900 text-sm px-4 py-4 -mb-2 rounded-b flex-0 flex justify-between">
                                
                                    <a href="/jokes/<?= $joke->id ?>"
                                    class="btn">
                                        More details...
                                    </a>
                                </footer>
                                </article>
                            <?php endforeach; ?>
                        </section>
                    <?php endif; ?>
                </article>
</main>



<?php
loadPartial('footer');
?>
