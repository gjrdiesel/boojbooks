<template>
    <div>
        <v-container fluid>
            <v-app-bar>
                <v-btn text to="/">
                    BoojBooks
                </v-btn>
                <v-spacer/>
                <div v-if="!user">
                    <v-btn to="/login" text>
                        Login
                    </v-btn>
                </div>
                <div v-if="user">
                    <v-btn to="/list" text>
                        Books
                    </v-btn>
                    <v-btn to="/api" text>
                        API
                    </v-btn>
                    <v-btn @click="handleLogout" text>
                        Logout
                    </v-btn>
                </div>
            </v-app-bar>
            <router-view v-bind="$data" :app="this"/>
        </v-container>
        <v-footer app>
            <small>Copyright &copy; Justin Reasoner</small>
        </v-footer>
    </div>
</template>
<script>
export default {
    data() {
        return {
            user: false,
        }
    },
    async mounted() {
        //await axios.get('/sanctum/csrf-cookie');
        await this.refreshUser();
    },
    methods: {
        async handleLogout() {
            if(confirm('Are you sure you want to log out?')){
                this.user = (await axios.post('/api/logout')).data;
            }
        },
        async refreshUser() {
            // Should use a store like vuex, but _demo_ mode engaged
            try {
                this.user = (await axios.get('/api/user')).data;
            } catch (e) {
                this.user = false;
            }
        }
    }
}
</script>
