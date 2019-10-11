<template>
    <v-app>
        <v-content>
            <v-container fluid>
                <v-row align="center" justify="center">
                    <v-col cols="12" sm="8" md="4">
                        <v-card class="elevation-1">
                            <v-card-text>
                                <v-text-field v-model="username" label="Username" name="username" id="username" prepend-icon="fa-user" type="text"></v-text-field>
                                <v-text-field v-model="password" label="Password" id="password"  name="password" prepend-icon="fa-lock" type="password"></v-text-field>
                            </v-card-text>
                            <v-card-actions>
                                <div class="flex-grow-1"></div>
                                <v-btn color="success" :loading="loading" @click="login">Signin</v-btn>
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
                username: null, 
                password: null,
            }
        },

        methods: {
            login() {
                console.log("Login!")
            }
        }
    }
</script>