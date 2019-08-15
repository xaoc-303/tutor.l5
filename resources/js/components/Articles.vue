<template>
<div class="container">
    <div>
        <h2>Articles</h2>
        <nav aria-label="Page navigation example">
            <ul class="pagination">
                <li v-bind:class="[{disabled: !pagination.prev_page_url}]" class="page-item"><a class="page-link" href="#" @click="fetchArticles(pagination.prev_page_url)">Previous</a></li>
                <li class="page-item disabled"><a class="page-link text-dark" href="#">Page {{ pagination.current_page }} of {{ pagination.last_page }}</a></li>
                <li v-bind:class="[{disabled: !pagination.next_page_url}]" class="page-item"><a class="page-link" href="#" @click="fetchArticles(pagination.next_page_url)">Next</a></li>
            </ul>
        </nav>

        <div class="card card-body shadow p-3 mb-5 bg-white rounded" v-for="article in articles" v-bind:key="article.id">
            <div class="d-flex bd-highlight">
                <div class="flex-grow-1 bd-highlight">
                    <h3>{{ article.title }}</h3>
                </div>
                <div class="bd-highlight">
                    <button type="button" @click="deleteArticle(article.id)" class="close float-right" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            </div>
            <p>{{ article.body }}</p>
        </div>
    </div>
</div>
</template>

<script>
export default {
    data() {
        return {
            articles: [],
            article: {
                id: '',
                title: '',
                body: ''
            },
            article_id: '',
            pagination: {},
            edit: false
        }
    },

    created() {
        this.fetchArticles();
    },

    methods: {
        fetchArticles(page_url) {
            let vm = this;
            page_url = page_url || '/api/articles'
            fetch(page_url)
                .then(res => res.json())
                .then(res => {
                    this.articles = res.data;
                    vm.makePagination(res.meta, res.links);
                })
                .catch(err => console.log(err));
        },
        makePagination(meta, links) {
            let pagination = {
                current_page: meta.current_page,
                last_page: meta.last_page,
                next_page_url: links.next,
                prev_page_url: links.prev
            }

            this.pagination = pagination;
        },
        deleteArticle(id) {
            if (confirm('Are You Sure?')) {
                fetch(`api/article/${id}`, {
                    method: 'delete'
                })
                .then(res => res.json())
                .then(data => {
                    alert('Article Removed');
                    this.fetchArticles();
                })
                .catch(err => console.log(err));
            }
        }
    }
}
</script>
