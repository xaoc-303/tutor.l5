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
                <div class="bd-highlight mr-2">
                    <button type="button" class="close float-right" aria-label="Close" data-toggle="modal" :data-target="'#articleShowModal'+article.id">
                        <span aria-hidden="true">&telrec;</span>
                    </button>
                </div>
                <div class="bd-highlight mr-2">
                    <button type="button" @click.prevent="editArticle(article)" class="close float-right" aria-label="Close" data-toggle="modal" data-target="#articleEditModal">
                        <span aria-hidden="true">&mldr;</span>
                    </button>
                </div>
                <div class="bd-highlight">
                    <button type="button" @click="deleteArticle(article.id)" class="close float-right" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            </div>
            <p>{{ article.body }}</p>
            <article-show-modal :article="article"></article-show-modal>
        </div>

        <div class="modal fade" id="articleEditModal" tabindex="-1" role="dialog" aria-labelledby="articleEditModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="articleEditModalLabel">Edit</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form @submit.prevent="addArticle">
                            <div class="form-group">
                                <label for="recipient-name" class="col-form-label">Title:</label>
                                <input type="text" class="form-control" id="recipient-name" v-model="article.title">
                            </div>
                            <div class="form-group">
                                <label for="message-text" class="col-form-label">Body:</label>
                                <textarea class="form-control" id="message-text" v-model="article.body"></textarea>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                <button type="submit" class="btn btn-primary">Send message</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
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
        },
        addArticle() {
            if (this.edit === false) {
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
                        alert('Article Added');
                        this.fetchArticles();
                    })
                    .catch(err => console.log(err));
            } else {
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
                        alert('Article Updated');
                        this.fetchArticles();
                    })
                    .catch(err => console.log(err));
            }
        },
        editArticle(article) {
            this.edit = true;
            this.article.id = article.id;
            this.article.article_id = article.id;
            this.article.title = article.title;
            this.article.body = article.body;
        }
    }
}
</script>
