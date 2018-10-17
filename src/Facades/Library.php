<?php

namespace CeddyG\ClaraLibrary\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @see \CeddyG\ClaraDataflow\Dataflow
 */
class Library extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'clara.library';
    }
}
