<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

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

        // TODO: Update to random code, and store in Cache for
        //  callback from Telegram
        $userTempCode = '123';

        // Telegram URL:
        // https://t.me/ExampleComBot?start=vCH1vGWJxfSeofSAs0K5PA
        $telegramUrl = $telegramBotUrl . '?start=' . $userTempCode;

        return response()->json([
            'telegramUrl' => $telegramUrl,
        ]);

    }
}
