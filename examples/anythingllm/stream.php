<?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

use Symfony\AI\Agent\Agent;
use Symfony\AI\Platform\Bridge\AnythingLLM\Completions;
use Symfony\AI\Platform\Bridge\AnythingLLM\ModelCatalog;
use Symfony\AI\Platform\Bridge\AnythingLLM\PlatformFactory;
use Symfony\AI\Platform\Bridge\AnythingLLM\TokenOutputProcessor;
use Symfony\AI\Platform\Capability;
use Symfony\AI\Platform\Message\Message;
use Symfony\AI\Platform\Message\MessageBag;

require_once dirname(__DIR__) . '/bootstrap.php';

/**
 * @see https://www.anythingllm.com/docs/api-reference
 * Create a workspace in AnythingLLM called "Demo Workspace" with the Chat mode activated.
 */
const ANYTHINGLLM_WORKSPACE_NAME = 'demo-workspace';

/*
 * As AnythingLLM can handle multiple models, we need to define a ModelCatalog manually.
 */
$modelCatalog = new ModelCatalog([
    ANYTHINGLLM_WORKSPACE_NAME => [
        'class' => Completions::class,
        'capabilities' => [Capability::INPUT_TEXT, Capability::OUTPUT_TEXT],
    ],
]);

$platform = PlatformFactory::create(
    env('ANYTHINGLLM_API_KEY'),
    'http://127.0.0.1:3001',
    http_client(),
    $modelCatalog
);

$agent = new Agent($platform, ANYTHINGLLM_WORKSPACE_NAME, outputProcessors: [new TokenOutputProcessor()]);
$messages = new MessageBag(
    Message::forSystem('You are a Symfony expert and you write detailed explanations.'),
    Message::ofUser('Why do you love Symfony?'),
);
$result = $agent->call($messages, [
    'stream' => true,
]);

print_stream($result);
