<template>
    <v-app>
        <v-content>
            <v-container fluid>
                <v-row align="center" justify="center">
                    <v-col cols="12" sm="8" md="4">
                        <v-card>
                            <v-card-title>
                                <span class="headline">New Customer</span>
                            </v-card-title>

                            <v-card-text>
                                <v-container>
                                    <v-text-field v-model="customer.username" label="Username"></v-text-field>
                                    <v-text-field v-model="customer.password" label="Password" type="password"></v-text-field>
                                    <v-text-field v-model="customer.password_confirmation" label="Password Confirmation" type="password"></v-text-field>
                                    <v-row>
                                        <v-col col-12><v-text-field v-model="customer.lastname" label="Lastname"></v-text-field></v-col>
                                        <v-col col-12><v-text-field v-model="customer.firstname" label="Firstname"></v-text-field></v-col>
                                    </v-row>
                                    <v-textarea v-model="customer.address" label="Address"></v-textarea>
                                    <v-text-field v-model="customer.phone_number" label="Phone Number"></v-text-field>
                                </v-container>
                            </v-card-text>

                            <v-card-actions>
                                <div class="flex-grow-1"></div>
                                <v-btn :loading="loading" color="success" @click="register">Register</v-btn>
                            </v-card-actions>
                        </v-card>
                    </v-col>
                </v-row>
            </v-container>
        </v-content>
    </v-app>
</template>

<script>
export default {
    data() {
        return {
            loading: false,
            customer: {username: null, password: null, lastname: null, firstname: null, address: null, phone_number: null,}
        }
    },
    methods: {
        register() {
            this.loading = true
            axios.post('api/register', { 
                username: this.customer.username, password: this.customer.password, password_confirmation: this.customer.password_confirmation, 
                lastname: this.customer.lastname, firstname: this.customer.firstname, address: this.customer.address,
                phone_number: this.customer.phone_number, user_type: 'Customer',
            })   
            .then( response => { 
                axios.post('api/login', { 
                    username: this.customer.username, password: this.customer.password
                })
                .then( response => {
                    var token = response.data.token
                    // Create a local storage item
                    localStorage.setItem('user-token', token)
                    // Redirect user
                    this.$router.push('requests')
                })
                .catch( error => { alert(error.errors)})
                .finally( x => {})
            })
            .catch( error => { alert(error)})
            .finally( x => { this.loading = false})
        }
    }
}
</script>