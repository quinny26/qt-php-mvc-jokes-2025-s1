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

        <section class="my-8 flex flex-wrap gap-8 justify-center">

            <h3 class="text-3xl font-light">Welcome to the XXX SaaS Vanilla MVC YYYY/SN Template App</h3>

        </section>

        <section class="mx-auto w-1/2 m-8 bg-zinc-200 text-zinc-800 p-8 rounded-lg shadow">
            <dl class="flex flex-col">
                <dt class="text-lg pt-4">Tutorial:</dt>
                <dd class="ml-4">Parts 00 - 04:
                    <a href="https://github.com/AdyGCode/SaaS-FED-Notes/tree/main/session-07"
                        class="hover:text-black">
                        https://github.com/AdyGCode/SaaS-FED-Notes/tree/main/session-07
                    </a>
                </dd>
                <dd class="ml-4">Parts 05 - 10:
                    <a href="https://github.com/AdyGCode/SaaS-FED-Notes/tree/main/session-08"
                        class="hover:text-black">
                        https://github.com/AdyGCode/SaaS-FED-Notes/tree/main/session-07
                    </a>
                </dd>

                <dt class="text-lg pt-4">Source Code:</dt>
                <dd class="ml-4">
                    <a href="https://github.com/AdyGCode/XXX-SaaS-Vanilla-MVC-YYYY-SN"
                        class="hover:text-black">
                        https://github.com/AdyGCode/XXX-SaaS-Vanilla-MVC-YYYY-SN
                    </a>
                </dd>

                <dt class="text-lg pt-4">HelpDesk</dt>
                <dd class="ml-4"><a href="https://help.screencraft.net.au"
                        class="hover:text-black">Home Page</a></dd>
                <dd class="ml-4"><a href="https://help.screencraft.net.au/hc/2680392001"
                        class="hover:text-black">FAQs</a></dd>
                <dd class="ml-4"><a href="https://help.screencraft.net.au/help/2680392001"
                        class="hover:text-black">Make a HelpDesk Request (TAFE Students only)</a></dd>
            </dl>

        </section>

    </article>
</main>


<?php
loadPartial('footer');
?>
