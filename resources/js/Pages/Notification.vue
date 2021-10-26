<template>
    <app-layout title="Dashboard">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Notification
            </h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">

                    <div class="mt-5 md:mt-0 md:col-span-2">
                        <form @submit.prevent="sendNotification">
                            <div
                                class="px-4 py-5 bg-white sm:p-6 shadow sm:rounded-tl-md sm:rounded-tr-md"
                            >
                                <div class="col-span-6 sm:col-span-4">
                                    <jet-label for="notification" value="Notification" />
                                    <jet-textarea
                                        id="notification" type="text" class="mt-1 block w-full"
                                        v-model="form.notification" ref="notification"
                                    />
                                    <jet-input-error :message="form.errors.notification" class="mt-2" />
                                    <p class="mt-2 text-sm text-gray-500">Write a few sentences as a notification.</p>
                                </div>
                            </div>

                            <div
                                class="flex items-center justify-end px-4 py-3 bg-gray-50 text-right sm:px-6 shadow sm:rounded-bl-md sm:rounded-br-md"
                            >
                                <jet-button :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                                    Send
                                </jet-button>
                            </div>
                        </form>
                    </div>


                </div>
            </div>
        </div>
    </app-layout>
</template>

<script>
import {defineComponent} from 'vue'
import AppLayout from '@/Layouts/AppLayout.vue'
import JetTextarea from '@/Jetstream/Textarea.vue'
import JetInputError from '@/Jetstream/InputError.vue'
import JetLabel from '@/Jetstream/Label.vue'
import JetButton from '@/Jetstream/Button.vue'

export default defineComponent({
    components: {
        AppLayout,
        JetLabel,
        JetTextarea,
        JetInputError,
        JetButton,
    },

    data() {
        return {
            form: this.$inertia.form({
                notification: '',
            }),
        }
    },
    methods: {
        sendNotification() {
            this.form.post(route('send-notification'), {
                onSuccess: () => this.form.reset(),
            })
        },
    },
})
</script>
