<template>
    <v-container class="login">
        <v-form @submit="handleSubmit" ref="form" class="form">
            <v-text-field
                label="Enter your e-mail address"
                value="demo@demo.com"
            ></v-text-field>
            <v-text-field
                label="Enter your password"
                value="password123"
            ></v-text-field>
            <v-layout justify-space-between>
                <v-btn @click="handleSubmit">Login</v-btn>
            </v-layout>
        </v-form>
    </v-container>
</template>
<script>
export default {
    props: ['app'],
    mounted() {
        document.querySelector('.v-application').classList.add('login');
    },
    destroyed() {
        document.querySelector('.v-application').classList.remove('login');
    },
    methods: {
        async handleSubmit() {
            // Normally would have validation, username/password, but for brevity,
            // just going to act like you typed in the demo u/p

            const result = (await axios.post('/api/login', {
                email: 'demo@demo.com',
                password: 'password123'
            })).data;

            await this.app.refreshUser();

            this.$router.replace('/list');
        }
    }
}
</script>
<style>
.v-application.login {
    background-image: url(https://images.unsplash.com/photo-1524995997946-a1c2e315a42f?ixid=MXwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHw%3D&ixlib=rb-1.2.1&auto=format&fit=crop&w=1350&q=80);
    background-size: cover;
}

.v-application.login::before {
    content: "";
    position: absolute;
    top: 0;
    right: 0;
    bottom: 0;
    left: 0;
    background-color: rgba(255, 255, 255, .85);
}

.login .form {
    max-width: 600px;
    margin: 0 auto;
    margin-top: 20vh;
    min-height: 60vh;
}
</style>
