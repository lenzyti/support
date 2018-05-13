<?php

namespace Lenzy\Support\Domain;

use Illuminate\Support\Collection;
use Illuminate\Support\ServiceProvider as LaravelServiceProvider;
use Migrator\MigratorTrait as HasMigrations;
use ReflectionClass;

abstract class ServiceProvider extends LaravelServiceProvider
{
    use HasMigrations;

    /**
     * @var string Alias ​​de domínio para traduções e outras chaves.
     */
    protected $alias;

    /**
     * @var array Lista de provedores de domínio para registrar.
     */
    protected $providers;

    /**
     * @var array Ligações de contrato.
     */
    protected $bindings = [];

    /**
     * @var array Lista de migrações fornecidas pelo domínio.
     */
    protected $migrations = [];

    /**
     * @var array Lista de semeadoras fornecidas pelo domínio.
     */
    protected $seeders = [];

    /**
     * @var array Lista de fábricas modelo para carregar.
     */
    protected $factories = [];

    /**
     * @var bool Ativar traduções para este domínio.
     */
    protected $hasTranslations = false;

    public function boot()
    {
        // Registre traduções.
        if ($this->hasTranslations) {
            $this->registerTranslations();
        }
    }

    /**
     * Registre o domínio atual.
     */
    public function register()
    {
        // Registre provedores.
        $this->registerProviders(collect($this->providers));
        // Registre ligações.
        $this->registerBindings(collect($this->bindings));
        // Registre migrações.
        $this->registerMigrations(collect($this->migrations));
        // Registrar semeadoras.
        $this->registerSeeders(collect($this->seeders));
        // Registre fábricas de modelos.
        $this->registerFactories(collect($this->factories));
    }

    /**
     * Registre provedores de domínio.
     *
     * @param Collection $providers
     */
    protected function registerProviders(Collection $providers)
    {
        $providers->each(function ($provider) {
            $this->app->register($provider);
        });
    }

    /**
     * Registre as ligações de domínio definidas.
     *
     * @param Collection $bindings
     */
    protected function registerBindings(Collection $bindings)
    {
        $bindings->each(function ($concretion, $abstraction) {
            $this->app->bind($abstraction, $concretion);
        });
    }

    /**
     * Registre as migrações definidas.
     *
     * @param Collection $migrations
     */
    protected function registerMigrations(Collection $migrations)
    {
        $this->migrations($migrations->all());
    }

    /**
     * Registre as semeadoras definidas.
     *
     * @param Collection $seeders
     */
    protected function registerSeeders(Collection $seeders)
    {
        $this->seeders($seeders->all());
    }

    /**
     * Registrar fábricas de modelos.
     *
     * @param Collection $factories
     */
    protected function registerFactories(Collection $factories)
    {
        $factories->each(function ($factoryName) {
            (new $factoryName())->define();
        });
    }

    /**
     * Registre traduções de domínio.
     */
    protected function registerTranslations()
    {
        $this->loadTranslationsFrom(
            $this->domainPath('Resources/Lang'),
            $this->alias
        );
    }

    /**
     * @param string $append
     *
     * @return string
     */
    protected function domainPath($append = null)
    {
        $reflection = new ReflectionClass($this);
        $realPath = realpath(dirname($reflection->getFileName()) . '/../');

        if (! $append) {
            return $realPath;
        }

        return $realPath . '/' . $append;
    }
}
