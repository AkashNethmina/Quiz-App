<script setup>
import {Link} from '@inertiajs/vue3'
</script>

<template>




  <footer class="d-flex flex-wrap justify-content-between align-items-center py-3 my-4 border-top">
    <p class="col-md-4 mb-0 text-body-secondary">© 2024 Quiz App. All rights reserved.</p>

    <a href="/" class="col-md-4 d-flex align-items-center justify-content-center mb-3 mb-md-0 me-md-auto link-body-emphasis text-decoration-none">
        <span class="fs-4"></span>
    </a>

    <ul class="nav col-md-4 justify-content-end">
        <li class="nav-item"><Link href="/" class="nav-link px-2 text-body-secondary">Home</Link></li>
      <li class="nav-item"><Link href="/questions" class="nav-link px-2 text-body-secondary">Questions</Link></li>
    </ul>
  </footer>
</template>
