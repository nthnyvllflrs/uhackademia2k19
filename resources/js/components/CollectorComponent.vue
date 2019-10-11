<template>
    <div>
        <v-container fluid>
            <v-row justify="center" align="center">
                <v-col class="text-center">
                    <v-data-table :loading=loading loading-text="Loading... Please wait" :headers="headers" :items="collectors" class="elevation-1">
                        <template v-slot:top>
                            <v-toolbar flat color="white">
                                <v-toolbar-title class="title">Collectors</v-toolbar-title>
                                <div class="flex-grow-1"></div>
                                <v-dialog v-model="dialog" max-width="500px">
                                    <template v-slot:activator="{ on }">
                                        <v-btn small color="success" v-on="on">
                                            <v-icon small left>fa-plus</v-icon> Add Collector
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
                                                    <v-col cols="6"><v-text-field v-model="editedCollector.username" label="Username"></v-text-field></v-col>
                                                    <v-col cols="6"><v-text-field v-model="editedCollector.name" label="Name"></v-text-field></v-col>
                                                    <v-col cols="6"><v-text-field v-model="editedCollector.license_number" label="License Number"></v-text-field></v-col>
                                                    <v-col cols="6"><v-text-field v-model="editedCollector.plate_number" label="Plate Number"></v-text-field></v-col>
                                                    <v-col cols="12"><v-text-field v-model="editedCollector.address" label="Address"></v-text-field></v-col>
                                                    <v-col cols="6"><v-text-field v-model="editedCollector.latitude" label="Latitude"></v-text-field></v-col>
                                                    <v-col cols="6"><v-text-field v-model="editedCollector.longitude" label="Longitude"></v-text-field></v-col>
                                                </v-row>
                                            </v-container>
                                        </v-card-text>

                                        <v-card-actions>
                                            <div class="flex-grow-1"></div>
                                            <v-btn color="error" @click="cancel">Cancel</v-btn>
                                            <v-btn color="success" @click="saveCollector">Save</v-btn>
                                        </v-card-actions>
                                    </v-card>
                                </v-dialog>
                            </v-toolbar>
                        </template>
                        <template v-slot:item.action="{ item }">
                            <v-icon small class="mr-2" @click="editCollector(item)">fa-edit</v-icon>
                            <v-icon small @click="deleteCollector(item)">fa-trash-alt</v-icon>
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
            defaultCollector: { username: null, password: "123456789", name: null, licensed_number: null, plate_number: null, address: null, latitude: null, longitude: null,},
            editedCollector: { username: null, password: "123456789", name: null, licensed_number: null, plate_number: null, address: null, latitude: null, longitude: null,},
            headers: [
                {text: 'ID', value: 'id',},
                {text: 'Username', value: 'username',},
                {text: 'Name', value: 'name'},
                {text: 'License Number', value: 'license_number'},
                {text: 'Plate Number', value: 'plate_number'},
                {text: 'Actions', value: 'action', sortable: false },
            ],
            collectors: [],
        }
    },
    mounted() {
        this.retrieveCollectorList()
    },
    
    computed: {
        formTitle () {
            return this.editedIndex === -1 ? 'New Collector' : 'Edit Collector'
        },
    },
    watch: {
        dialog (val) {
            val || this.cancel()
        },
    },
    
    methods: {
        retrieveCollectorList() {
            this.loading = true
            axios.get('api/collectors')
            .then( response => {
                this.collectors = response.data.collectors
            })
            .catch( error => { alert(error)})
            .finally( x => { this.loading = false})
        },
        editCollector(item) {
            axios.get('api/collectors/' + item.id)
            .then( response => {
                this.editedIndex = this.collectors.indexOf(item)
                this.editedCollector = Object.assign({}, item)
                this.editedCollector.address = response.data.collector.address
                this.editedCollector.latitude = response.data.collector.latitude
                this.editedCollector.longitude = response.data.collector.longitude
                this.dialog = true
            })
            .catch( error => {
                alert(error)
            })
        },
        deleteCollector(item) {
            var itemDeletion = confirm('Are you sure you want to delete this item?')
            if(itemDeletion == true) {
                axios.delete('api/collectors/' + item.id)
                .then( response => { 
                    const index = this.collectors.indexOf(item)
                    this.collectors.splice(index, 1)
                })
                .catch( error => { alert(error)})
            }
        },
        cancel() {
            this.dialog = false
            setTimeout(() => {
                this.editedCollector = Object.assign({}, this.defaultCollector)
                this.editedIndex = -1
            }, 500)
        },
        saveCollector() {
            this.loading = true
            if (this.editedIndex > -1) {
                // Update item
                axios.put('api/collectors/' + this.editedCollector.id, { 
                    username: this.editedCollector.username, password: this.editedCollector.password, password_confirmation: this.editedCollector.password, role: 'Collector', name: this.editedCollector.name, license_number: this.editedCollector.license_number, plate_number: this.editedCollector.plate_number, address: this.editedCollector.address, latitude: this.editedCollector.latitude, longitude: this.editedCollector.longitude
                })
                .then( response => { 
                    Object.assign(this.collectors[this.editedIndex], this.editedCollector)
                    this.cancel()
                })
                .catch( error => { alert(error)})
                .finally( x => { this.loading = false})
            } else {
                // Create new item
                axios.post('api/collectors', { 
                    username: this.editedCollector.username, password: this.editedCollector.password, password_confirmation: this.editedCollector.password, role: 'Collector', name: this.editedCollector.name, license_number: this.editedCollector.license_number, plate_number: this.editedCollector.plate_number, address: this.editedCollector.address, latitude: this.editedCollector.latitude, longitude: this.editedCollector.longitude
                })
                .then( response => { 
                    this.editedCollector.id = response.data.collector.id
                    this.collectors.push(this.editedCollector)
                    this.cancel()
                })
                .catch( error => { alert(error)})
                .finally( x => { this.loading = false})
            }
        }
    },
}
</script>