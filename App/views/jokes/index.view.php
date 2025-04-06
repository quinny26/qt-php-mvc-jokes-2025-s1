<?php
/**
 * FILE TITLE GOES HERE
 *
 * DESCRIPTION OF THE PURPOSE AND USE OF THE CODE
 * MAY BE MORE THAN ONE LINE LONG
 * KEEP LINE LENGTH TO NO MORE THAN 96 CHARACTERS
 *
 * Filename:        index.view.php
 * Location:        ${FILE_LOCATION}
 * Project:         SaaS-Vanilla-MVC
 * Date Created:    5/4/2025
 *
 * Author:          Quinny Trang <20026235@tafe.wa.edu.au>
 *
 */

/* Load HTML header and navigation areas */
loadPartial("header");
loadPartial('navigation');

?>

<main class="container mx-auto bg-zinc-50 py-8 px-4 shadow shadow-black/25 rounded-b-lg flex flex-col flex-grow">
    <article>
        <header class="bg-zinc-700 text-zinc-200 -mx-4 -mt-8 p-8 mb-8 flex">
            <h1 class="grow text-2xl font-bold ">Jokes</h1>
            <p class="text-md  px-8 py-2 bg-prussianblue-500 hover:bg-prussianblue-600 text-white rounded transition ease-in-out duration-500">
                <a href="/jokes/create">Add joke</a>
            </p>
        </header>

        <section class="text-xl text-zinc-500 my-8">
            <?php if (isset($keywords)) : ?>
                <p>Search Results for: <?= htmlspecialchars($keywords) ?></p>
                <p><?= count($jokes ?? []) ?> joke(s) found</p>
            <?php else : ?>
                <p>All Jokes</p>
            <?php endif; ?>

            <?= loadPartial('message') ?>
        </section>

        <section class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-8 ">
            <?php
            foreach ($jokes ?? [] as $joke):
                ?>

                <article class=" bg-white border border-zinc-400 shadow rounded flex flex-col overflow-hidden">
                    <header class="-mx-2 bg-zinc-700 text-zinc-200 text-lg p-4 rounded-t flex-0">
                        <h4>
                            <?= $joke->title ?>
                        </h4>
                    </header>

                    <section class="flex-grow p-4 ">
                        <div class="bg-white">
                            Category: <?= $joke->category_name ?>
                        </div>
                    </section>

                    <section class="flex-grow p-4 ">
                        <div class="bg-white">
                            Tags: <?= $joke->tags ?>
                        </div>
                    </section>

                    <section class="flex-grow p-4 ">
                        <div class="bg-white">
                            Author: <?= $joke->user_prefer_name ?? 'Unknown' ?>
                        </div>
                    </section>

                    <footer class="-mx-2 bg-zinc-200 text-zinc-900 text-sm px-4 py-4 -mb-2 rounded-b flex-0 flex justify-between">
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
loadPartial("footer");

