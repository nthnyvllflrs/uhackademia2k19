<template>
    <v-app>
        <v-app-bar app>
            <v-app-bar-nav-icon 
                @click.stop="drawer = !drawer"></v-app-bar-nav-icon>
            <v-toolbar-title>Trash</v-toolbar-title>
        </v-app-bar>

        <v-navigation-drawer app
            v-model="drawer" width="300px">
            <v-list>
                <v-list-item to="/reports">
                    <v-list-item-avatar>
                        <v-icon>fa-list</v-icon>
                    </v-list-item-avatar>
                    <v-list-item-content>
                        <v-list-item-title
                            class="subtitle-2 font-weight-bold">Reports</v-list-item-title>
                        <v-list-item-subtitle
                            class="caption">Display list of reports</v-list-item-subtitle>
                    </v-list-item-content>
                </v-list-item>
                <v-list-item to="/barangays">
                    <v-list-item-avatar>
                        <v-icon>fa-list</v-icon>
                    </v-list-item-avatar>
                    <v-list-item-content>
                        <v-list-item-title
                            class="subtitle-2 font-weight-bold">Barangays</v-list-item-title>
                        <v-list-item-subtitle
                            class="caption">Display list of barangays</v-list-item-subtitle>
                    </v-list-item-content>
                </v-list-item>
                <v-list-item to="/residents">
                    <v-list-item-avatar>
                        <v-icon>fa-list</v-icon>
                    </v-list-item-avatar>
                    <v-list-item-content>
                        <v-list-item-title
                            class="subtitle-2 font-weight-bold">Residents</v-list-item-title>
                        <v-list-item-subtitle
                            class="caption">Display list of residents</v-list-item-subtitle>
                    </v-list-item-content>
                </v-list-item>
            </v-list>
            <template v-slot:append>
                <v-list>
                    <v-list-item @click.stop="logout">
                        <v-list-item-avatar>
                            <v-icon>fa-sign-out-alt</v-icon>
                        </v-list-item-avatar>
                        <v-list-item-content>
                            <v-list-item-title
                                class="subtitle-2 font-weight-bold">Logout</v-list-item-title>
                        </v-list-item-content>
                    </v-list-item>
                </v-list>
            </template>
        </v-navigation-drawer>

        <v-content>
            <router-view name="dashboard"></router-view>
        </v-content>
    </v-app>
</template>

<script>
    export default {
        data() {
            return {
                drawer: false
            }
        }
    }
</script>