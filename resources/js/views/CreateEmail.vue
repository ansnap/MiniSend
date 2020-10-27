<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Send an Email</div>

                    <div class="card-body">
                        <form @submit.prevent="submit">
                            <div class="alert alert-success" v-show="success">Email send successfully</div>

                            <div class="form-group row">
                                <label for="sender" class="col-md-4 col-form-label text-md-right">Your Email</label>

                                <div class="col-md-6">
                                    <input id="sender" type="email" class="form-control" v-model="fields.sender"
                                           required autofocus>
                                    <div class="alert alert-danger" v-if="errors && errors.sender">
                                        {{ errors.sender[0] }}
                                    </div>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="recipient" class="col-md-4 col-form-label text-md-right">To Email</label>

                                <div class="col-md-6">
                                    <input id="recipient" type="email" class="form-control" v-model="fields.recipient"
                                           required>
                                    <div class="alert alert-danger" v-if="errors && errors.recipient">
                                        {{ errors.recipient[0] }}
                                    </div>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="subject" class="col-md-4 col-form-label text-md-right">Subject</label>

                                <div class="col-md-6">
                                    <input id="subject" type="text" class="form-control" v-model="fields.subject"
                                           required>
                                    <div class="alert alert-danger" v-if="errors && errors.subject">
                                        {{ errors.subject[0] }}
                                    </div>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="text" class="col-md-4 col-form-label text-md-right">Text content</label>

                                <div class="col-md-6">
                                    <textarea id="text" rows="5" class="form-control" v-model="fields.text"
                                              required></textarea>
                                    <div class="alert alert-danger" v-if="errors && errors.text">
                                        {{ errors.text[0] }}
                                    </div>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label class="col-md-4 col-form-label text-md-right">HTML content</label>

                                <div class="col-md-6">
                                    <vue-editor v-model="fields.html"></vue-editor>
                                    <div class="alert alert-danger" v-if="errors && errors.html">
                                        {{ errors.html[0] }}
                                    </div>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="attachments"
                                       class="col-md-4 col-form-label text-md-right">Attachments</label>

                                <div class="col-md-6">
                                    <input id="attachments" type="file" ref="file" class="form-control-file" multiple>
                                    <div class="alert alert-danger" v-if="errors && errors.attachments">
                                        {{ errors.attachments[0] }}
                                    </div>
                                </div>
                            </div>

                            <div class="form-group row mb-0">
                                <div class="col-md-8 offset-md-4">
                                    <button type="submit" class="btn btn-primary">
                                        Send Email
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import {VueEditor} from "vue2-editor";

    export default {
        components: {
            VueEditor
        },
        name: "CreateEmail",
        data() {
            return {
                fields: {},
                success: false,
                errors: {}
            }
        },
        methods: {
            submit() {
                let formData = new FormData();

                for (let field in this.fields) {
                    formData.append(field, this.fields[field]);
                }

                for (let i = 0; i < this.$refs.file.files.length; i++) {
                    let file = this.$refs.file.files[i];
                    formData.append('attachments[' + i + ']', file);
                }

                axios.post('/api/emails/create', formData, {
                    headers: {
                        'Content-Type': 'multipart/form-data'
                    }
                }).then(response => {
                    this.fields = {};
                    this.$refs.file.value = '';
                    this.success = true;
                    this.errors = {};
                }).catch(error => {
                    if (error.response.status == 422) {
                        this.success = false;
                        this.errors = error.response.data.errors;
                    }
                });
            }
        }
    }
</script>

<style scoped>

</style>
