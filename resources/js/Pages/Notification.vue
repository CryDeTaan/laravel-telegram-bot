<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import {Head} from '@inertiajs/vue3';
import InputLabel from "@/Components/InputLabel.vue";
import TextAreaInput from "@/Components/TextAreaInput.vue";
import InputError from "@/Components/InputError.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import {useForm} from '@inertiajs/vue3'

const form = useForm({
    notification: '',
})

const sendNotification = () => {
    form.post(route('send-notification'), {
        onSuccess: () => form.reset(),
    })
}
</script>

<template>
    <Head title="Notification"/>

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">Notification</h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900 dark:text-gray-100">
                        <form @submit.prevent="sendNotification">
                            <input-label for="notification" value="Message"/>
                            <text-area-input id="notification" type="text" class="mt-1 block w-full"
                                       v-model="form.notification" ref="notification"/>
                            <input-error :message="form.errors.notification" class="mt-2"/>
                            <p class="mt-2 text-sm">Write a few sentences as a notification.</p>

                            <div class="flex mt-2 items-center justify-end px-4 py-3 gap-4">
                                <PrimaryButton :disabled="form.processing">Send</PrimaryButton>

                                <Transition enter-from-class="opacity-0" leave-to-class="opacity-0" class="transition ease-in-out">
                                    <p v-if="form.recentlySuccessful" class="text-sm text-gray-600 dark:text-gray-400">Sent.</p>
                                </Transition>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

    </AuthenticatedLayout>
</template>
