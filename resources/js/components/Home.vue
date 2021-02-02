<template>
    <div>
        <v-container fluid class="hero">
            <h1>Welcome to BoojBooks!</h1>
            <p>I'm your host, Justin Reasoner 👋</p>
        </v-container>
        <v-container fluid>
            <p>So, not lots of time to work on this, maybe spending more than I should already, but hey it's fun!
                Anyway, here are a few
                of the different sections the API has to offer.</p>

            <h2>Authors</h2>
            <v-row class="mb-5 mt-3">
                <v-col class="col-4" v-for="author in authors">
                    <card v-bind="massage({author})"/>
                </v-col>
            </v-row>

            <h2>Books</h2>
            <v-row class="mb-5 mt-3">
                <v-col class="col-4" v-for="book in books">
                    <card v-bind="massage({book})"/>
                </v-col>
            </v-row>

            <h2>Users</h2>
            <v-row class="mb-5 mt-3">
                <v-col class="col-4" v-for="user in users">
                    <card v-bind="massage({user})"/>
                </v-col>
            </v-row>

            <h2>Lists</h2>
            <v-row class="mb-5 mt-3">
                <v-col class="col-4" v-for="list in lists">
                    <card v-bind="massage({list})"/>
                </v-col>
            </v-row>

            <p>Still want more? Check out the
                <router-link to="/docs">docs</router-link>
                or the
                <router-link to="/api">api.</router-link>
            </p>
        </v-container>
    </div>
</template>
<script>
import card from "./card"

export default {
    components: {card},
    async mounted() {
        const data = (await axios.get('/api/welcome')).data;
        Object.keys(data).forEach(key => this[key] = data[key].data)
    },
    methods: {
        massage(type) {
            if(type.author){
                return {
                    title: type.author.name,
                    description: type.author.bio,
                    action: `Learn more`,
                    link: `/list`,
                }
            }
            if(type.book){
                return {
                    title: type.book.title,
                    description: type.book.author.name,
                    action: `Discover`,
                    link: `/list`,
                }
            }
            if(type.user){
                return {
                    title: type.user.name,
                    description: type.user.email,
                    action: `Add friend`,
                    link: `/list`,
                }
            }
            if(type.list){
                return {
                    title: type.list.name,
                    description: ``,
                    action: `See list`,
                    link: `/list`,
                }
            }
        }
    },
    data() {
        return {
            authors: [],
            books: [],
            users: [],
            lists: [],
        }
    }
}
</script>
<style scoped>
.hero {
    margin-top: 10px;
    min-height: 50vh;
    justify-content: center;
    display: flex;
    flex-direction: column;
    background-image: url("https://images.unsplash.com/photo-1524995997946-a1c2e315a42f?ixid=MXwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHw%3D&ixlib=rb-1.2.1&auto=format&fit=crop&w=1350&q=80");
    background-size: cover;
    color: white;
    font-size: 2em;
    text-shadow: 2px 2px #1a1a1a;
}
</style>
