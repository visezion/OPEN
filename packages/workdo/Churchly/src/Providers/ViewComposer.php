<?php

namespace Workdo\Churchly\Providers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\ServiceProvider;

class ViewComposer extends ServiceProvider
{
    /**
     * Boot method to register view composers.
     */
    public function boot()
    {
        // Inject Churchly member panels into customer and vendor views if Churchly is active
        view()->composer(['account::customer.show', 'account::vendor.show'], function ($view) {
            if (Auth::check()) {
                try {
                    $ids = request()->segment(2);
                    if (!empty($ids)) {
                        try {
                            $id = \Illuminate\Support\Facades\Crypt::decrypt($ids);
                            $customer = \Workdo\Account\Entities\Customer::where('user_id', $id)
                                ->where('created_by', creatorId())
                                ->where('workspace', getActiveWorkSpace())
                                ->first();
                            $vendor = \Workdo\Account\Entities\Vender::where('user_id', $id)
                                ->where('created_by', creatorId())
                                ->where('workspace', getActiveWorkSpace())
                                ->first();

                            if (module_is_active('Churchly')) {
                                $view->getFactory()->startPush('customer_church_tab', view('churchly::setting.sidebar'));
                                $view->getFactory()->startPush('customer_church_div', view('churchly::setting.nav_content_div', compact('customer')));

                                $view->getFactory()->startPush('vendor_church_tab', view('churchly::vendor.sidebar'));
                                $view->getFactory()->startPush('vendor_church_div', view('churchly::vendor.nav_content_div', compact('vendor')));
                            }
                        } catch (\Throwable $th) {
                            // Silent fail for view stability
                        }
                    }
                } catch (\Throwable $th) {
                    // Silent fail for view stability
                }
            }
        });

        // Inject Churchly account type selector in invoice-related views if Churchly is active
        view()->composer(['invoice.create', 'invoice.edit', 'invoice.index', 'invoice.grid'], function ($view) {
            if (Auth::check() && module_is_active('Churchly')) {
                $type = request()->query('type');
                $projectsid = request()->query('project_id');
                $view->getFactory()->startPush('account_type', view('churchly::invoice.account_type', compact('type', 'projectsid')));
            }
        });
    }

    public function register()
    {
        //
    }

    /**
     * Services provided by this provider.
     */
    public function provides()
    {
        return [];
    }
}
