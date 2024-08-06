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
              :class="{ 'is-invalid': form.errors.email }"
              placeholder="Email"
              required
            />
            <div v-if="form.errors.email" class="invalid-feedback">
              {{ form.errors.email }}
            </div>
          </div>
          <div class="mb-3">
            <label for="password" class="form-label">Password</label>
            <input
              v-model="form.password"
              id="password"
              type="password"
              class="form-control"
              :class="{ 'is-invalid': form.errors.password }"
              placeholder="Password"
              required
            />
            <div v-if="form.errors.password" class="invalid-feedback">
              {{ form.errors.password }}
            </div>
          </div>
          <div class="form-group row-3">
            <button
              type="submit"
              class="btn btn-primary"
              :disabled="form.processing"
            >
              <span
                v-if="form.processing"
                class="spinner-border spinner-border-sm"
                role="status"
                aria-hidden="true"
              ></span>
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
  import { useForm } from "@inertiajs/vue3";
  import { ref } from "vue";
  // Import the route function from Ziggy
  import { ZiggyVue } from "ziggy-js";

  // Form setup with default values
  const form = useForm({
    email: "",
    password: "",
  });

  // Error messages
  const errors = ref({
    login: "",
  });

  // Submit function to handle form submission
  const submit = () => {
    console.log("Submitting form with:", form);

    form.post(route("admin.authenticate"), {
      onSuccess: () => {
        console.log("Login successful");
        // Handle successful login
        router.visit("/admin/dashboard"); // Redirecting to a dashboard or admin area
      },
      onError: (error) => {
        console.error("Form errors:", error);
        // Handle form submission errors
        errors.value.login = "Login failed. Please check your credentials.";
      },
    });
  };
  </script>

  <style scoped>
  /* Highlight the input fields with errors */
  .is-invalid {
    border-color: #e3342f;
    background-color: #fddede;
  }
  </style>
