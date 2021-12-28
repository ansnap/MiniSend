<template>
    <div class="container">
        <form class="form-inline" @submit.prevent="search">
            <div class="form-group mr-2">
                <label for="searchBy" class="mr-2">Search by:</label>
                <select v-model="fields.searchBy" class="form-control" id="searchBy" required>
                    <option value="" disabled>Select your option</option>
                    <option value="sender">Sender</option>
                    <option value="recipient">Recipient</option>
                    <option value="subject">Subject</option>
                </select>
            </div>
            <div class="form-group mr-2">
                <input v-model="fields.search" class="form-control" placeholder="Text to search">
            </div>
            <button type="submit" class="btn btn-primary">Search</button>
        </form>

        <table class="table table-hover mt-3">
            <thead>
            <tr>
                <th scope="col">Sender</th>
                <th scope="col">Recipient</th>
                <th scope="col">Subject</th>
                <th scope="col">Status</th>
                <th scope="col">Created</th>
            </tr>
            </thead>
            <tbody>
            <tr v-for="email in emailData.data" @click="showEmail(email.id)">
                <td>{{ email.sender }}</td>
                <td>{{ email.recipient }}</td>
                <td>{{ email.subject }}</td>
                <td>{{ email.status | capitalize }}</td>
                <td>{{ email.created_at }}</td>
            </tr>
            </tbody>
        </table>

        <pagination :data="emailData" @pagination-change-page="loadEmails"></pagination>
    </div>
</template>

<script>
    export default {
        name: 'Home',
        data() {
            return {
                emailData: {},
                fields: {
                    search: '',
                    searchBy: ''
                },
                postFields: {}
            }
        },
        mounted() {
            this.loadEmails();
        },
        methods: {
            loadEmails(page = 1) {
                axios.post('/api/emails?page=' + page, this.postFields)
                    .then(response => {
                        this.emailData = response.data;
                    })
                    .catch(error => {
                        console.log(error);
                    });
            },
            showEmail(id) {
                this.$router.push('/emails/' + id);
            },
            search() {
                this.postFields = {...this.fields}; // clone the fields state to prevent a search reset when browsing pages
                this.loadEmails();
            }
        }
    }
</script>

<style scoped>
    table tbody tr {
        cursor: pointer;
    }
</style>
