<template>
    <div>
        <PageHeader/>
        <router-view/>
    </div>
</template>

<script>
    import PageHeader from "../js/components/PageHeader";

    export default {
        components: {PageHeader}
    }
</script>
