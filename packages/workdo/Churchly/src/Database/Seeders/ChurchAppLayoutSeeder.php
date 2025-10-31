<?php

namespace Workdo\Churchly\Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\WorkSpace;
use Workdo\Churchly\Entities\{ChurchAppLayout, ChurchAppWidget};

class ChurchAppLayoutSeeder extends Seeder
{
    public function run(): void
    {
        $workspaces = WorkSpace::where('status','active')->get();

        foreach ($workspaces as $ws) {
            $layout = ChurchAppLayout::firstOrCreate(
                ['workspace_id' => $ws->id, 'screen_key' => 'home'],
                ['title' => 'Home', 'is_active' => true, 'meta' => [ 'version' => 1 ]]
            );

            if (!$layout->widgets()->exists()) {
                $widgets = [
                    ['type' => 'banner_carousel', 'title' => 'Featured', 'settings' => ['height'=>200], 'sort_order' => 1],
                    ['type' => 'quick_links', 'title' => 'Quick Links', 'settings' => ['columns'=>4], 'sort_order' => 2],
                    ['type' => 'latest_sermons', 'title' => 'Latest Sermons', 'settings' => ['limit'=>10], 'sort_order' => 3],
                    ['type' => 'upcoming_events', 'title' => 'Upcoming Events', 'settings' => ['limit'=>6], 'sort_order' => 4],
                ];
                foreach ($widgets as $w) {
                    ChurchAppWidget::create(array_merge($w, [
                        'layout_id' => $layout->id,
                        'active' => true,
                    ]));
                }
            }
        }
    }
}