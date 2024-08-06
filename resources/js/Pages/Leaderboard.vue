<template>
    <Layout>
      <div class="container">
        <h3 class="text-primary">Leaderboard</h3><br>
        <table class="table table-bordered table-hover text-center">
          <thead>
            <tr>
              <th class="table-primary">#</th>
              <th class="table-primary">Name</th>
              <th class="table-primary">Score</th>
              <th class="table-primary">Percentage(on the time)</th>
              <th class="table-primary">Time Taken</th>
              <th class="table-primary">Total Questions</th>
            </tr>
          </thead>
          <tbody>
            <tr v-for="(entry, index) in leaderboard" :key="entry.id" >
              <td>{{ index + 1 }}</td>
              <td>{{ entry.name }}</td>
              <td>{{ entry.score }}</td>
              <td>{{ entry.percentage }}%</td>
              <td>{{ entry.time_taken}}</td>
              <td>{{ entry.total_questions }}</td>
            </tr>
          </tbody>
        </table>
      </div>
    </Layout>
  </template>

  <script setup>



  import Layout from '@/Shared/Layout.vue'

  const props = defineProps({
    leaderboard: Array,
  });




  </script>
