<?php

namespace Tests;

use Illuminate\View\Factory;

final class FakeViewFactory implements \Illuminate\Contracts\View\Factory
{
    public function flushFinderCache()
    {
    }

    public function exists($view)
    {
    }

    public function file($path, $data = [], $mergeData = [])
    {
    }

    public function make($view, $data = [], $mergeData = [])
    {
        return new FakeView('welcome');
    }

    public function share($key, $value = null)
    {
    }

    public function composer($views, $callback)
    {
    }

    public function creator($views, $callback)
    {
    }

    public function addNamespace($namespace, $hints)
    {
    }

    public function replaceNamespace($namespace, $hints)
    {
        return $this;
    }
}
