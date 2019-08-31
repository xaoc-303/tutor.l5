<template>
    <div>
        <b-navbar toggleable="sm" type="dark" variant="info" class="mb-2">
            <b-navbar-brand href="#">{{ title }}</b-navbar-brand>
        </b-navbar>
    </div>
</template>

<script>
    export default {
        name: "Navbar",
        props: ['title'],
        mounted() {
            console.log('Navbar component mounted.');
        }
    }
</script>
