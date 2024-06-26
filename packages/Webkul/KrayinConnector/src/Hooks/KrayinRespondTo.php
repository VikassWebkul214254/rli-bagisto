<?php

namespace Webkul\KrayinConnector\Hooks;

use Illuminate\Http\Request;
use Spatie\WebhookClient\WebhookConfig;
use Spatie\WebhookClient\WebhookResponse\RespondsToWebhook;
use Symfony\Component\HttpFoundation\Response;

class KrayinRespondTo implements RespondsToWebhook
{
    /**
     * Set your custom response.
     */
    public function respondToValidWebhook(Request $request, WebhookConfig $config): Response
    {
        return response()->json([
            'status'   => true,
            'retry'    => false,
            'message'  => 'Request processed successfully!',
        ]);
    }
}
