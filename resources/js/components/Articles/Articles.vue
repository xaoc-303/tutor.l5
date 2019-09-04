<template>
    <div>
        <Pagination
            :current-page.sync="currentPage"
            :per-page="perPage"
            :total-items="totalItems"
            @update:currentPage="fetchArticles"
        ></Pagination>

        <b-button class="mb-2" @click="createArticle" variant="success">Create Article</b-button>

        <div v-for="article in articles">
            <Article :article="article"
                     @showArticle="showArticle"
                     @editArticle="editArticle"
                     @deleteArticle="deleteArticle"
            ></Article>
        </div>

        <ShowModal :article="article"></ShowModal>
        <CreateModal @storeArticle="storeArticle"></CreateModal>
        <EditModal :article="article" @updateArticle="updateArticle"></EditModal>
    </div>
</template>

<script>
import ShowModal from "./ShowModal";
import Pagination from "./Pagination";
import CreateModal from "./CreateModal";
import EditModal from "./EditModal";
import Article from "./Article";

export default {
    components: {
        Article,
        CreateModal,
        EditModal,
        Pagination,
        ShowModal,
    },
    data() {
        return {
            currentPage: 1,
            perPage: 3,
            totalItems: 0,
            articles: [],
            article: {},
            edit: false,
        }
    },

    created() {
        this.fetchArticles(this.currentPage);
    },

    methods: {
        fetchArticles(page) {
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
        createArticle() {
            this.$bvModal.show('article-create-modal');
        },
        storeArticle({ title, body }) {
            return axios
                .post(`api/articles`, {
                    title: title,
                    body: body,
                })
                .then(({ article }) => {
                    this.fetchArticles();
                    this.showSuccessToast(`Article ${this.article.id}  Created`);
                    this.$bvModal.hide('article-create-modal');
                })
                .catch(err => console.error(err));
        },
        showArticle(article) {
            this.article = article;
            this.$bvModal.show('article-show-modal');
        },
        editArticle(article) {
            this.article = article;
            this.$bvModal.show('article-edit-modal');
        },
        updateArticle({ title, body }) {
            return axios
                .put(`api/articles/${this.article.id}`, {
                    title: title,
                    body: body,
                })
                .then(({ article }) => {
                    this.fetchArticles();
                    this.showSuccessToast(`Article ${this.article.id}  Updated`);
                    this.$bvModal.hide('article-edit-modal');
                })
                .catch(err => console.error(err));
        },
        deleteArticle(article) {
            return axios
                .delete(`api/articles/${article.id}`)
                .then(({ article }) => {
                    this.fetchArticles(this.currentPage);
                    this.showSuccessToast(`Article ${article.id} Removed`);
                })
                .catch(err => console.error(err));
        },
        showSuccessToast(title) {
            this.$bvToast.toast(title, {
                toaster: "b-toaster-bottom-right",
                autoHideDelay: 3000,
                variant: "success",
                title: 'Success',
            });
        }
    },
    mounted() {
        console.log('Articles component mounted.');
    }
}
</script>
