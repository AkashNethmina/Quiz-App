<template>
    <Layout>
        <main class="container">
            <div class="bg-body-tertiary p-5 rounded">
                <h1>Hi, Admin</h1>
                <p class="lead">
                    <b>Welcome to the admin dashboard of Quiz App</b>
                </p>
                <a
                    class="btn btn-lg btn-success"
                    href="../components/navbar/"
                    role="button"
                    >Logout

                    <svg
                        xmlns="http://www.w3.org/2000/svg"
                        width="16"
                        height="16"
                        fill="currentColor"
                        class="bi bi-box-arrow-left"
                        viewBox="0 0 16 16"
                    >
                        <path
                            fill-rule="evenodd"
                            d="M6 12.5a.5.5 0 0 0 .5.5h8a.5.5 0 0 0 .5-.5v-9a.5.5 0 0 0-.5-.5h-8a.5.5 0 0 0-.5.5v2a.5.5 0 0 1-1 0v-2A1.5 1.5 0 0 1 6.5 2h8A1.5 1.5 0 0 1 16 3.5v9a1.5 1.5 0 0 1-1.5 1.5h-8A1.5 1.5 0 0 1 5 12.5v-2a.5.5 0 0 1 1 0z"
                        />
                        <path
                            fill-rule="evenodd"
                            d="M.146 8.354a.5.5 0 0 1 0-.708l3-3a.5.5 0 1 1 .708.708L1.707 7.5H10.5a.5.5 0 0 1 0 1H1.707l2.147 2.146a.5.5 0 0 1-.708.708z"
                        />
                    </svg>
                </a>
            </div>
        </main>

        <br />
        <div class="container">
            <h3 class="text-primary">Score Table</h3>
            <br />
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
                    <tr v-for="(entry, index) in leaderboard" :key="entry.id">
                        <td>{{ index + 1 }}</td>
                        <td>{{ entry.name }}</td>
                        <td>{{ entry.score }}</td>
                        <td>{{ entry.percentage }}%</td>
                        <td>{{ entry.time_taken }}</td>
                        <td>{{ entry.total_questions }}</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </Layout>
</template>

<script setup>
import Layout from "@/Shared/Admin/Layout.vue";

const props = defineProps({
    leaderboard: Array,
});
</script>
