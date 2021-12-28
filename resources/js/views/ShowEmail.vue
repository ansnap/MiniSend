<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">View Email</div>

                    <div class="card-body">
                        <p><b>Sender:</b> {{ email.sender }}</p>
                        <p><b>Recipient:</b> {{ email.recipient }}</p>
                        <p><b>Subject:</b> {{ email.subject }}</p>
                        <div class="my-3">
                            <b>Text content:</b><br>
                            <pre>{{ email.text }}</pre>
                        </div>
                        <div class="my-3">
                            <b>HTML content:</b><br>
                            <pre v-html="email.html"></pre>
                        </div>
                        <div class="my-3" v-if="email.attachments">
                            <b>Attachments:</b>
                            <ul>
                                <li v-for="attachment in email.attachments">
                                    <a :href="'/storage/' + attachment">{{ attachment }}</a>
                                </li>
                            </ul>
                        </div>
                        <p><b>Status:</b> {{ email.status | capitalize }}</p>
                        <p><b>Created at:</b> {{ email.created_at }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        name: "ShowEmail",
        data() {
            return {
                email: {}
            }
        },
        mounted() {
            this.loadEmail();
        },
        methods: {
            loadEmail() {
                axios.get('/api/emails/' + this.$route.params.id)
                    .then(response => {
                        this.email = response.data.data;
                    })
                    .catch(error => {
                        console.log(error);
                    });
            }
        }
    }
</script>

<style scoped>

</style>
