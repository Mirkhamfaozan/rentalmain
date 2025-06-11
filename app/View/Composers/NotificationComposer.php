<?php

namespace App\View\Composers;

use App\Services\NotificationService;
use Illuminate\View\View;
use Illuminate\Support\Facades\Auth;

class NotificationComposer
{
    protected $notificationService;

    public function __construct(NotificationService $notificationService)
    {
        $this->notificationService = $notificationService;
    }

    /**
     * Bind data to the view.
     */
    public function compose(View $view)
    {
        $unreadCount = 0;

        if (Auth::check()) {
            $unreadCount = $this->notificationService->getUnreadCount();
        }

        $view->with('notificationCount', $unreadCount);
    }
}

// App\Providers\AppServiceProvider.php - Tambahkan ini ke method boot()
/*
use App\View\Composers\NotificationComposer;
use Illuminate\Support\Facades\View;

public function boot
