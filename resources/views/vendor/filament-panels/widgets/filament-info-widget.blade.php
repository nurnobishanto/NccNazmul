<x-filament-widgets::widget class="fi-filament-info-widget">
    <x-filament::section>
        <div class="flex items-center gap-x-3">
            <div class="flex-1">


                <p class="mt-2 text-xs text-gray-500 dark:text-gray-400">
                  Laravel : v{{ Illuminate\Foundation\Application::VERSION }} (PHP v{{ PHP_VERSION }}),

                </p>
                <p class="mt-2 text-xs text-gray-500 dark:text-gray-400">
                  Filament : {{ \Composer\InstalledVersions::getPrettyVersion('filament/filament') }}
                </p>
            </div>

            <div class="flex flex-col items-end gap-y-1">
                <x-filament::link
                    color="gray"
                    href="tel:+880 1770 634816"
                    icon="heroicon-m-phone"
                    icon-alias="panels::widgets.filament-info.open-documentation-button"
                    rel="noopener noreferrer"
                    target="_blank"
                >
                    +880 1770 634816
                </x-filament::link>

                <x-filament::link
                    color="gray"
                    href="https://soft-itbd.com"
                    icon-alias="panels::widgets.filament-info.open-github-button"
                    rel="noopener noreferrer"
                    target="_blank">
                    Developed by SOFT-ITBD - Smart IT Solution
                </x-filament::link>
            </div>
        </div>
    </x-filament::section>
</x-filament-widgets::widget>
