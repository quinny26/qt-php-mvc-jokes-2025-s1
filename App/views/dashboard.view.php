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

<main class="container mx-auto bg-gray-50 py-8 px-4 shadow shadow-black/25 rounded-lg">
    <article>
        <header class="bg-gray-700 text-gray-200 -mx-4 -mt-8 p-8 text-2xl font-bold mb-2 rounded-t-lg">
            <h1>Vanilla PHP MVC Demo</h1>
        </header>

        </section>

        <section class="my-8 grid grid-cols-1 md:grid-cols-3 lg:grid-cols-4 gap-8 justify-center">

            <?php
            foreach ($jokes ?? [] as $joke):
                ?>
                <!--            article>(header>h4{Name})+(section>p{Description})+(footer>p{Price})-->
                <article class="bg-gray-100 border border-gray-400 shadow rounded flex flex-col overflow-hidden">
                    <header class="-mx-2 bg-gray-700 text-gray-200 text-lg rounded-t flex-0">
                        <h4 class="h-20 px-6 py-2">
                            <?= $joke->title ?>
                        </h4>
                    </header>
                    <section class="flex-grow grid grid-cols-4">
                <h5 class="col-span-1 text-lg font-bold w-1/6 min-w-1/6">
                    Image:
                </h5>
                <p class="col-span-1 md:col-span-3 ">
                    <img class="w-64 h-64 rounded-lg"
                         src="https://dummyimage.com/200x200/<?php printf( "%06X", mt_rand( 0, 0xFFFFFF )); ?>/fff&text=Image+Here"
                         alt="">
                </p>

                <h5 class="text-lg font-bold col-span-1 mt-4">
                    Joke Body
                </h5>
                <section class="col-span-1 md:col-span-3  max-w-96 description mt-4">
                    <?= $joke->body ?>
                </section>

                <h5 class="text-lg font-bold col-span-1 mt-4">
                    Joke Category
                </h5>
                <section class="col-span-1 md:col-span-3  max-w-96 description mt-4">
                    <?= $joke->category_name ?>
                </section>

                <h5 class="text-lg font-bold col-span-1 mt-4">
                    Joke tags
                </h5>
                <section class="col-span-1 md:col-span-3  max-w-96 description mt-4">
                    <?= $joke->tags ?>
                </section>

                <h5 class="text-lg font-bold col-span-1 mt-4">
                    Author
                </h5>
                <section class="col-span-1 md:col-span-3  max-w-96 description mt-4">
                    <?= $joke->user_prefer_name ?>
                </section>
            </section>
                    <footer class="-mx-2 bg-gray-200 text-gray-900 text-sm px-4 py-4 -mb-2 rounded-b flex-0 flex justify-between">
                        <a href="/jokes/<?= $joke->id ?>"
                           class="btn">
                            More details...
                        </a>
                    </footer>
                </article>

            <?php
            endforeach
            ?>
        </section>

    </article>
</main>


<?php
loadPartial('footer');
?>
