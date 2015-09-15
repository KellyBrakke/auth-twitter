<?php namespace Flarum\Twitter\Listeners;

use Flarum\Events\RegisterLocales;
use Flarum\Events\BuildClientView;
use Flarum\Events\RegisterForumRoutes;
use Illuminate\Contracts\Events\Dispatcher;

class AddClientAssets
{
    public function subscribe(Dispatcher $events)
    {
        $events->listen(RegisterLocales::class, [$this, 'addLocale']);
        $events->listen(BuildClientView::class, [$this, 'addAssets']);
        $events->listen(RegisterForumRoutes::class, [$this, 'addLoginRoute']);
    }

    public function addLocale(RegisterLocales $event)
    {
        $event->addTranslations('en', __DIR__.'/../../locale/en.yml');
    }

    public function addAssets(BuildClientView $event)
    {
        $event->forumAssets([
            __DIR__.'/../../js/forum/dist/extension.js',
            __DIR__.'/../../less/forum/extension.less'
        ]);

        $event->forumBootstrapper('twitter/main');

        $event->forumTranslations([
            // 'twitter.hello_world'
        ]);

        $event->adminAssets([
            __DIR__.'/../../js/admin/dist/extension.js'
        ]);

        $event->adminBootstrapper('twitter/main');

        $event->adminTranslations([
            // 'twitter.hello_world'
        ]);
    }

    public function addLoginRoute(RegisterForumRoutes $event)
    {
        $event->get('/login/twitter', 'twitter.login', 'Flarum\Twitter\LoginAction');
    }
}
