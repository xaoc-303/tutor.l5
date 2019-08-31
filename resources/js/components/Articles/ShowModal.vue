<template>
    <div>
        <b-modal :id="idModal" :title="article.title" ok-only>
            <p>{{ article.body }}</p>
        </b-modal>
    </div>
</template>

<script>
export default {
    name: "ShowModal",
    props: ['article', 'idModal'],
    mounted() {
        console.log('ShowModal component mounted.');
    }
}
</script>
