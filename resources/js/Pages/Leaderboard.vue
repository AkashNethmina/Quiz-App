<script setup>
import DataTable from "datatables.net-vue3";
import DataTablesCore from "datatables.net-bs5";
import Layout from "@/Shared/Layout.vue";
DataTable.use(DataTablesCore);

const props = defineProps({
    leaderboard: Array,
});
const columns = [
    { data: "id", title: "#", className: "text-center" },
    { data: "name", title: "Name", className: "text-center" },
    { data: "score", title: "Score", className: "text-center" },
    {
        data: "percentage",
        title: "Percentage ",
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

<template>
    <Layout>
        <div class="container">
            <h2 class="text-primary main-l">Leaderboard</h2>
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

<style>
@import "bootstrap";
@import "datatables.net-bs5";
.main-l {
    margin-bottom: 50px;
}

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
