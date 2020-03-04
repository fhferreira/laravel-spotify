<?php

namespace Aerni\Spotify\Tests;

use Orchestra\Testbench\TestCase as Orchestra;
use Illuminate\Foundation\Bootstrap\LoadEnvironmentVariables;

abstract class TestCase extends Orchestra
{
    protected function getEnvironmentSetUp($app): void
    {
        // Load the .env file
        $app->useEnvironmentPath(__DIR__ . '/..');
        $app->bootstrapWith([LoadEnvironmentVariables::class]);
        parent::getEnvironmentSetUp($app);

        // Set the config with the provided .env variables
        $app['config']->set('spotify', [
            'auth' => [
                'client_id' => env('SPOTIFY_CLIENT_ID'),
                'client_secret' => env('SPOTIFY_CLIENT_SECRET'),
            ],
            'default_config' => [
                'country' => env('SPOTIFY_DEFAULT_COUNTRY'),
                'locale' => env('SPOTIFY_DEFAULT_LOCALE'),
                'market' => env('SPOTIFY_DEFAULT_MARKET'),
            ],
        ]);
    }

    protected function getPackageProviders($app): array
    {
        return [
            'Kozz\Laravel\Providers\Guzzle',
            'Aerni\Spotify\SpotifyServiceProvider'
        ];
    }

    protected function getPackageAliases($app): array
    {
        return [
            'Guzzle' => 'Kozz\Laravel\Facades\Guzzle',
            'Spotify' => 'Aerni\Spotify\SpotifyFacade',
        ];
    }
}