<?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Symfony\AI\Platform\Bridge\AnythingLLM\Completions;

use Symfony\AI\Platform\Bridge\AnythingLLM\AbstractModelClient;
use Symfony\AI\Platform\Bridge\AnythingLLM\Completions;
use Symfony\AI\Platform\Model;
use Symfony\AI\Platform\Result\RawHttpResult;

/**
 * @author Marc LUCAS <marc@malucasfire.dev>
 */
final class ModelClient extends AbstractModelClient
{
    private const COMPLETIONS_ENDPOINT = '/api/v1/openai/chat/completions';

    public function supports(Model $model): bool
    {
        return $model instanceof Completions;
    }

    public function request(Model $model, array|string $payload, array $options = []): RawHttpResult
    {
        return $this->doRequest(self::COMPLETIONS_ENDPOINT, array_merge($options, $payload));
    }
}
