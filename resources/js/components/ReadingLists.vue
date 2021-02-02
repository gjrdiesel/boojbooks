<template>
    <div>
        <v-container>
            <h2>Lists</h2>
            <p>These are the list of books, you can drag and drop to reorder them, or click "discover" to view the all
                the books within</p>
            <draggable v-model="lists" group="lists" @start="drag=true" @end="drag=false" @change="handleChange"
                       class="mb-5 mt-3 draggable">
                <card class="my-3" v-for="(list,index) in lists" v-bind="massage(list,index)"/>
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
        this.lists = ((await axios.get('/api/list')).data).data;
    },
    methods: {
        async handleChange({moved}) {
            await axios.post(`/api/list/${moved.element.id}/move`, {
                newIndex: moved.newIndex,
                oldIndex: moved.oldIndex,
            });
        },
        massage(list, index) {
            const date = (new Date(list.updated_at)).toLocaleString();
            return {
                title: `${index + 1}) ${list.name}`,
                description: `Last updated ${date}\nBooks: ${list.books_count}`,
                action: `Discover`,
                link: `/list/${list.id}`
            }
        }
    },
    data() {
        return {
            drag: false,
            lists: [],
        }
    }
}
</script>
