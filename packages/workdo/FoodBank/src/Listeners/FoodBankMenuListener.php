<?php

namespace Workdo\FoodBank\Listeners;

use App\Events\CompanyMenuEvent;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Str;

class FoodBankMenuListener
{
    public function handle(CompanyMenuEvent $event): void
    {
        $menu = $event->menu;
        $menu->add([
            'category' => 'Charity',
            'title' => __('Food Bank'),
            'icon' => 'ti ti-plant',
            'name' => 'foodbank',
            'parent' => null,
            'order' => 500,
            'ignore_if' => [],
            'depend_on' => [],
            'route' => '',
            'module' => 'FoodBank',
            'permission' => 'foodbank donor manage'
        ]);
        $links = [
            ['title' => __('Dashboard'), 'route' => 'foodbank.dashboard', 'permission' => 'foodbank donor manage'],
            ['title' => __('Requests'), 'route' => 'foodbank.requests.index', 'permission' => 'foodbank request manage'],
            ['title' => __('Donors'), 'route' => 'foodbank.donors.index', 'permission' => 'foodbank donor manage'],
            ['title' => __('Inventory'), 'route' => 'foodbank.inventory.index', 'permission' => 'foodbank inventory manage'],
            ['title' => __('Distributions'), 'route' => 'foodbank.distributions.index', 'permission' => 'foodbank distribution manage'],
            ['title' => __('Reports'), 'route' => 'foodbank.reports', 'permission' => 'foodbank reports view'],
        ];

        foreach ($links as $order => $link) {
            if (! Route::has($link['route'])) {
                // skip links whose routes aren't registered yet
                continue;
            }

            $menu->add([
                'category' => 'Charity',
                'title' => $link['title'],
                'icon' => '',
                'name' => 'foodbank-' . Str::slug($link['title']),
                'parent' => 'foodbank',
                'order' => $order + 1,
                'ignore_if' => [],
                'depend_on' => [],
                'route' => $link['route'],
                'module' => 'FoodBank',
                'permission' => $link['permission']
            ]);
        }
    }
}
