<template>
    <div class="container">
        <Navbar v-bind:title="'Articles'"></Navbar>
        <Articles></Articles>
    </div>
</template>

<script>
    import Navbar from './Navbar';
    import Articles from './Articles/Articles';
    export default {
        name: "App",
        components: {
            Navbar,
            Articles
        },
        mounted() {
            console.log('App component mounted.');
        }
    }
</script>

<style scoped>

</style>
