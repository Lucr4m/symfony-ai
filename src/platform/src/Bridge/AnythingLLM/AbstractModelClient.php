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

use Symfony\AI\Platform\Bridge\AnythingLLM\Embeddings;
use Symfony\AI\Platform\Model;
use Symfony\AI\Platform\ModelClientInterface;
use Symfony\AI\Platform\Result\RawHttpResult;
use Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;

/**
 * @author Marc LUCAS <marc@malucasfire.dev>
 */
abstract class AbstractModelClient implements ModelClientInterface
{
    public function __construct(
        protected readonly HttpClientInterface $httpClient,
        #[\SensitiveParameter] private readonly string $apiKey,
        private readonly string $hostUrl,
    ) {
    }

    /**
     * @throws TransportExceptionInterface
     */
    protected function doRequest(string $endpoint, array $payload, string $method = 'POST'): RawHttpResult
    {
        return new RawHttpResult($this->httpClient->request($method, $this->hostUrl.$endpoint, [
            'auth_bearer' => $this->apiKey,
            'json' => $payload,
        ]));
    }
}
