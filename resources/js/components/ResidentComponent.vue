<template>
    <div>
        <v-container fluid>
            <v-row justify="center" align="center">
                <v-col class="text-center">
                    <v-data-table :loading=loading loading-text="Loading... Please wait" :headers="headers" :items="residents" class="elevation-1">
                        <template v-slot:top>
                            <v-toolbar flat color="white">
                                <v-toolbar-title class="title">Residents</v-toolbar-title>
                                <div class="flex-grow-1"></div>
                                <v-dialog v-model="dialog" max-width="500px">
                                    <template v-slot:activator="{ on }">
                                        <v-btn small color="success" v-on="on">
                                            <v-icon small left>fa-plus</v-icon> Add Resident
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
                                                    <v-col cols="6"><v-text-field v-model="editedResident.username" label="Username"></v-text-field></v-col>
                                                    <v-col cols="6"><v-select :items="barangay_names" v-model="editedResident.barangay" label="Barangay"></v-select></v-col>
                                                    <v-col cols="6"><v-text-field v-model="editedResident.fullname" label="Fullname"></v-text-field></v-col>
                                                    <v-col cols="6"><v-text-field v-model="editedResident.phone_number" label="Phone Number"></v-text-field></v-col>
                                                    <v-col cols="12"><v-text-field v-model="editedResident.address" label="Address"></v-text-field></v-col>
                                                    <v-col cols="6"><v-text-field v-model="editedResident.latitude" label="Latitude"></v-text-field></v-col>
                                                    <v-col cols="6"><v-text-field v-model="editedResident.longitude" label="Longitude"></v-text-field></v-col>
                                                </v-row>
                                            </v-container>
                                        </v-card-text>

                                        <v-card-actions>
                                            <div class="flex-grow-1"></div>
                                            <v-btn color="error" @click="cancel">Cancel</v-btn>
                                            <v-btn color="success" @click="saveResident">Save</v-btn>
                                        </v-card-actions>
                                    </v-card>
                                </v-dialog>
                            </v-toolbar>
                        </template>
                        <template v-slot:item.action="{ item }">
                            <v-icon small class="mr-2" @click="editResident(item)">fa-edit</v-icon>
                            <v-icon small @click="deletedResident(item)">fa-trash-alt</v-icon>
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
            Administrator: false,
            dialog: false, loading: false,
            editedIndex: -1,
            defaultResident: { username: null, password: "123456798", role: 'Resident', barangay: null, fullname: null, phone_number: null, address: null, latitude: null, longitude: null,},
            editedResident: { username: null, password: "123456798", role: 'Resident', barangay: null, fullname: null, phone_number: null, address: null, latitude: null, longitude: null,},
            headers: [
                {text: 'ID', value: 'id',},
                {text: 'Username', value: 'username',},
                {text: 'Fullname', value: 'fullname'},
                {text: 'Barangay', value: 'barangay'},
                {text: 'Phone Number', value: 'phone_number'},
                {text: 'Actions', value: 'action', sortable: false },
            ],
            residents: [],
            barangay: [],
            barangay_names: [],
        }
    },
    mounted() {
        this.retrieveResidentList()
        this.retrieveBarangayList()
        console.log(localStorage.getItem('user-role'))
    },
    
    computed: {
        formTitle () {
            return this.editedIndex === -1 ? 'New Resident' : 'Edit Resident'
        },
    },
    watch: {
        dialog (val) {
            val || this.cancel()
        },
    },
    
    methods: {
        retrieveBarangayList() {
            axios.get('api/barangays/names')
            .then( response => {
                this.barangay_names = response.data.barangay_names
            })
            .catch( error => { alert(error)})
            .finally( x => { this.loading = false})
        },
        retrieveResidentList() {
            this.loading = true
            axios.get('api/residents')
            .then( response => {
                this.residents = response.data.residents
            })
            .catch( error => { alert(error)})
            .finally( x => { this.loading = false})
        },
        editResident(item) {
            axios.get('api/residents/' + item.id)
            .then( response => {
                this.editedIndex = this.residents.indexOf(item)
                this.editedResident = Object.assign({}, item)
                this.editedResident.address = response.data.resident.address
                this.editedResident.latitude = response.data.resident.latitude
                this.editedResident.longitude = response.data.resident.longitude
                this.dialog = true
            })
            .catch( error => {
                alert(error)
            })
        },
        deletedResident(item) {
            var itemDeletion = confirm('Are you sure you want to delete this item?')
            if(itemDeletion == true) {
                axios.delete('api/residents/' + item.id)
                .then( response => { 
                    const index = this.residents.indexOf(item)
                    this.residents.splice(index, 1)
                })
                .catch( error => { alert(error)})
            }
        },
        cancel() {
            this.dialog = false
            setTimeout(() => {
                this.editedResident = Object.assign({}, this.defaultResident)
                this.editedIndex = -1
            }, 500)
        },
        saveResident() {
            this.loading = true
            if (this.editedIndex > -1) {
                // Update item
                axios.put('api/residents/' + this.editedResident.id, { 
                    username: this.editedResident.username, password: this.editedResident.password, password_confirmation: this.editedResident.password,
                    role: 'Resident', barangay: this.editedResident.barangay, fullname: this.editedResident.fullname, 
                    phone_number: this.editedResident.phone_number, address: this.editedResident.address, 
                    latitude: this.editedResident.latitude, longitude: this.editedResident.longitude,
                })
                .then( response => { 
                    Object.assign(this.residents[this.editedIndex], this.editedResident)
                    this.cancel()
                })
                .catch( error => { alert(error)})
                .finally( x => { this.loading = false})
            } else {
                // Create new item
                axios.post('api/residents', { 
                    username: this.editedResident.username, password: this.editedResident.password, password_confirmation: this.editedResident.password,
                    role: 'Resident', barangay: this.editedResident.barangay, fullname: this.editedResident.fullname, 
                    phone_number: this.editedResident.phone_number, address: this.editedResident.address, 
                    latitude: this.editedResident.latitude, longitude: this.editedResident.longitude,
                })
                .then( response => { 
                    this.editedResident.id = response.data.resident.id
                    this.residents.push(this.editedResident)
                    this.cancel()
                })
                .catch( error => { alert(error)})
                .finally( x => { this.loading = false})
            }
        }
    },
}
</script>