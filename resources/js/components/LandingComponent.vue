<template>
    <div>
        <v-app-bar app>
            <v-toolbar-title>Limpieza</v-toolbar-title>
            <div class="flex-grow-1"></div>
            <v-toolbar-items>
                <v-btn text to="/signin">Signin</v-btn>
                <!-- <v-btn text to="/signup">Signup</v-btn> -->
            </v-toolbar-items>
        </v-app-bar>

        <router-view name="landing"></router-view>
    </div>
</template>


<script>
export default {
    data() {
        return {
        }
    }
}
</script>