<?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Symfony\AI\Platform\Bridge\AnythingLLM;

use Psr\EventDispatcher\EventDispatcherInterface;
use Symfony\AI\Platform\Contract;
use Symfony\AI\Platform\ModelCatalog\ModelCatalogInterface;
use Symfony\AI\Platform\Platform;
use Symfony\Component\HttpClient\EventSourceHttpClient;
use Symfony\Contracts\HttpClient\HttpClientInterface;

/**
 * @author Marc LUCAS <marc@malucasfire.dev>
 */
class PlatformFactory
{
    public static function create(
        #[\SensitiveParameter] string $apiKey,
        string $hostUrl = 'http://127.0.0.1:3001',
        ?HttpClientInterface $httpClient = null,
        ModelCatalogInterface $modelCatalog = new ModelCatalog(),
        ?Contract $contract = null,
        ?EventDispatcherInterface $eventDispatcher = null,
    ): Platform {
        $httpClient = $httpClient instanceof EventSourceHttpClient ? $httpClient : new EventSourceHttpClient($httpClient);

        return new Platform(
            [
                new Embeddings\ModelClient($httpClient, $apiKey, $hostUrl),
                new Completions\ModelClient($httpClient, $apiKey, $hostUrl),
            ],
            [
                new Embeddings\ResultConverter(),
                new Completions\ResultConverter(),
            ],
            $modelCatalog,
            $contract,
            $eventDispatcher,
        );
    }
}
