<template>
    <v-app>
        <v-container fluid>
            <v-row justify="center" align="center">
                <v-col class="text-center">
                    <v-data-table :headers="headers" :items="reports" class="elevation-1">
                        <template v-slot:top>
                            <v-toolbar flat color="white">
                                <v-toolbar-title class="title">Reports</v-toolbar-title>
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
                    { text: 'Sender', value: 'sender',},
                    { text: 'Barangay', value: 'barangay',},
                    { text: 'Date and Time', value: 'date_time',},
                    { text: 'Actions', value: 'action', sortable: false},
                ],
                reports: [
                    { id: 1, sender: 'NthnyVllflrs', barangay: 'Sta Catalina', date_time: '11-10-2019 14:30'},
                    { id: 2, sender: 'NthnyVllflrs', barangay: 'Sta Catalina', date_time: '11-10-2019 12:30'},
                ],
            }
        }
    }
</script>