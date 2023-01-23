<script setup>
import DangerButton from '@/Components/DangerButton.vue';
import PrimaryButton from "@/Components/PrimaryButton.vue";
import { useForm } from '@inertiajs/vue3';
import { ref } from 'vue';


const processing = ref(false);

const enableTelegramNotifications = async () => {
    processing.value = true
    try {
        const response = await axios.get(route('telegram-temp-url'));
        window.open(response.data.telegramUrl, '_blank').focus();

    } catch (error) {
        // TODO: Display error to user.
        console.error(error);
    }
};

const disableTelegramNotifications = () => {
    processing.value = true

    useForm({}).delete(route('disable-telegram-notifications'), {
        preserveScroll: true,
        onSuccess: () => processing.value = false,
    });
};

</script>

<template>
    <section class="space-y-6">
        <header>
            <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">Telegram Notifications</h2>

            <p v-if="!$page.props.auth.user.telegram_chat_id" class="mt-1 text-sm text-gray-600 dark:text-gray-400">
                Add notifications to your account using Telegram. <br>
                When enabling Telegram notifications, you will be taken to the Telegram website, or application and
                asked to start a chat with the bot to receive notifications.
            </p>
            <p v-else class="mt-1 text-sm text-gray-600 dark:text-gray-400">
                Disable Telegram notifications on your account.
            </p>
        </header>
        <PrimaryButton
            v-if="!$page.props.auth.user.telegram_chat_id"
            @click="enableTelegramNotifications"
            :class="{ 'opacity-25': processing }" :disabled="processing"
        >
            Enable
        </PrimaryButton>
        <DangerButton
            v-else @click="disableTelegramNotifications"
            :class="{ 'opacity-25': processing }"
            :disabled="processing"
        >
            Disable
        </DangerButton>
    </section>
</template>
