<script setup>
import Header from '@/Shared/Header.vue';

import Footer from '@/Shared/Footer.vue';
</script>
<template>
   <div class="container">
   <Header/>
   <slot/>
  <Footer/>
  </div>
</template>
