<template>
    <v-app>
        <v-container fluid>
            <v-row justify="center" align="center">
                <v-col class="text-center">
                    <v-data-table :headers="headers" :items="residents" class="elevation-1">
                        <template v-slot:top>
                            <v-toolbar flat color="white">
                                <v-toolbar-title class="title">Residents</v-toolbar-title>
                            </v-toolbar>
                        </template>
                        <template v-slot:item.action="{ item }">
                            <v-icon small class="mr-2" @click="">fa-map-marked-alt</v-icon>
                            <v-icon small class="mr-2" @click="">fa-edit</v-icon>
                            <v-icon small @click="">fa-trash-alt</v-icon>
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
            }
        }
    }
</script>