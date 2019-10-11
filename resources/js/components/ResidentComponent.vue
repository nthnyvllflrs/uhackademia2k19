<template>
    <v-app>
        <v-container fluid>
            <v-row justify="center" align="center">
                <v-col class="text-center">
                    <v-data-table :headers="headers" :items="residents" class="elevation-1">
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
                                        <v-card-title>
                                            <span class="headline">{{ formTitle }}</span>
                                        </v-card-title>

                                        <v-card-text>
                                            <v-container>
                                                <v-row>
                                                    <v-col cols="12">
                                                        <v-text-field v-model="editedResident.username" label="Username"></v-text-field>
                                                    </v-col>
                                                    <v-col cols="6">
                                                        <v-text-field v-model="editedResident.firstname" label="Firstname"></v-text-field>
                                                    </v-col>
                                                    <v-col cols="6">
                                                        <v-text-field v-model="editedResident.lastname" label="Lastname"></v-text-field>
                                                    </v-col>
                                                    <v-col cols="6">
                                                        <v-text-field v-model="editedResident.contact_number" label="Contact Number"></v-text-field>
                                                    </v-col>
                                                    <v-col cols="6">
                                                        <v-select :items="barangays" v-model="editedResident.barangay" label="Barangay"></v-select>
                                                    </v-col>
                                                    <v-col cols="12">
                                                            <v-text-field readonly v-model="editedResident.location" label="Location" append-outer-icon="fa-map-marker-alt" @click:append-outer="showMapView(null)"></v-text-field>
                                                    </v-col>
                                                    <v-col cols="6">
                                                        <v-text-field readonly v-model="editedResident.latitude" label="Latitude"></v-text-field>
                                                    </v-col>
                                                    <v-col cols="6">
                                                        <v-text-field readonly v-model="editedResident.longitude" label="Longitude"></v-text-field>
                                                    </v-col>
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

                                <v-dialog v-model="mapDialog" max-width="500px">
                                    <v-card>
                                        <v-card-text>
                                            <v-container>
                                                <p>Map will show here!</p>
                                            </v-container>
                                        </v-card-text>
                                    </v-card>
                                </v-dialog>
                            </v-toolbar>
                        </template>
                        <template v-slot:item.action="{ item }">
                            <v-icon small class="mr-2" @click="showMapView(item)">fa-map-marked-alt</v-icon>
                            <v-icon small class="mr-2" @click="editResident(item)">fa-edit</v-icon>
                            <v-icon small @click="deleteResident(item)">fa-trash-alt</v-icon>
                        </template>
                    </v-data-table>
                </v-col>
            </v-row>
        </v-container>
    </v-app>
</template>

<script>
    export default {
        data() {
            return {
                loading: false,
                dialog: false,
                mapDialog: false,
                editedIndex: -1,
                defaultResident: {
                    username: null, firstname: null, lastname: null, contact_number: null, 
                    location: 'Zamboanga City', latitude: 6.9214, longitude: 122.0790,
                },
                editedResident: {
                    username: null, firstname: null, lastname: null, contact_number: null, 
                    location: 'Zamboanga City', latitude: 6.9214, longitude: 122.0790,
                },
                headers: [
                    { text: 'ID', value: 'id',},
                    { text: 'Username', value: 'username',},
                    { text: 'Name', value: 'name',},
                    { text: 'Barangay', value: 'barangay',},
                    { text: 'Actions', value: 'action', sortable: false},
                ],
                residents: [
                    { id: 1, username: 'NthnyVllflrs', name: 'Anthony Villaflores', barangay: 'Sta Catalina',},
                    { id: 2, username: 'MrJJr', name: 'Emir Jo Jr', barangay: 'Putik',},
                    { id: 3, username: 'FtmMrcyNrb', name: 'Fatima Mercy Onrubia', barangay: 'Tetuan',},
                ],
                barangays: [
                    'Sta Catalina', 'Talon-Talon', 'Mampang', 'Arena Blanco',
                ]
            }
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
            showMapView(item) {
                if(item) {
                    // View
                } else {
                    // Update and Save
                }
                this.mapDialog = !this.mapDialog
            },
            editResident(item) {
                this.editedIndex = this.residents.indexOf(item)
                this.editedResident = Object.assign({}, item)
                this.dialog = true
            },
            deleteResident(item) {
                var itemDeletion = confirm('Are you sure you want to delete this request?')
                if(itemDeletion == true) {
                    console.log("Deleted");
                } else {
                    console.log("!Deleted");
                }
            },
            cancel() {
                this.dialog = false
                setTimeout(() => {
                    this.editedResident = Object.assign({}, this.defaultResident)
                    this.editedIndex = -1
                }, 300)
            },
            saveResident() {
                if(this.editedIndex > -1) {
                    console.log("Update")
                } else {
                    console.log("Save")
                }
            },
        }
    }
</script>