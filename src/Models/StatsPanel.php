<?php

namespace Softworx\RocXolid\CMS\Models;

use Softworx\RocXolid\CMS\Models\AbstractPageElement;
use Softworx\RocXolid\Commerce\Models\Order;

class StatsPanel extends AbstractPageElement
{
    protected $table = 'cms_page_element_stats_panel';

    protected $fillable = [
        'web_id',
        'percent_count',
        'percent_line_1',
        'percent_line_2',
        'counter_line_1',
        'counter_line_2',
        'years_count',
        'years_line_1',
        'years_line_2',
    ];

    public function getOrdersCount()
    {
        return Order::count();
    }
}