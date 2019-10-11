<template>
    <v-app>
        <v-app-bar app>
            <v-toolbar-title>Trash</v-toolbar-title>

            <div class="flex-grow-1"></div>

            <v-toolbar-items>
                <v-btn text to='/login'>Login</v-btn>
            </v-toolbar-items>
        </v-app-bar>
        <v-content>
            <router-view name="landing"></router-view>
        </v-content>
    </v-app>
</template>

<script>
    export default {
        
    }
</script>