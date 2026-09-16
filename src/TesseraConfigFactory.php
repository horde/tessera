<?php

declare(strict_types=1);
/**
 * Tessera configuration class factory
 *
 * Creates instances of the TesseraConfig class.
 *
 * Old pattern: globals $conf; $somethingDetail = $conf['something']['detail']; *
 * New pattern: $config = $injector->get(TesseraConfig::class); $somethingDetail = $config->get('something.detail');
 *
 * Prefer DI over instantiating $config in your code.
 */

namespace Horde\Tessera;

use Horde\Core\Config\ConfigLoader;
use Horde\Injector\Injector;

class TesseraConfigFactory
{
    public function __construct(private Injector $injector) {}

    public function create(): TesseraConfig
    {
        $state = $this->injector->get(ConfigLoader::class)->load('tessera');
        return new TesseraConfig($state->toArray());
    }
}
