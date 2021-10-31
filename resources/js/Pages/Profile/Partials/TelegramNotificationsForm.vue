<template>
    <jet-action-section>
        <template #title>
            Telegram Notifications
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

            <div class="flex items-center mt-5">
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
                        @click="disableTelegramNotifications"
                        :class="{ 'opacity-25': disabling }"
                        :disabled="disabling"
                    >
                        Disable
                    </jet-danger-button>
                </div>
                <jet-action-message :on="disabling" class="ml-3">
                    Done.
                </jet-action-message>
            </div>
        </template>
    </jet-action-section>
</template>

<script>
import {defineComponent} from 'vue'
import JetActionSection from '@/Jetstream/ActionSection.vue'
import JetButton from '@/Jetstream/Button.vue'
import JetDangerButton from '@/Jetstream/DangerButton.vue'
import JetActionMessage from '@/Jetstream/ActionMessage.vue'

export default defineComponent({
    components: {
        JetActionSection,
        JetButton,
        JetDangerButton,
        JetActionMessage,
    },

    props: ['telegramNotificationsEnabled'],

    data() {
        return {
            enabling: false,
            disabling: false,
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

        disableTelegramNotifications() {
            this.$inertia.delete(
                route('disable-telegram-notifications'),
                {
                    preserveScroll: true,
                    onSuccess: page => {
                        this.disabling = true
                        setTimeout(() => { this.disabling = false; }, 2000);
                    },
                }
            )
        },

    },

    computed: {
        //
    }
})
</script>
