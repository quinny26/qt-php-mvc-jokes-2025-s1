<?php
/**
 * About Page View
 *
 * Filename:        home.view.php
 * File comments/description:  This view is the about view, stating the details of the project and about the developer. 
 * Code taken from the original home.view.php and modified
 * Location:        /App/views
 * Project:         SaaS-Vanilla-MVC
 * Date Created:    5/4/2025
 *
 * Author:          Quinny Trang <20026235@tafe.wa.edu.au>
 *
 */

loadPartial('header');
loadPartial('navigation');

?>

<main class="container mx-auto bg-zinc-50 py-8 px-4 shadow shadow-black/25 rounded-lg">
    <article  class="grid grid-cols-1">
        <header class="bg-zinc-700 text-zinc-200 -mx-4 -mt-8 mb-4 p-8 text-2xl font-bold rounded-t-lg">
            <h1>About</h1>
        </header>
    </article>

    <article class="grid grid-cols-2 ">
        <section class="m-4 bg-zinc-200 text-zinc-700 p-8 rounded-lg shadow">
            <dl class="flex flex-col">
                <dt class="text-lg font-semibold ">About the Developer: </dt>
                <dd class="ml-4">
                My name is Quinny, I’m currently finishing my Certificate 4 in Programming and Diploma in Information Technology (Back-End).
I like learning languages, I used to read manga and books a lot in my free time but now I replace it with dramas and anime.
                </dd>
               
        </section>


            <section class="m-4 bg-zinc-200 text-zinc-700 p-8 rounded-lg shadow">
                <dl class="flex flex-col">
                <dt class="text-lg font-semibold">Overview of the Application:</dt>
                <dd class="ml-4">
                This application is a Vanilla PHP MVC where users can register their account, log in and contribute their good jokes and humour on the site.
Users can also browse the jokes without having to log in, or view a particular joke that is in their liking.
Registered users can add, edit and delete their jokes once logged in.
                </dd>
                </dl>
            </section>

        <section class="m-4 bg-zinc-200 text-zinc-700 p-8 rounded-lg shadow">
            <dl class="flex flex-col">

                <dt class="text-lg font-semibold">Details of the Application: </dt>
                    <dd class="ml-4">
                    This application is code in languages and framework such as: HTML, CSS, TailwindCSS, PHP and JavaScript.
                    </dd>

            </dl>

        </section>

    </article>
</main>


<?php
loadPartial('footer');
?>
