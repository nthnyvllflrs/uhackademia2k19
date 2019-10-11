<template>
    <v-app>
        <v-container fluid>
            <v-row justify="center" align="center">
                <v-col class="text-center">
                    <v-data-table :headers="headers" :items="barangays" class="elevation-1">
                        <template v-slot:top>
                            <v-toolbar flat color="white">
                                <v-toolbar-title class="title">Barangays</v-toolbar-title>
                            </v-toolbar>
                        </template>
                        <template v-slot:item.action="{ item }">
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
        }
    }
</script>