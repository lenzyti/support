<?php

namespace Lenzy\Support\Units;

use Illuminate\Support\Collection;
use Illuminate\Support\ServiceProvider as LaravelServiceProvider;

abstract class ServiceProvider extends LaravelServiceProvider
{
    /**
     * @var array Lista de fornecedores de serviços da unidade a registar.
     */
    protected $providers = [];

    /**
     * @var string Alias ​​da unidade para traduções e visualizações.
     */
    protected $alias;

    /**
     * @var bool Ativar visualizações carregando na unidade.
     */
    protected $hasViews = false;

    /**
     * @var bool Ativar traduções carregando na unidade.
     */
    protected $hasTranslations = false;

    /**
     * A inicialização exige o registro de visualizações e traduções.
     */
    public function boot()
    {
        // registrar traduções da unidade.
        $this->registerTranslations();
        // registrar visualizações da unidade.
        $this->registerViews();
    }

    public function register()
    {
        // registrar domínios personalizados da unidade.
        $this->registerProviders(collect($this->providers));
    }

    /**
     * Registra os provedores de serviços personalizados da unidade.
     *
     * @param Collection $providers
     */
    protected function registerProviders(Collection $providers)
    {
        // loop através de provedores de serviços para ser registrado.
        $providers->each(function ($providerClass) {
            // registrar uma classe de provedor de serviço.
            $this->app->register($providerClass);
        });
    }

    /**
     * Registra traduções das unidades.
     */
    protected function registerTranslations()
    {
        if ($this->hasTranslations) {
            $this->loadTranslationsFrom(
                $this->unitPath('Resources/Lang'),
                $this->alias
            );
        }
    }

    /**
     * Registra visualizações das unidades.
     */
    protected function registerViews()
    {
        if ($this->hasViews) {
            $this->loadViewsFrom(
                $this->unitPath('Resources/Views'),
                $this->alias
            );
        }
    }

    /**
     * Detecta o caminho base da unidade para que os recursos possam ser carregados adequadamente
     * em classes de crianças.
     *
     * @param string $append
     *
     * @return string
     */
    protected function unitPath($append = null)
    {
        $reflection = new \ReflectionClass($this);
        $realPath = realpath(dirname($reflection->getFileName()) . '/../');

        if (! $append) {
            return $realPath;
        }

        return $realPath . '/' . $append;
    }
}