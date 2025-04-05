<?php
/**
 * Home Page View
 *
 * Filename:        home.view.php
 * Location:        /App/views
 * Project:         SaaS-Vanilla-MVC
 * Date Created:    23/08/2024
 *
 * Author:          Adrian Gould <Adrian.Gould@nmtafe.wa.edu.au>
 *
 */

loadPartial('header');
loadPartial('navigation');

?>

<main class="container mx-auto bg-zinc-50 py-8 px-4 shadow shadow-black/25 rounded-lg">
    <article  class="grid grid-cols-1">
        <header class="bg-zinc-700 text-zinc-200 -mx-4 -mt-8 mb-4 p-8 text-2xl font-bold rounded-t-lg">
            <h1>Home</h1>
        </header>
    </article>

    <article class="grid grid-cols-2 ">
        <section class="m-4 bg-zinc-200 text-zinc-700 p-8 rounded-lg shadow">
            <dl class="flex flex-col">
            <a href="/home" class="bg-green-500 hover:bg-green-600 text-white px-4 py-2 rounded focus:outline-none flex justify-center"></i><span>New Joke</span></a>
                <dt class="text-lg font-semibold ">Jokes</dt>
                <dd class="ml-4">
                    <p>Jokes Here</p>
                </dd>
            </dl>
        </section>

    </article>
</main>


<?php
loadPartial('footer');
?>
