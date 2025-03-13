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

<main class="container mx-auto bg-zinc-50 py-8 px-4 shadow shadow-black/25 rounded-b-lg">
    <article>
        <header class="bg-zinc-700 text-zinc-200 -mx-4 -mt-8 p-8 text-2xl font-bold mb-8">
            <h1>Vanilla PHP MVC Demo</h1>
        </header>
        <section class="flex flex-row flex-wrap justify-center my-8 gap-8">

            <section class="w-1/4 bg-zinc-700 text-sky-300 shadow rounded p-2 flex flex-row">
                <h4 class="flex-0 w-1/2 -ml-2 mr-6 bg-sky-800 text-white text-lg p-4 -my-2 rounded-l">
                    Products:
                </h4>
                <p class="grow text-4xl ml-6">
                    <?= $productCount->total ?>
                </p>
            </section>

            <section class="w-1/4 bg-zinc-700 text-red-300 shadow rounded p-2 flex flex-row">
                <h4 class="flex-0 w-1/2 -ml-2 mr-6 bg-red-800 text-white text-lg p-4 -my-2 rounded-l">
                    Users:
                </h4>
                <p class="grow text-4xl ml-6">
                    <?= $userCount->total ?>
                </p>
            </section>

        </section>

        <section class="my-8 grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8 justify-center">

            <?php
            foreach ($products as $product):
                ?>
                <!--            article>(header>h4{Name})+(section>p{Description})+(footer>p{Price})-->
                <article class="bg-white border border-zinc-400 shadow rounded flex flex-col overflow-hidden">
                    <header class="-mx-2 bg-zinc-700 text-zinc-200 text-lg rounded-t flex-0">
                        <h4 class="h-20 px-6 py-2">
                            <?= $product->name ?>
                        </h4>
                    </header>
                    <img class="h-24 md:h-48 lg:h-56 w-full object-cover" src="https://picsum.photos/640/480"
                         alt="">
                    <section class="flex-grow p-4">
                        <div class="text-zinc-600 bg-white parsedown">
                            <?= $product->description ?>
                        </div>
                    </section>
                    <footer class="-mx-2 bg-zinc-200 text-zinc-900 text-sm px-4 py-4 -mb-2 rounded-b flex-0 flex justify-between">
                        <p class="">Price: $<?= $product->price / 100 ?></p>
                        <a href="/products/<?= $product->id ?>"
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
