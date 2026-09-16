<?php

declare(strict_types=1);
/**
 * Tessera configuration class
 *
 * Provides access to the Tessera configuration settings.
 *
 * Old pattern: globals $conf; $somethingDetail = $conf['something']['detail']; *
 * New pattern: $config = $injector->get(TesseraConfig::class); $somethingDetail = $config->get('something.detail');
 *
 * Prefer DI over instantiating $config in your code.
 */

namespace Horde\Tessera;

use Horde\Core\Config\State;
use Horde\Injector\Attribute\Factory;

#[Factory(factory: TesseraConfigFactory::class, method: 'create')]
class TesseraConfig extends State {}
