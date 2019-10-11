<template>
    <v-app>
        <v-container fluid>
            <v-row justify="center" align="center">
                <v-col class="text-center">
                    <v-data-table :headers="headers" :items="barangays" class="elevation-1">
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
                                        <v-card-title>
                                            <span class="headline">{{ formTitle }}</span>
                                        </v-card-title>

                                        <v-card-text>
                                            <v-container>
                                                <v-row>
                                                    <v-col cols="12">
                                                        <v-text-field v-model="editedBarangay.name" label="Name"></v-text-field>
                                                    </v-col>
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
    </v-app>
</template>

<script>
    export default {
        data() {
            return {
                dialog: false,
                editedBarangay: { name: null},
                defaultBarangay: { name: null},
                editedIndex: -1,
                headers: [
                    { text: 'ID', value: 'id',},
                    { text: 'Name', value: 'name',},
                    { text: 'Actions', value: 'action', sortable: false},
                ],
                barangays: [
                    { id: 1, name: 'Sta Catalina',},
                    { id: 2, name: 'Tetuan',},
                    { id: 3, name: 'Talon-Talon',},
                    { id: 4, name: 'Mampang',},
                ],
            }
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
            editBarangay(item) {
                console.log(item)
                this.editedIndex = this.barangays.indexOf(item)
                this.editedBarangay = Object.assign({}, item)
                this.dialog = true
            },
            deleteBarangay(item) {
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
                    this.editedBarangay = Object.assign({}, this.defaultBarangay)
                    this.editedIndex = -1
                }, 300)
            },
            saveBarangay() {
                if(this.editedIndex > -1) {
                    console.log("Update")
                } else {
                    console.log("Save");
                }
            }
        }
    }
</script>