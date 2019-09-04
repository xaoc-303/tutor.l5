<template>
    <b-modal
        id="article-create-modal"
        title="Create"
        hide-footer
    >
        <form ref="form" @submit.stop.prevent="storeArticle">
            <b-form-group
                label="Title:"
                label-for="title-input"
            >
                <b-form-input
                    id="title-input"
                    v-model="title"
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
                    v-model="body"
                    required
                ></b-form-textarea>
            </b-form-group>
            <b-button
                type="submit"
                variant="primary"
                class="float-right"
            >
                Create
            </b-button>
        </form>
    </b-modal>
</template>

<script>
export default {
    data() {
        return {
            title: null,
            body: null,
        }
    },
    methods: {
        storeArticle() {
            this.$emit('storeArticle', {
                title: this.title,
                body: this.body,
            });
        }
    },
}
</script>
