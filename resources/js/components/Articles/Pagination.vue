<template>
    <nav aria-label="Page navigation example">
        <ul class="pagination">
            <li :class="{ disabled: isPrevBtnDisabled }" class="page-item">
                <a class="page-link" href="#" @click="prevPage">Previous</a>
            </li>
            <li class="page-item disabled">
                <a class="page-link text-dark" href="#">
                    Page {{ currentPage }} of {{ totalPages }}
                </a>
            </li>
            <li :class="{ disabled: isNextBtnDisabled }" class="page-item">
                <a class="page-link" href="#" @click="nextPage">Next</a>
            </li>
        </ul>
    </nav>
</template>

<script>
    export default {
        name: "Pagination",
        props: {
            currentPage: {
                type: Number,
                required: true,
            },
            perPage: {
                type: Number,
                required: true,
            },
            totalItems: {
                type: Number,
                required: true,
            },
        },
        methods: {
            changePage(newPage) {
                this.$emit('update:currentPage', newPage);
            },
            prevPage() {
                this.changePage(this.currentPage - 1);
            },
            nextPage() {
                this.changePage(this.currentPage + 1);
            },
        },
        mounted() {
            console.log('Pagination component mounted.');
        },
        computed: {
            isPrevBtnDisabled() {
                return this.currentPage === 1;
            },
            isNextBtnDisabled() {
                return this.currentPage === this.totalPages;
            },
            totalPages() {
                return Math.ceil(this.totalItems / this.perPage);
            }
        }
    }
</script>
