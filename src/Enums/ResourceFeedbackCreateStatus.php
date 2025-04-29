<?php

namespace BoldApps\ShopifyToolkit\Enums;

class ResourceFeedbackCreateStatus
{
    public const STATE_REQUIRES_ACTION = 'requires_action';
    public const STATE_CLEAR = 'success';

    /**
     * Returns all possible values of the ResourceFeedbackCreateStatus enum.
     *
     * @return string[]
     */
    public static function getValues(): array
    {
        return [
            self::STATE_REQUIRES_ACTION,
            self::STATE_CLEAR,
        ];
    }
}
