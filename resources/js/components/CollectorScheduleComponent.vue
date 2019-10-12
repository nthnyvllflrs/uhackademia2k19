<template>
    <div>
        <v-container fluid>
            <v-row justify="center" align="center">
                <v-col class="text-center">
                    <v-data-table :loading=loading loading-text="Loading... Please wait" :headers="headers" :items="schedules" class="elevation-1">
                        <template v-slot:top>
                            <v-toolbar flat color="white">
                                <v-toolbar-title class="title">Schedules</v-toolbar-title>
                                <div class="flex-grow-1"></div>
                                <v-dialog v-model="dialog" max-width="500px" v-if="userRole == 'Administrator'">
                                    <template v-slot:activator="{ on }">
                                        <v-btn small color="success" v-on="on">
                                            <v-icon small left>fa-plus</v-icon> Add Schedule
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
                                                <v-alert small type="error" v-if="error">
                                                    <span>{{ error }}</span>
                                                </v-alert>
                                                <v-row>
                                                    <v-col cols="12"><v-select :items="barangay_names" v-model="editedSchedule.barangay" label="Barangay"></v-select></v-col>
                                                    <v-col cols="6"><v-text-field v-model="editedSchedule.date" label="Date"></v-text-field></v-col>
                                                    <v-col cols="6"><v-text-field v-model="editedSchedule.time" label="Time"></v-text-field></v-col>
                                                </v-row>
                                            </v-container>
                                        </v-card-text>

                                        <v-card-actions>
                                            <div class="flex-grow-1"></div>
                                            <v-btn color="error" @click="cancel">Cancel</v-btn>
                                            <v-btn color="success" @click="saveSchedule">Save</v-btn>
                                        </v-card-actions>
                                    </v-card>
                                </v-dialog>
                            </v-toolbar>
                        </template>
                        <template v-slot:item.action="{ item }">
                            <v-icon small class="mr-2" @click="editSchedule(item)">fa-edit</v-icon>
                            <v-icon small @click="deleteSchedule(item)">fa-trash-alt</v-icon>
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
            barangay_names: [],
            error: null,
            userRole: null,
            dialog: false, loading: false,
            editedIndex: -1,
            defaultSchedule: { barangay: null, date: null, time: null,},
            editedSchedule: { barangay: null, date: null, time: null,},
            headers: [
                {text: 'ID', value: 'id',},
                {text: 'Barangay', value: 'barangay',},
                {text: 'Date', value: 'date'},
                {text: 'Time', value: 'time'},
                // {text: 'Actions', value: 'action', sortable: false },
            ],
            schedules: [],
        }
    },
    mounted() {
        this.retrieveBarangayList()
        this.retrieveScheduleList()
        this.userRole = localStorage.getItem('user-role')
        if(this.userRole == 'Administrator') { this.headers.push({text: 'Actions', value: 'action', sortable: false },)}
    },
    
    computed: {
        formTitle () {
            return this.editedIndex === -1 ? 'New Schedule' : 'Edit Schedule'
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
        retrieveScheduleList() {
            this.loading = true
            axios.get('api/collector-schedule')
            .then( response => {
                this.schedules = response.data.schedules
            })
            .catch( error => { alert(error)})
            .finally( x => { this.loading = false})
        },
        editSchedule(item) {
            this.editedIndex = this.schedules.indexOf(item)
            this.editedSchedule = Object.assign({}, item)
            this.dialog = true
        },
        deleteSchedule(item) {
            var itemDeletion = confirm('Are you sure you want to delete this item?')
            if(itemDeletion == true) {
                axios.delete('api/collector-schedule/' + item.id)
                .then( response => { 
                    const index = this.schedules.indexOf(item)
                    this.schedules.splice(index, 1)
                })
                .catch( error => { alert(error)})
            }
        },
        cancel() {
            this.dialog = false
            setTimeout(() => {
                this.editedSchedule = Object.assign({}, this.defaultSchedule)
                this.editedIndex = -1
            }, 500)
        },
        saveSchedule() {
            this.loading = true
            if (this.editedIndex > -1) {
                // Update item
                axios.put('api/collector-schedule/' + this.editedSchedule.id, { 
                    barangay: this.editedSchedule.barangay, date: this.editedSchedule.date, time: this.editedSchedule.time
                })
                .then( response => { 
                    Object.assign(this.schedules[this.editedIndex], this.editedSchedule)
                    this.cancel()
                })
                .catch( error => { this.error = error.message})
                .finally( x => { this.loading = false})
            } else {
                // Create new item
                axios.post('api/collector-schedule', { 
                    barangay: this.editedSchedule.barangay, date: this.editedSchedule.date, time: this.editedSchedule.time
                })
                .then( response => { 
                    this.editedSchedule.id = response.data.collector_schedule.id
                    this.editedSchedule.barangay = response.data.collector_schedule.barangay.name
                    this.schedules.push(this.editedSchedule)
                    this.cancel()
                })
                .catch( error => { this.error = error.message})
                .finally( x => { this.loading = false})
            }
        }
    },
}
</script>