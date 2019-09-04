<template>
    <div>
        <Pagination
            :current-page.sync="currentPage"
            :per-page="perPage"
            :total-items="totalItems"
            @update:currentPage="fetchArticles"
        ></Pagination>

        <div v-for="article in articles">
            <Article :article="article" @currentArticle="currentArticle" @editArticle="editArticle"></Article>
        </div>

        <ShowModal :id-modal="'article-show-modal'" :article="article"></ShowModal>
        <EditModal :id-modal="'article-edit-modal'" :article="article" @addArticle="addArticle"></EditModal>
    </div>
</template>

<script>
import ShowModal from "./ShowModal";
import Pagination from "./Pagination";
import EditModal from "./EditModal";
import Article from "./Article";

export default {
    name: "Articles",
    components: {
        Article,
        EditModal,
        Pagination,
        ShowModal
    },

    data() {
        return {
            currentPage: 1,
            perPage: 3,
            totalItems: 0,
            articles: [],
            article: {
                id: '',
                title: '',
                body: ''
            },
            article_id: '',
            edit: false
        }
    },

    created() {
        console.log(this.$options.name + ' created');
        this.fetchArticles(this.currentPage);
    },

    methods: {
        fetchArticles(page) {
            console.log(this.$options.name + ' fetchArticles');
            return axios
                .get('/api/articles/', {
                    params: {
                        page: page,
                        per_page: this.perPage,
                    },
                })
                .then(({ data }) => {
                    this.articles = data.data;
                    this.perPage = data.meta.per_page;
                    this.totalItems = data.meta.total;
                })
                .catch(err => console.error(err));
        },
        addArticle() {
            console.log(this.$options.name + ' addArticle');
            if (this.edit === false) {
                console.log(this.$options.name + ' addArticle add');
                // Add
                fetch('api/article', {
                    method: 'post',
                    body: JSON.stringify(this.article),
                    headers: {
                        'content-type': 'application/json'
                    }
                })
                    .then(res => res.json())
                    .then(data => {
                        this.article.title = '';
                        this.article.body = '';
                        console.log('Article Added');
                        this.$bvToast.toast(`Article Added`, {
                            toaster: "b-toaster-bottom-right",
                            autoHideDelay: 3000,
                            variant: "success",
                            title: 'Success'
                        });
                        this.fetchArticles();
                    })
                    .catch(err => console.log(err));
            } else {
                console.log(this.$options.name + ' addArticle update');
                // Update
                fetch('api/article', {
                    method: 'put',
                    body: JSON.stringify(this.article),
                    headers: {
                        'content-type': 'application/json'
                    }
                })
                    .then(res => res.json())
                    .then(data => {
                        this.article.title = '';
                        this.article.body = '';
                        console.log('Article Updated');
                        this.$bvToast.toast(`Article Updated`, {
                            toaster: "b-toaster-bottom-right",
                            autoHideDelay: 3000,
                            variant: "success",
                            title: 'Success'
                        });
                        this.fetchArticles();
                    })
                    .catch(err => console.log(err));
            }
        },
        currentArticle(article) {
            console.log(this.$options.name + ' currentArticle');
            this.article.article_id = article.id;
            this.article.title = article.title;
            this.article.body = article.body;
        },
        editArticle(article) {
            console.log(this.$options.name + ' editArticle');
            this.currentArticle(article);
            this.edit = true;
        }
    },
    mounted() {
        console.log('Articles component mounted.');
    }
}
</script>
