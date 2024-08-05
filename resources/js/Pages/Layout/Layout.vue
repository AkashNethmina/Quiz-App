<script setup>
import Header from '@/Layout/Header.vue';

import Footer from '@/Layout/Footer.vue';
</script>
<template>
   <div class="container">

    <Header/>
   <slot/>
  <Footer/>

  </div>
</template>
