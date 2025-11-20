<script setup lang="ts">
import InputError from '@/components/InputError.vue';
import { Button } from '@/components/ui/button';
import { Card, CardContent } from '@/components/ui/card';
import { Field, FieldDescription, FieldGroup, FieldLabel } from '@/components/ui/field';
import { Input } from '@/components/ui/input';
import { Spinner } from '@/components/ui/spinner';
import AuthBase from '@/layouts/AuthLayout.vue';
import { cn } from '@/lib/utils';
import { store } from '@/routes/login';
import { Form, Head } from '@inertiajs/vue3';
import { Eye, EyeClosed } from 'lucide-vue-next';
import { HTMLAttributes, ref } from 'vue';

const props = defineProps<{
    status?: string;
    canResetPassword: boolean;
    canRegister: boolean;
    class?: HTMLAttributes["class"]
}>()

const showPassword = ref(false)

const togglePasswordVisibility = () => {
  showPassword.value = !showPassword.value
}
</script>

<template>
    <AuthBase title="Log in to your account" description="Enter your email and password below to log in">
        <Head title="Log in" />
        <div v-if="status" class="mb-4 text-center text-sm font-medium text-green-600">
            {{ status }}
        </div>
        <div :class="cn('flex flex-col gap-6', props.class)">
            <Card class="overflow-hidden p-0">
                <CardContent class="grid p-0 md:grid-cols-2">
                    <Form v-bind="store.form()" :reset-on-success="['password']" v-slot="{ errors, processing }" class="p-6 md:p-8">
                        <FieldGroup>
                            <div class="flex flex-col items-center gap-2 text-center">
                                <h1 class="text-2xl font-bold">
                                    Welcome back
                                </h1>
                                <p class="text-muted-foreground text-balance">
                                    Login to your account
                                </p>
                            </div>
                            <Field>
                                <FieldLabel for="email">
                                    Email
                                </FieldLabel>
                                <Input id="email" type="email" name="email" required autofocus :tabindex="1" autocomplete="email" placeholder="email@example.com" />
                                <InputError :message="errors.email" />
                            </Field>
                            <Field>
                                <FieldLabel for="password">
                                    Password
                                </FieldLabel>
                                <div class="relative">
                                    <Input id="password" :type="showPassword ? 'text' : 'password'" name="password" required :tabindex="2" autocomplete="current-password" placeholder="Password" />
                                    <span @click="togglePasswordVisibility" class="absolute z-30 text-gray-400 hover:text-gray-500 -translate-y-1/2 cursor-pointer right-4 top-1/2">
                                        <Eye v-if="!showPassword" class="size-5" />
                                        <EyeClosed v-else class="size-5" />
                                    </span>
                                </div>
                                <InputError :message="errors.password" />
                            </Field>
                            <Field>
                                <Button type="submit" class="mt-3 w-full cursor-pointer" :tabindex="3" :disabled="processing" data-test="login-button">
                                    <Spinner v-if="processing" />
                                    Log in
                                </Button>
                            </Field>
                            <FieldDescription class="text-center">
                                Don't have an account?
                                <a href="#">
                                    Sign up
                                </a>
                            </FieldDescription>
                        </FieldGroup>
                    </Form>
                    <div class="bg-muted relative hidden md:block">
                        <img src="/images/pexels-whynugrohou-3097112.jpg" alt="Image" class="absolute inset-0 h-full w-full object-cover dark:brightness-[0.2] dark:grayscale">
                    </div>
                </CardContent>
            </Card>
            <FieldDescription class="px-6 text-center">
                By clicking continue, you agree to our <a href="#">Terms of Service</a> and <a href="#">Privacy Policy</a>.
            </FieldDescription>
        </div>
    </AuthBase>
</template>
