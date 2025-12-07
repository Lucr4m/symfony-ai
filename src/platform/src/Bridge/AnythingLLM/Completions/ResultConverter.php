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

use Symfony\AI\Platform\Bridge\AnythingLLM\Completions;
use Symfony\AI\Platform\Bridge\OpenAi\Gpt\ResultConverter as OpenAiResponseConverter;
use Symfony\AI\Platform\Model;
use Symfony\AI\Platform\Result\RawResultInterface;
use Symfony\AI\Platform\Result\ResultInterface;
use Symfony\AI\Platform\Result\TextResult;
use Symfony\AI\Platform\ResultConverterInterface;

/**
 * @author Marc LUCAS <marc@malucasfire.dev>
 */
final class ResultConverter implements ResultConverterInterface
{
    public function __construct(
        private readonly OpenAiResponseConverter $gptResponseConverter = new OpenAiResponseConverter(),
    ) {
    }

    public function supports(Model $model): bool
    {
        return $model instanceof Completions;
    }

    public function convert(RawResultInterface $result, array $options = []): ResultInterface
    {
        $firstChoice = $result->getData()['choices'][0] ?? null;
        if (isset($firstChoice['finish_reason']) && 'abort' === $firstChoice['finish_reason']) {
            return new TextResult($firstChoice['message']['content']);
        }

        return $this->gptResponseConverter->convert($result, $options);
    }
}
