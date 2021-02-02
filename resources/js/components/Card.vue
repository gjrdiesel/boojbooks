<template>
    <v-card outlined>
        <v-card-title>{{ title }}</v-card-title>
        <v-card-subtitle class="description">{{ description }}</v-card-subtitle>
        <v-card-actions>
            <v-btn
                v-if="action"
                outlined
                rounded
                text
                :to="link"
            >
                {{ action }}
            </v-btn>
        </v-card-actions>
    </v-card>
</template>
<style scoped>
.description {
    white-space: pre-wrap;
}
</style>
<script>
export default {
    props: [
        'title', 'description', 'action', 'link'
    ]
}
</script>
