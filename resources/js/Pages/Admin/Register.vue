<template>
    <div class="flex items-center justify-center min-h-screen bg-gray-100">
      <div class="w-full max-w-md p-8 space-y-4 bg-white shadow-lg rounded-lg">
        <h1 class="text-2xl font-bold text-center">Admin Register</h1>
        <form @submit.prevent="submit">
          <div class="mb-4">
            <input
              v-model="form.name"
              type="text"
              placeholder="Name"
              class="w-full px-4 py-2 border rounded-lg"
            />
          </div>
          <div class="mb-4">
            <input
              v-model="form.email"
              type="email"
              placeholder="Email"
              class="w-full px-4 py-2 border rounded-lg"
            />
          </div>
          <div class="mb-4">
            <input
              v-model="form.password"
              type="password"
              placeholder="Password"
              class="w-full px-4 py-2 border rounded-lg"
            />
          </div>
          <div class="flex items-center justify-between">
            <button type="submit" class="px-4 py-2 font-bold text-white bg-green-500 rounded-lg hover:bg-green-700">
              Register
            </button>
          </div>
        </form>
        <div v-if="errors" class="mt-4 text-sm text-red-500">
          <ul>
            <li v-for="(error, key) in errors" :key="key">{{ error }}</li>
          </ul>
        </div>
      </div>
    </div>
  </template>

  <script>
  import { useForm } from '@inertiajs/vue3';

  export default {
    setup() {
      const form = useForm({
        name: '',
        email: '',
        password: '',
      });

      const submit = () => {
        form.post(route('admin.register')); // Assuming there's a registration route
      };

      return { form, submit };
    },
  };
  </script>
