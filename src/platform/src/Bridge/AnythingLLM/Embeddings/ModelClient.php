<?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Symfony\AI\Platform\Bridge\AnythingLLM\Embeddings;

use Symfony\AI\Platform\Bridge\AnythingLLM\AbstractModelClient;
use Symfony\AI\Platform\Bridge\AnythingLLM\Embeddings;
use Symfony\AI\Platform\Model;
use Symfony\AI\Platform\Result\RawHttpResult;

/**
 * @author Marc LUCAS <marc@malucasfire.dev>
 */
final class ModelClient extends AbstractModelClient
{
    private const EMBEDDINGS_ENDPOINT = '/api/v1/openai/embeddings';

    public function supports(Model $model): bool
    {
        return $model instanceof Embeddings;
    }

    public function request(Model $model, array|string $payload, array $options = []): RawHttpResult
    {
        return $this->doRequest(self::EMBEDDINGS_ENDPOINT, array_merge($options, [
            'model' => $model->getName(),
            'input' => $payload,
        ]));
    }
}
