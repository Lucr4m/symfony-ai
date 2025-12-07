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

use Symfony\AI\Platform\Capability;
use Symfony\AI\Platform\ModelCatalog\AbstractModelCatalog;

/**
 * @author Marc LUCAS <marc@malucasfire.dev>
 */
final class ModelCatalog extends AbstractModelCatalog
{
    /**
     * @param array<string, array{class: class-string, capabilities: list<string>}> $additionalModels
     */
    public function __construct(array $additionalModels = [])
    {
        $defaultModels = [
            // Embedding models
            'all-MiniLM-L6-v2' => [
                'class' => Embeddings::class,
                'capabilities' => [Capability::INPUT_TEXT, Capability::INPUT_MULTIPLE],
            ],
        ];

        $this->models = array_merge($defaultModels, $additionalModels);
    }
}
