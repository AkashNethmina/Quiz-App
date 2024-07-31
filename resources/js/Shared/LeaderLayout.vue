<script setup>
import Header from '@/Shared/LeaderHeader.vue';

import Footer from '@/Shared/LeaderFooter.vue';
</script>
<template>
   <div class="container">
   <Header/>
   <slot/>
  <Footer/>
  </div>
</template>
