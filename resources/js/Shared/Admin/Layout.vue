<script setup>
import Header from '@/Shared/Admin/Header.vue';

import Footer from '@/Shared/Admin/Footer.vue';
</script>
<template>
   <div class="container">

    <Header/>
   <slot/>
  <Footer/>

  </div>
</template>
