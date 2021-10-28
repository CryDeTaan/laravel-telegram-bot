<p align="center">
<a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" height="100"></a>
<a href="https://laravel.com" target="_blank"><img src="https://telegram.org/img/t_logo.svg?1" height="100"></a>
</p>

## About

This project is a simple example of introducing a Telegram Bot into a Laravel app which can be used to send notifications to users or admins of a site.

I made use of several packages to aid in bootstrapping this as quickly as possible. The idea was to understand how to introduce said bot and not spend a lot of time developing an application...

There are two parts to this setup, 
1. Setting up the Laravel application
2. Setting up and configuring the Telegram bot.

### Getting started with Laravel

```bash
# Clone the repo
git clone https://github.com/CryDeTaan/laravel-telegram-bot.git
cd laravel-telegram-bot

# Install Laravel and Packages
composer install

# Install Frontend assets
npm install && npm run dev

# Copy .env and generate application key
cp .env.example .env
php artisan key:generate

# Configure .env with your editor, specifically update the DB section
pstorm . # I am using PHPStorm and this will open the current directory in PHPStorm. 

# Run migrations
php artisan migrate

# Serve the app and open, I am using valet
valet link && valet open
```

At this point an application will be up and running and can be accessed using a browser where users can register and login as well.

<p align="center">
<img src="https://user-images.githubusercontent.com/11268952/139319188-1b08aeed-e6ce-4c8a-9e51-389b661a5cbc.png" alt="Welcome Page">
</p>

### Setting up the Telegram bot
This section has a bit more detail, it is after all about Telegram bots.

When it comes to Telegram bots, it all starts with the BotFather.
Find it in the search and start a new chat with him.

<p align="center">
<img src="https://user-images.githubusercontent.com/11268952/139133875-e5023c53-0b63-408c-988e-c420f965cd12.png" alt="Bot Father">
</p>

I think the team at Telegram made it fairly easy to use, and for the most part self-explanatory.
I mean, we know what we are here for, so let's create a new bot using `/newbot`. 
Start the conversation to create a bot, it's like having a conversation.

<p align="center">
<img src="https://user-images.githubusercontent.com/11268952/139132403-137ba1e2-212c-4621-9b56-7ae091da2612.png" alt="Bot Father Chat">
</p>

Once the BotFather congratulates you, you will find two pieces of information that you need to capture in the .env file. 
1. The URL, you can copy it from the message from the GodFather and update the `TELEGRAM_BOT_URL` in this case it is https://t.me/laravel_telegram_test_bot.
2. Update the `TELEGRAM_BOT_TOKEN` with the API Token, in this case `2017805637:AAFAB6wvnYC5aGzm07_hqUIVokMy82Z6WpA`

The values in the `.env` should now look something like this:
```text
TELEGRAM_BOT_URL=https://t.me/laravel_telegram_test_bot
TELEGRAM_BOT_TOKEN=2017805637:AAFAB6wvnYC5aGzm07_hqUIVokMy82Z6WpA
```

Now, the following is probably going to cause some confusion, and more so in a development environment.
But it is required so that Telegram can reach the application to send a message to a webhook. 
As I mentioned, I am using Laravel Valet which makes it easy to make an application accessible 
from the internet while in a development setting, i.e. behind some sort of NAT etc.
Laravel Valet is using [ngrok](https://ngrok.com/) under the hood. So if you are not using Valet
to serve the application, and you do not currently have a way to expose the application in a 
development setting to the internet, I suggest looking at ngrok.

Anyway, we need to expose the application to the internet in order to configure the bot to make use
of the application's Telegram webhook.

The Telegram Bot's Webhook URL can be set using the `telegram:configure-webhook` artisan command.

<p align="center">
<img src="https://user-images.githubusercontent.com/11268952/139318751-7fd7794d-21ca-4f90-a02e-78e955c983f2.png" alt="Artisan command">
</p>

Now we can create a new user and enable their Telegram notifications. After creating a user and logging in,
navigate to the profile section, find the drop-down to the top right of the page. There you'll find an 
option to enable Telegram notifications.

<p align="center">
<img src="https://user-images.githubusercontent.com/11268952/139319869-3d81ba5b-1ae5-493b-80ce-3f14ce7ea308.png" alt="Enable Telegram Notifications">
</p>

When clicking on the enable button, a new tab will open prompting you to Open Telegram.

<p align="center">
<img src="https://user-images.githubusercontent.com/11268952/139320242-8fcf5fec-5320-45a4-b97d-36fc2c83e1ed.png" alt="Open Telegram prompt">
</p>

Once the Open Telegram option has been selected, Telegram will open and there you can start the bot by clicking on the 
Start button. 

<p align="center">
<img src="https://user-images.githubusercontent.com/11268952/139134827-9a716911-4526-4387-a320-ae3ead4c0253.png" alt="Start Bot chat">
</p>

Head back to the web app and select the Notification tab. Entering a message here and clicking send will
deliver the message to Telegram in the chat with your bot.     

<p align="center">
<img src="https://user-images.githubusercontent.com/11268952/139320868-32f766a0-0f70-4dba-81ae-d83559e07c20.png" alt="Send test notification">
</p>

<p align="center">
<img src="https://user-images.githubusercontent.com/11268952/139135140-1dea65ff-e865-439e-b0d6-98aed4d2dacb.png" alt="Receive notification in Telegram">
</p>

That's pretty mush it, later...
