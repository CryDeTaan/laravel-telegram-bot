<template>
    <jet-action-section>
        <template #title>
            Telegram Deployment Notifications
        </template>

        <template #description>
            Add notifications to your account using Telegram.
        </template>

        <template #content>
            <h3 class="text-lg font-medium text-gray-900" v-if="telegramNotificationsEnabled">
                You have enabled Telegram Notifications.
            </h3>

            <h3 class="text-lg font-medium text-gray-900" v-else>
                You have not enabled Telegram Notifications.
            </h3>

            <div class="mt-3 max-w-xl text-sm text-gray-600">
                <p>
                    When enabling Telegram notifications, you will be taken to the Telegram website, or application and
                    asked to start a chat with the bot to receive notifications.
                </p>
            </div>

            <div class="mt-5">
                <div v-if="! telegramNotificationsEnabled">
                    <jet-button
                        @click="enableTelegramNotifications" type="button" :class="{ 'opacity-25': enabling }"
                        :disabled="enabling"
                    >
                        Enable
                    </jet-button>
                </div>

                <div v-else>
                    <jet-danger-button
                        :class="{ 'opacity-25': disabling }"
                        :disabled="disabling"
                    >
                        Disable
                    </jet-danger-button>
                </div>
            </div>
        </template>
    </jet-action-section>
</template>

<script>
import {defineComponent} from 'vue'
import JetActionSection from '@/Jetstream/ActionSection.vue'
import JetButton from '@/Jetstream/Button.vue'
import JetDangerButton from '@/Jetstream/DangerButton.vue'

export default defineComponent({
    components: {
        JetActionSection,
        JetButton,
        JetDangerButton,
    },

    data() {
        return {
            enabling: false,
            disabling: false,

            telegramNotificationsEnabled: false,
        }
    },

    methods: {
        async enableTelegramNotifications() {
            this.enabling = true
            try {
                const response = await axios.get(route('telegram-temp-code'));
                window.open(response.data.telegramUrl, '_blank').focus();

            } catch (error) {
                // TODO: Display error to user.
                console.error(error);
            }
        },

    },

    computed: {
        //
    }
})
</script>
