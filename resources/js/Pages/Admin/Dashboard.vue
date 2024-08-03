<template>
    <div class="container mx-auto mt-8">
      <h1 class="text-3xl font-bold">Admin Dashboard</h1>
      <p class="mt-4">Welcome, {{ user.name }}!</p>
      <button @click="logout" class="px-4 py-2 mt-4 font-bold text-white bg-red-500 rounded-lg hover:bg-red-700">
        Logout
      </button>
    </div>
  </template>

  <script>
  import { ref } from 'vue';
  import { usePage, Inertia } from '@inertiajs/vue3';

  export default {
    setup() {
      const { props } = usePage();
      const user = ref(props.user);

      const logout = () => {
        Inertia.post(route('admin.logout'));
      };

      return { user, logout };
    },
  };
  </script>
