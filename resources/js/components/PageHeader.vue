<template>
    <div class="d-flex flex-column flex-md-row align-items-center p-3 px-md-4 mb-3 bg-white border-bottom shadow-sm">
        <h5 class="my-0 mr-md-auto font-weight-normal">MiniSend</h5>
        <nav class="my-2 my-md-0 mr-md-3">
            <router-link to="/" class="p-2 text-dark">Home</router-link>
        </nav>
        <router-link to="/emails/create" class="btn btn-outline-primary">Send Email</router-link>
    </div>
</template>

<script>
    export default {
        name: "PageHeader"
    }
</script>

<style scoped>

</style>
