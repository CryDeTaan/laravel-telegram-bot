<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Console\ConfirmableTrait;
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
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $webhookSecret =  Str::random(45);

        // Set or replace the Webhook Secret in the environment file, so it is
        // automatically setup for this developer. This Webhook Secret is
        // generated using random string and is set in the environment file.
        if (! $this->setWebhookSecretInEnvironmentFile($webhookSecret)) {
            return;
        }

        $this->laravel['config']['services.telegram-bot-api.webhook'] = $webhookSecret;

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
}
