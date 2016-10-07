<?php
namespace Hourglass\Transformers;

use Hourglass\Models\RoundingRule;

/**
 * Class RoundingRuleTransformer
 *
 * @package Hourglass\Transformers
 */
class RoundingRuleTransformer extends Transformer
{
    /**
     * @param \Hourglass\Models\RoundingRule $rule
     *
     * @return array
     */
    public function transform(RoundingRule $rule) : array
    {
        return [
            'id' => $rule->id,
            'start' => $rule->start,
            'end' => $rule->end,
            'criteria' => [
                'time' => $rule->criteria['time'],
            ],
            'resolution' => $rule->resolution,
        ];
    }
}
