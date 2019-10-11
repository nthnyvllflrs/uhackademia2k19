<template>
    <div>
        <v-container fluid>
            <v-row justify="center" align="center">
                <v-col class="text-center">
                    <v-data-table :loading=loading loading-text="Loading... Please wait" :headers="headers" :items="barangays" class="elevation-1">
                        <template v-slot:top>
                            <v-toolbar flat color="white">
                                <v-toolbar-title class="title">Barangays</v-toolbar-title>
                                <div class="flex-grow-1"></div>
                                <v-dialog v-model="dialog" max-width="500px">
                                    <template v-slot:activator="{ on }">
                                        <v-btn small color="success" v-on="on">
                                            <v-icon small left>fa-plus</v-icon> Add Barangay
                                        </v-btn>
                                    </template>

                                    <v-card>
                                        <v-overlay :value="loading">
                                            <v-progress-circular :size="100" :width="5" color="light-green accent-4" indeterminate></v-progress-circular>
                                        </v-overlay>
                                        <v-card-title>
                                            <span class="headline">{{ formTitle }}</span>
                                        </v-card-title>

                                        <v-card-text>
                                            <v-container>
                                                <v-row>
                                                    <v-col cols="12"><v-text-field v-model="editedBarangay.username" label="Username"></v-text-field></v-col>
                                                    <v-col cols="12"><v-text-field v-model="editedBarangay.name" label="Name"></v-text-field></v-col>
                                                </v-row>
                                            </v-container>
                                        </v-card-text>

                                        <v-card-actions>
                                            <div class="flex-grow-1"></div>
                                            <v-btn color="error" @click="cancel">Cancel</v-btn>
                                            <v-btn color="success" @click="saveBarangay">Save</v-btn>
                                        </v-card-actions>
                                    </v-card>
                                </v-dialog>
                            </v-toolbar>
                        </template>
                        <template v-slot:item.action="{ item }">
                            <v-icon small class="mr-2" @click="editBarangay(item)">fa-edit</v-icon>
                            <v-icon small @click="deleteBarangay(item)">fa-trash-alt</v-icon>
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
            defaultBarangay: { username: null, password: "123456789", name: null},
            editedBarangay: { username: null, password: "123456789", name: null},
            headers: [
                {text: 'ID', value: 'id',},
                {text: 'Username', value: 'username',},
                {text: 'Name', value: 'name'},
                {text: 'Actions', value: 'action', sortable: false },
            ],
            barangays: [],
        }
    },
    mounted() {
        this.retrieveItemList()
    },
    
    computed: {
        formTitle () {
            return this.editedIndex === -1 ? 'New Barangay' : 'Edit Barangay'
        },
    },
    watch: {
        dialog (val) {
            val || this.cancel()
        },
    },
    
    methods: {
        retrieveItemList() {
            this.loading = true
            axios.get('api/barangays')
            .then( response => {
                this.barangays = response.data.barangays
            })
            .catch( error => { alert(error)})
            .finally( x => { this.loading = false})
        },
        editBarangay(item) {
            this.editedIndex = this.barangays.indexOf(item)
            this.editedBarangay = Object.assign({}, item)
            this.dialog = true
        },
        deleteBarangay(item) {
            var itemDeletion = confirm('Are you sure you want to delete this item?')
            if(itemDeletion == true) {
                axios.delete('api/barangays/' + item.id)
                .then( response => { 
                    const index = this.barangays.indexOf(item)
                    this.barangays.splice(index, 1)
                })
                .catch( error => { alert(error)})
            }
        },
        cancel() {
            this.dialog = false
            setTimeout(() => {
                this.editedBarangay = Object.assign({}, this.defaultBarangay)
                this.editedIndex = -1
            }, 500)
        },
        saveBarangay() {
            this.loading = true
            if (this.editedIndex > -1) {
                // Update item
                axios.put('api/barangays/' + this.editedBarangay.id, { 
                    username: this.editedBarangay.username, password: this.editedBarangay.password, password_confirmation: this.editedBarangay.password, role: 'Barangay', name: this.editedBarangay.name,
                })
                .then( response => { 
                    Object.assign(this.barangays[this.editedIndex], this.editedBarangay)
                    this.cancel()
                })
                .catch( error => { alert(error)})
                .finally( x => { this.loading = false})
            } else {
                // Create new item
                axios.post('api/barangays', { 
                    username: this.editedBarangay.username, password: this.editedBarangay.password, password_confirmation: this.editedBarangay.password, role: 'Barangay', name: this.editedBarangay.name,
                })
                .then( response => { 
                    this.editedBarangay.id = response.data.barangay.id
                    this.barangays.push(this.editedBarangay)
                    this.cancel()
                })
                .catch( error => { alert(error)})
                .finally( x => { this.loading = false})
            }
        }
    },
}
</script>