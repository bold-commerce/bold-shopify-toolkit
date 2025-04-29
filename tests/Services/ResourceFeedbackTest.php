<?php

namespace BoldApps\ShopifyToolkit\Test\Services;

use BoldApps\ShopifyToolkit\Services\Client;
use BoldApps\ShopifyToolkit\Services\ResourceFeedback;
use PHPUnit\Framework\TestCase;

class ResourceFeedbackTest extends TestCase
{
    /** @var Client */
    private $clientMock;

    /** @var ResourceFeedback */
    private $resourceFeedbackService;

    protected function setUp(): void
    {
        $client = $this->createMock(Client::class);
        $client
          ->method('getApiBasePath')
          ->will($this->returnValue('admin/api/2024-01'));

        $this->clientMock = $client;
        $this->resourceFeedbackService = new ResourceFeedback($client);
    }

    public function testGetFeedbackAlert()
    {
        $expectedUrl = 'admin/api/2024-01/resource_feedback.json';
        $mockResponse = [
          "resource_feedback" => [
            [
              "messages" => [ "test message" ],
              "state" => "requires_action",
              "feedback_generated_at" => "timestamp"
            ]
          ]
        ];

        $expectedResponse = [
          "messages" => [ "test message" ],
          "state" => "requires_action",
          "feedback_generated_at" => "timestamp"
        ];

        $this->clientMock
          ->method('get')
          ->with($expectedUrl, [], [], null, false)
          ->will($this->returnValue($mockResponse));

        $this->assertEquals($expectedResponse, $this->resourceFeedbackService->getFeedbackAlert());
    }

    public function testSendFeedbackAlert()
    {
        $expectedUrl = 'admin/api/2024-01/resource_feedback.json';
        $mockResponse = [
          "resource_feedback" => [
              "messages" => [ "test message" ],
              "state" => "requires_action",
              "feedback_generated_at" => "timestamp"
            ]
        ];

        $messageBody = [
          "resource_feedback" => [
            "messages" => [ "test message" ],
            "state" => "requires_action",
            "feedback_generated_at" => "timestamp"
          ],
        ];

        $testMessage = "test message";
        $testTimestamp = "timestamp";

        $expectedResponse = [
          "messages" => [ $testMessage ],
          "state" => "requires_action",
          "feedback_generated_at" => $testTimestamp,
        ];

        $this->clientMock
          ->method('post')
          ->with($expectedUrl, [], $messageBody)
          ->will($this->returnValue($mockResponse));

        $this->assertEquals($expectedResponse, $this->resourceFeedbackService->sendFeedbackAlert($testMessage, $testTimestamp));
    }

    public function testClearFeedbackAlert()
    {
        $expectedUrl = 'admin/api/2024-01/resource_feedback.json';
        $mockResponse = [
          "resource_feedback" => [
              "messages" => [ ],
              "state" => "success",
              "feedback_generated_at" => "timestamp"
            ]
        ];

        $messageBody = [
          "resource_feedback" => [
            "state" => "success",
            "feedback_generated_at" => "timestamp"
          ],
        ];

        $testTimestamp = "timestamp";

        $expectedResponse = [
          "messages" => [ ],
          "state" => "success",
          "feedback_generated_at" => $testTimestamp,
        ];

        $this->clientMock
          ->method('post')
          ->with($expectedUrl, [], $messageBody)
          ->will($this->returnValue($mockResponse));

        $this->assertEquals($expectedResponse, $this->resourceFeedbackService->clearFeedbackAlert($testTimestamp));
    }
}
