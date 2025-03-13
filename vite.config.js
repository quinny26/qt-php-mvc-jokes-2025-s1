/**
 * Vite Configuration File
 *
 * Filename:        vite.config.js
 * Location:        /
 * Project:         XXX-SaaS-Vanilla-MVC-YYYY-SN
 * Date Created:    2025-03-13
 *
 * Author:          Adrian Gould <adrian.gould@nmtafe.wa.edu.au>
 */

import {defineConfig} from 'vite'
import tailwindcss from '@tailwindcss/vite'
import usePHP from 'vite-plugin-php'
import liveReload from 'vite-plugin-live-reload'

export default defineConfig({
    plugins: [
        tailwindcss(),
        usePHP({
            entry: [
                'index.php',
                'template.php',
                'public/index.{html,php,js}',
                'App/views/**/*.{html,php,js}'
            ],
        }),
        liveReload([
                'index.php',
                'template.php',
                'public/index.{html,php,js}',
                'App/views/**/*.{html,php,js}'
            ],
            {
                alwaysReload: true
            }
        ),
    ]
}) ;
