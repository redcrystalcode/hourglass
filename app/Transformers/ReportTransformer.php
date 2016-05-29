<?php
namespace Hourglass\Transformers;

use Hourglass\Models\Report;

class ReportTransformer extends Transformer
{
    public function transform(Report $report) : array
    {
        return [
            'id' => $report->id,
            'name' => $report->name,
            'type' => $report->type,
            'note' => $report->note
        ];
    }
}
