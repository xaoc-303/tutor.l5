<template>
    <b-modal id="article-show-modal" :title="article.title" ok-only>
        <p>{{ article.body }}</p>
    </b-modal>
</template>

<script>
export default {
    props: {
        article: Object,
    },
    mounted() {
        console.log('ShowModal component mounted.');
    }
}
</script>
