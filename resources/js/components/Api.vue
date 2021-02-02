<template>
    <v-container class="my-4">
        <api-card endpoint="/api/list">
            Get a list of all the book reading lists
        </api-card>
        <api-card method="POST" endpoint="/api/list/{list_id}" :response-mocked="{'Todo':true}">
            Add or detach a book to a list, update a details on a book within a list
        </api-card>
        <kbd class="mt-5"><-- Todo: More docs 😅 --></kbd>
    </v-container>
</template>
<script>
import ApiCard from "./ApiCard";

export default {
    components: {ApiCard},
}
</script>
