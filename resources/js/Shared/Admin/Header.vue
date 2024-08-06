<script setup>
import { Link, usePage } from "@inertiajs/vue3";
import { computed } from "vue";
const page = usePage();
const appName = computed(() => page.props.appName);
</script>
<template>
    <header
        class="d-flex flex-wrap justify-content-center py-3 mb-4 border-bottom"
    >
        <a
            href="/admin/dashboard"
            class="d-flex align-items-center mb-3 mb-md-0 me-md-auto link-body-emphasis text-decoration-none"
        >
            <svg class="bi me-2" width="40" height="32">
                <use xlink:href="#bootstrap" />
            </svg>

            <span class="fs-3">Dashboard</span>
        </a>

        <div class="col-md-3 mb-2 mb-md-0">
            <Link href="/" class="d-inline-flex link-body-emphasis">
                <span class="fs-4">{{ appName }}</span>
            </Link>
        </div>

        <ul class="nav nav-pills">
            <li class="nav-item">
                <Link
                    href="/admin/dashboard"
                    :class="{
                        'nav-link active': $page.url === '/admin/dashboard',
                        'nav-link': $page.url != '/admin/dashboard',
                    }"
                    aria-current="page"
                    >Home</Link
                >
            </li>
            <li class="nav-item">
                <Link
                    href="/admin/questions"
                    :class="{
                        'nav-link active': $page.url === '/admin/questions',
                        'nav-link': $page.url != '/admin/questions',
                    }"
                    >Questions</Link
                >
            </li>

            <Link href="/admin/logout">
                <button type="button" class="btn btn-outline-success main-succ">
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
                    </svg></button
            ></Link>
        </ul>
    </header>

    <br /><br />
</template>
<style scoped>
.main-succ {
    margin-left: 20px;
}
</style>
