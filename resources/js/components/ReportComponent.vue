<template>
    <div>
        <v-container fluid>
            <v-row justify="center" align="center">
                <v-col class="text-center">
                    <v-data-table :loading=loading loading-text="Loading... Please wait" :headers="headers" :items="reports" class="elevation-1">
                        <template v-slot:top>
                            <v-toolbar flat color="white">
                                <v-toolbar-title class="title">Reports</v-toolbar-title>
                            </v-toolbar>
                        </template>
                    </v-data-table>
                </v-col>
            </v-row>
        </v-container>
    </div>
</template>

<script>
export default {
    data() {
        return {
            dialog: false, loading: false,
            editedIndex: -1,
            defaultItem: { code: '', name: '', description: '',},
            editedItem: { code: '', name: '', description: '',},
            headers: [
                {text: 'ID', value: 'id',},
                {text: 'Username', value: 'username',},
                {text: 'Barangay', value: 'barangay'},
                {text: 'Date and Time', value: 'date_time'},
            ],
            reports: [],
        }
    },
    mounted() {
        this.retrieveReportList()
    },
    
    methods: {
        retrieveReportList() {
            axios.get('/api/reports/')
            .then( response => {
                this.reports = response.data.reports
            })
            .catch( error => {
                alert(error)
            })
        },
    },
}
</script>