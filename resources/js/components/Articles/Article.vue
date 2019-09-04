<template>
    <div>
        <b-card class="shadow mb-5">
            <b-card-title class="clearfix">
                <h3 class="float-left">{{ article.title }}</h3>
                <button type="button"
                        @click="deleteArticle(article)"
                        class="close float-right mr-2"
                        aria-label="Close"
                >
                    <span aria-hidden="true">&times;</span>
                </button>
                <button type="button"
                        @click.prevent="editArticle(article)"
                        class="close float-right mr-2"
                >
                    <span aria-hidden="true">&mldr;</span>
                </button>
                <button type="button"
                        @click.prevent="showArticle(article)"
                        class="close float-right mr-2"
                >
                    <span aria-hidden="true">&telrec;</span>
                </button>
            </b-card-title>
            <b-card-text>{{ article.body }}</b-card-text>
        </b-card>
    </div>
</template>

<script>
export default {
    name: "Article",
    props: {
        article: {
            type: Object,
            required: true,
        },
    },
    methods: {
        showArticle(article) {
            console.log(this.$options.name + ' showArticle');
            this.$emit('showArticle', article);
        },
        editArticle(article) {
            console.log(this.$options.name + ' editArticle');
            this.$emit('editArticle', article);
        },
        deleteArticle(article) {
            if (confirm('Are You Sure?')) {
                this.$emit('deleteArticle', article);
            }
        }
    },
    mounted() {
        console.log('Article component mounted.');
    }
}
</script>
