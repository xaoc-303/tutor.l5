<template>
    <b-modal
        :id="idModal"
        title="Edit"
        ref="editModal"
        hide-footer
    >
        <form ref="form" @submit.stop.prevent="addArticle">
            <b-form-group
                label="Title:"
                label-for="title-input"
            >
                <b-form-input
                    id="title-input"
                    v-model="article.title"
                    required
                ></b-form-input>
            </b-form-group>
            <b-form-group
                label="Body:"
                label-for="body-input"
                invalid-feedback="Body is required"
            >
                <b-form-textarea
                    id="body-input"
                    v-model="article.body"
                    required
                ></b-form-textarea>
            </b-form-group>
            <b-button
                type="submit"
                variant="primary"
                class="float-right"
            >
                Update
            </b-button>
        </form>
    </b-modal>
</template>

<script>
export default {
    name: "EditModal",
    props: ['article', 'idModal'],
    methods: {
        addArticle() {
            this.$emit('addArticle');
            this.$refs.editModal.hide();
        }
    },
    mounted() {
        console.log('EditModal component mounted.');
    }
}
</script>
