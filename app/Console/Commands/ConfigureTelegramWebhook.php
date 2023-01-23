<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Console\ConfirmableTrait;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;

class ConfigureTelegramWebhook extends Command
{
    Use ConfirmableTrait;
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'telegram:configure-webhook';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Configures the Telegram Webhook.';

    /**
     * Execute the console command.
     * Automatically set or update the Telegram Bot's Webhook URL.
     *
     * @return int
     */
    public function handle()
    {
        $webhookSecret =  Str::random(45);

        if (! $this->setWebhookSecretInEnvironmentFile($webhookSecret)) {
            $this->error('And Error occurred');
            return;
        }
        $this->laravel['config']['services.telegram-bot-api.webhook'] = $webhookSecret;

        $webhookUrl = $this->makeWebhookUrl();

        // Configure the Telegram Bot with the Webhook
        $this->configureTelegramBotWith($webhookUrl);

        return Command::SUCCESS;
    }

    /**
     * Set the Webhook Secret in the environment file.
     *
     * @param $webhookSecret
     * @return bool
     */
    protected function setWebhookSecretInEnvironmentFile($webhookSecret)
    {
        $currentKey = $this->laravel['config']['services.telegram-bot-api.webhook'];

        if (strlen($currentKey) !== 0 && (! $this->confirmToProceed())) {
            return false;
        }

        $this->writeNewEnvironmentFileWith($webhookSecret);

        return true;
    }

    /**
     * Write a new environment file with the given Webhook Secret.
     *
     * @param string $webhookSecret
     * @return void
     */
    protected function writeNewEnvironmentFileWith($webhookSecret)
    {
        file_put_contents($this->laravel->environmentFilePath(), preg_replace(
            $this->secretReplacementPattern(),
            'TELEGRAM_BOT_WEBHOOK='.$webhookSecret,
            file_get_contents($this->laravel->environmentFilePath())
        ));
    }

    /**
     * Get a regex pattern that will match env TELEGRAM_BOT_WEBHOOK with any random key.
     *
     * @return string
     */
    protected function secretReplacementPattern()
    {
        $escaped = preg_quote('='.$this->laravel['config']['services.telegram-bot-api.webhook'], '/');

        return "/^TELEGRAM_BOT_WEBHOOK{$escaped}/m";
    }

    /**
     * Prepare the Webhook URL which will be used to configure the Telegram bot.
     *
     * @return string
     */
    protected function makeWebhookUrl()
    {
        $app_url = config('app.url');

        $this->comment('Your current app base url is: ' . $app_url);
        if (!$this->confirm("Do you want to use this url for your Telegram Bot webhook?", true)) {
            $app_url = $this->ask('Please provide the base URL to use instead:');
        }

        return $app_url . '/telegram/webhook/' . config('services.telegram-bot-api.webhook');

    }

    /**
     * Configure the Telegram bot with the provided Webhook URL.
     *
     * @return void
     */
    protected function configureTelegramBotWith(string $webhookUrl)
    {
        $telegramBaseApiUrl = 'https://api.telegram.org/bot';
        $telegramApiToken = config('services.telegram-bot-api.token');
        $allowedUpdates = '["message"]';

        $response = Http::post($telegramBaseApiUrl . $telegramApiToken . '/setWebhook', [
            'url' => $webhookUrl,
            'allowed_updates' => $allowedUpdates,
        ]);
        if ($response->failed()) {
            $this->error($response->json()['description']);
            return;
        }

        $response = Http::get($telegramBaseApiUrl . $telegramApiToken . '/getWebhookInfo');
        if ($response->failed()) {
            $this->error($response->json()['description']);
            return;
        }
        $this->info("The Telegram Bot Webhook was create successfully:\n" . $response->json()['result']['url']);
    }
}
