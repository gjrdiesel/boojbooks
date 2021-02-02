<template>
    <div>
        <v-container>
            <h2>{{ list.name }}</h2>
            <p>These are books within the <i>{{ list.name }}</i> reading list, drag and drop, or mark them as finished.
            </p>
            <draggable v-model="books" group="lists" @start="drag=true" @end="drag=false" @change="handleChange"
                       class="mb-5 mt-3 draggable">
                <card class="ma-3" v-for="(book,index) in books" v-bind="massage(book,index)"/>
            </draggable>
            <kbd><-- Todo: pagination --></kbd>
        </v-container>
    </div>
</template>
<style scoped>
.draggable {
    cursor: pointer;
}
</style>
<script>
import card from "./card"
import draggable from 'vuedraggable'

export default {
    components: {card, draggable},
    async mounted() {
        this.loadBooks();
    },
    methods: {
        async loadBooks(){
            const {list_id} = this.$route.params;

            const {books, list} = ((await axios.get(`/api/list/${list_id}`)).data)
            this.books = books.data;
            this.list = list;
        },
        async handleChange({moved}) {

            const data = {
                new_order: this.books[moved.newIndex].pivot.order,
                old_order: moved.element.pivot.order,
            };

            console.log(moved,data);

            await axios.patch(`/api/list/${this.list.id}`, data);
            await this.loadBooks();
        },
        massage(book, index) {
            const date = (new Date(book.updated_at)).toLocaleString();
            return {
                title: `${book.pivot.id}) ${book.title}`,
                description: `Released ${date}\nAuthor ${book.author.name} \nAuthor Bio: ${book.author.bio}`,
                link: `/list/${book.id}`,
                state: book.state
            }
        }
    },
    data() {
        return {
            drag: false,
            list: [],
            books: [],
        }
    }
}
</script>
