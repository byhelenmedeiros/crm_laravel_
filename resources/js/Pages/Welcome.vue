<script setup>
import Checkbox from '@/Components/Checkbox.vue';
import GuestLayout from '@/Layouts/GuestLayout.vue';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import { Head, Link, useForm } from '@inertiajs/vue3';
import { ref } from 'vue';
import { useToast } from 'vue-toastification';

defineProps({
    podeReporSenha: {
        type: Boolean,
    },
    estado: {
        type: String,
    },
});

const formulario = useForm({
    email: '',
    senha: '',
    lembrar: false,
});

const Showpassword = ref(false);
const toast = useToast();

const submeter = () => {
    formulario.post(route('login'), {
        onFinish: () => {
            if (formulario.errors.length === 0) {
                toast.success('Login realizado com sucesso!');
            } else {
                toast.error('Erro ao realizar login, verifique os dados!');
            }
            formulario.reset('senha');
        },
    });
};
</script>

<template>
    <GuestLayout>
        <Head title="Iniciar sessão" />

        <div class="flex items-center justify-center h-72">
            <div class="bg-white flex w-full">
                <div class="w-1/2 flex items-center justify-center">
                    <img src="images/Logo-UIN-high.png" alt="Logotipo" class="w-28 h-28"> 
                </div>

                <!-- Container do Formulário -->
                <div class="w-1/2">
                    <div v-if="estado" class="mb-4 font-medium text-sm text-green-600">
                        {{ estado }}
                    </div>

                    <form @submit.prevent="submeter">
                        <div>
                            <InputLabel for="email" value="Email" />

                            <TextInput
                                id="email"
                                type="email"
                                class="mt-1 block w-full h-8 rounded-sm"
                                v-model="formulario.email"
                                required
                                autofocus
                                autocomplete="username"
                            />

                            <InputError class="mt-2" :message="formulario.errors.email" />
                        </div>

                        <div class="mt-4 relative">
                            <InputLabel for="senha" value="Senha" />

                            <!-- Campo de senha com ícone para mostrar/ocultar -->
                            <div class="relative">
                                <TextInput
                                    id="senha"
                                    :type="Showpassword ? 'text' : 'password'"
                                    class="mt-1 block w-full h-8 rounded-sm pr-10"
                                    v-model="formulario.senha"
                                    required
                                    autocomplete="current-password"
                                />
                                <button 
                                    type="button" 
                                    @click="Showpassword = !Showpassword" 
                                    class="absolute right-2 top-1/2 transform -translate-y-1/2 text-gray-500"
                                >
                                    <i :class="Showpassword ? 'fa fa-eye' : 'fa fa-eye-slash'"></i>
                                </button>
                            </div>

                            <InputError class="mt-2" :message="formulario.errors.senha" />
                        </div>

                        <div class="block mt-4">
                            <label class="flex items-center">
                                <Checkbox name="lembrar" v-model:checked="formulario.lembrar" />
                                <span class="ms-2 text-sm text-gray-600">Lembrar-me</span>
                            </label>
                        </div>

                        <div class="flex items-center justify-end mt-4">
                            <Link
                                v-if="podeReporSenha"
                                :href="route('password.request')"
                                class="underline text-sm text-gray-600 hover:text-gray-900 rounded-sm focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
                            >
                                Esqueceu-se da sua senha?
                            </Link>

                            <PrimaryButton :class="{ 'opacity-25': formulario.processing }" :disabled="formulario.processing">
                                Iniciar sessão
                            </PrimaryButton>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </GuestLayout>
</template>
