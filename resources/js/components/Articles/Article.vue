<template>
    <div>
        <b-card class="shadow mb-5">
            <b-card-title class="clearfix">
                <h3 class="float-left">{{ article.title }}</h3>
                <button type="button" @click="deleteArticle(article.id)" class="close float-right mr-2" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <button type="button" @click.prevent="editArticle(article)" class="close float-right mr-2" aria-label="Close" v-b-modal="'article-edit-modal'">
                    <span aria-hidden="true">&mldr;</span>
                </button>
                <button type="button" @click.prevent="currentArticle(article)" class="close float-right mr-2" aria-label="Close" v-b-modal="'article-show-modal'">
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
    props: ['article'],
    methods: {
        currentArticle(article) {
            console.log(this.$options.name + ' currentArticle');
            this.$emit('currentArticle', article);
        },
        editArticle(article) {
            console.log(this.$options.name + ' editArticle');
            this.$emit('editArticle', article);
        },
        deleteArticle(id) {
            if (confirm('Are You Sure?'+id)) {
                fetch(`api/article/${id}`, {
                    method: 'delete'
                })
                    .then(res => res.json())
                    .then(data => {
                        console.log('Article Removed');
                        this.$bvToast.toast(`Article Removed`, {
                            toaster: "b-toaster-bottom-right",
                            autoHideDelay: 3000,
                            variant: "success",
                            title: 'Success'
                        });
                        this.$parent.fetchArticles();
                    })
                    .catch(err => console.log(err));
            }
        }
    },
    mounted() {
        console.log('Article component mounted.');
    }
}
</script>
