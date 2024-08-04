<template>
    <div class="d-flex justify-content-center align-items-center min-vh-100 bg-light">
      <div class="card w-90 w-md-50 p-4 shadow">
        <h1 class="card-title text-center mb-4">Admin Login</h1>
        <form @submit.prevent="submit">
          <div class="mb-3">
            <label for="email" class="form-label">Email</label>
            <input
              v-model="form.email"
              id="email"
              type="email"
              class="form-control"
              placeholder="Email"
            />
          </div>
          <div class="mb-3">
            <label for="password" class="form-label">Password</label>
            <input
              v-model="form.password"
              id="password"
              type="password"
              class="form-control"
              placeholder="Password"
            />
          </div>
          <div class="d-flex justify-content-between">
            <button  type="submit" class="btn btn-primary">
              Login
            </button>
          </div>
        </form>
        <div v-if="errors.login" class="mt-3 text-danger">
          {{ errors.login }}
        </div>
      </div>
    </div>
  </template>

  <script setup>
  import { useForm } from '@inertiajs/vue3';
  import { router } from '@inertiajs/vue3';
  import { ref, computed, onMounted, watch } from 'vue';


  const form = useForm({
    email: '',
    password: '',
  });

  const errors = ref({
    login: ''
  });

  const submit = () => {
    console.log('Submitting form with:', form.data()); // Debugging line
    form.post(route('admin.authenticate'), {
      onSuccess: () => {
        console.log('Login successful');
      },
      onError: (error) => {
        console.error('Form errors:', error);
        errors.value.login = 'Login failed. Please check your credentials.';
      },
    });
  };
  </script>
