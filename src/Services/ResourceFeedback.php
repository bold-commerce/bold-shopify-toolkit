<?php

namespace BoldApps\ShopifyToolkit\Services;

use BoldApps\ShopifyToolkit\Enums\ResourceFeedbackCreateStatus;

class ResourceFeedback extends Base
{
    public function getFeedbackAlert()
    {
        $raw = $this->client->get("{$this->getApiBasePath()}/resource_feedback.json");

        // A given shop will always have 1 or 0 resource_feedback entries
        $feedback = null;
        if (isset($raw['resource_feedback']) && isset($raw['resource_feedback'][0])) {
            $feedback = $raw['resource_feedback'][0];
        }

        return $feedback;
    }

    public function sendFeedbackAlert(string $message, ?string $timestamp = null)
    {
        $alert = [
          'resource_feedback' => [
            'state' => ResourceFeedbackCreateStatus::STATE_REQUIRES_ACTION,
            'messages' => [$message],
            'feedback_generated_at' => $timestamp ?? date('c'),
          ],
        ];
        $raw = $this->client->post("{$this->getApiBasePath()}/resource_feedback.json", [], $alert);

        return $raw['resource_feedback'];
    }

    public function clearFeedbackAlert(?string $timestamp = null)
    {
        $alert = [
          'resource_feedback' => [
            'state' => ResourceFeedbackCreateStatus::STATE_CLEAR,
            'feedback_generated_at' => $timestamp ?? date('c'),
          ],
        ];
        $raw = $this->client->post("{$this->getApiBasePath()}/resource_feedback.json", [], $alert);

        return $raw['resource_feedback'];
    }
}
