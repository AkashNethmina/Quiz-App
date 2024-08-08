<template>
    <Layout>
        <main class="container">
            <div class="bg-body-tertiary p-5 rounded">
                <h1>Hi, Admin</h1>
                <p class="lead">
                    <b>Welcome to the admin dashboard of Quiz App</b>
                </p>

                <Link href="/admin/logout">
                    <button type="button" class="btn btn-success main-succ">
                        Logout
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
                    </button>
                </Link>
            </div>
        </main>

        <br />
        <div class="container">
            <h3 class="text-primary">Score Table</h3>
            <br />
            <DataTable
                :columns="columns"
                :data="leaderboard"
                class="table table-hover table-striped table-bordered text-center"
                width="100%"
            >
                <thead>
                    <tr>
                        <th class="text-center">#</th>
                        <th class="text-center">Name</th>
                        <th class="text-center">Score</th>
                        <th class="text-center">Percentage</th>
                        <th class="text-center">Time Taken</th>
                        <th class="text-center">Total Questions</th>
                    </tr>
                </thead>
                <tfoot>
                    <tr>
                        <th class="text-center">#</th>
                        <th class="text-center">Name</th>
                        <th class="text-center">Score</th>
                        <th class="text-center">Percentage</th>
                        <th class="text-center">Time Taken</th>
                        <th class="text-center">Total Questions</th>
                    </tr>
                </tfoot>
            </DataTable>
        </div>
    </Layout>
</template>

<script setup>
import Layout from "@/Shared/Admin/Layout.vue";
import { Link } from "@inertiajs/vue3";
const props = defineProps({
    leaderboard: Array,
});

import DataTable from "datatables.net-vue3";
import DataTablesCore from "datatables.net-bs5";

DataTable.use(DataTablesCore);

const columns = [
    { data: "id", title: "#", className: "text-center" },
    { data: "name", title: "Name", className: "text-center" },
    { data: "score", title: "Score", className: "text-center" },
    {
        data: "percentage",
        title: "Percentage",
        className: "text-center",
    },
    { data: "time_taken", title: "Time Taken", className: "text-center" },
    {
        data: "total_questions",
        title: "Total Questions",
        className: "text-center",
    },
];
</script>
<style>
@import "bootstrap";
@import "datatables.net-bs5";

.table td,
.table th {
    text-align: center;
}
.table-bordered th,
.table-bordered td {
    border: 1px solid #dee2e6; /* Customize the border color */
}

.table-hover tbody tr:hover {
    background-color: #f8f9fa; /* Customize the hover background color */
}
</style>
