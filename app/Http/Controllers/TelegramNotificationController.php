<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Str;

class TelegramNotificationController extends Controller
{
    /**
     * Create a unique code for the user to activate Telegram notifications.
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function create(Request $request)
    {
        $telegramBotUrl = config('app.telegram_bot_url');

        $userTempCode = Str::random(35);;
        Cache::store('telegram')
            ->put($userTempCode, auth()->id(), $seconds = 120);

        // Telegram URL:
        // https://t.me/ExampleComBot?start=vCH1vGWJxfSeofSAs0K5PA
        $telegramUrl = $telegramBotUrl . '?start=' . $userTempCode;

        return response()->json([
            'telegramUrl' => $telegramUrl,
        ]);

    }
}
