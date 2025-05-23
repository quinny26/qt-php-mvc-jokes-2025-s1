<?php
/**
 * Edit View File
 *
 * Filename:        index.view.php
 * File comment/description: This file show the edit page where resgitered can edit their jokes when logged in. 
 * Code was taken from edit.view.php from products and modified
 * Location:        ${FILE_LOCATION}
 * Project:         SaaS-Vanilla-MVC
 * Date Created:    5/4/2025
 *
 * Author:          Quinny Trang <20026235@nmtafe.wa.edu.au>
 *
 */

loadPartial("header");
loadPartial('navigation');

?>
    <script src="https://cdn.ckeditor.com/ckeditor5/10.0.1/classic/ckeditor.js"></script>
    <script src="/assets/js/editor.js"></script>

    <main class="container mx-auto bg-zinc-50 py-8 px-4 shadow shadow-black/25 rounded-b-lg flex flex-col flex-grow">
        <article>
            <header class="bg-zinc-700 text-zinc-200 -mx-4 -mt-8 p-8 mb-8 flex">
                <h1 class="grow text-2xl font-bold ">Jokes - Edit</h1>

            </header>

            <section>
                <?= loadPartial('message') ?>

                <?= loadPartial('errors', [
                    'errors' => $errors ?? []
                ]) ?>

               
                <form id="JokeForm" method="POST" action="/jokes/<?= $joke->id ?>">
                    <input type="hidden" name="_method" value="PUT">

                    <h2 class="text-2xl font-bold mb-6 text-left text-gray-500">
                        Joke Information
                    </h2>

                    <div class="mb-4">
                        <label for="Title">Joke Title:</label>
                        <input id="Title" type="text" name="title" placeholder="Joke Title"
                               class="w-full px-4 py-2 border rounded focus:outline-none"
                               value="<?= $joke->title ?? '' ?>"/>
                    </div>

                    <div class="mb-4">
                        <label for="tags">Joke Tags:</label>
                        <textarea id="tags" name="tags" placeholder="Joke Tags"
                                class="w-full px-4 py-2 border rounded focus:outline-none"
                        ><?= $joke->tags ?? '' ?></textarea>
                    </div>

                    <div class="mb-4">
                        <label for="Body">Joke Body:</label>
                        <textarea id="Body" name="body" placeholder="Joke Body"
                                  class="w-full px-4 py-2 border rounded focus:outline-none"
                        ><?= $joke->body ?? '' ?></textarea>
                    </div>
                    
                    <div class="mb-4">
                        <label for="category_id">Joke Category:</label>
                        <select id="category_id" name="category_id" class="w-full px-4 py-2 border rounded focus:outline-none">
                            <option value="1" <?= ($joke->category_id == 1) ? 'selected' : '' ?>>unknown</option>
                            <option value="2" <?= ($joke->category_id == 2) ? 'selected' : '' ?>>web</option>
                            <option value="3" <?= ($joke->category_id == 3) ? 'selected' : '' ?>>knock knock</option>
                            <option value="4" <?= ($joke->category_id == 4) ? 'selected' : '' ?>>rude</option>
                            <option value="5" <?= ($joke->category_id == 5) ? 'selected' : '' ?>>dogs</option>
                            <option value="6" <?= ($joke->category_id == 6) ? 'selected' : '' ?>>cats</option>
                            <option value="7" <?= ($joke->category_id == 7) ? 'selected' : '' ?>>halloween</option>
                            <option value="8" <?= ($joke->category_id == 8) ? 'selected' : '' ?>>animal</option>
                            <option value="9" <?= ($joke->category_id == 9) ? 'selected' : '' ?>>geek</option>
                            <option value="10" <?= ($joke->category_id == 10) ? 'selected' : '' ?>>programmer</option>
                            <option value="11" <?= ($joke->category_id == 11) ? 'selected' : '' ?>>dad</option>
                        </select>
                    </div>

                    <div class="grid grid-cols-4 gap-8">
                        <button type="submit"
                                class="w-full bg-green-500 hover:bg-green-600 text-white px-4 py-2
                               rounded focus:outline-none flex justify-center">
                            <i class="fa fa-check inline-block mr-4"></i>
                            <span>Save</span>
                        </button>

                        <a href="/jokes"
                           class="text-center w-full bg-red-500 hover:bg-red-600 text-white px-4 py-2
                   rounded focus:outline-none flex justify-center">
                            <i class="fa fa-cancel inline-block mr-4"></i>
                            <span>Cancel</span>
                        </a>
                    </div>

                </form>

            </section>

        </article>
    </main>

<?php
loadPartial("footer");

