<template>
    <div>
        <kbd>Request:</kbd>
        <code>{{ method }} http://boojbooks.herokuapp.com{{ endpoint }}</code>
        <p>
            <slot/>
        </p>

        <kbd>Response:</kbd>
        <pre>{{ response }}</pre>
    </div>
</template>
<style scoped>
pre {
    font-size: 12px
}
</style>
<script>
export default {
    props: ['endpoint', 'responseMocked', 'method'],
    async created() {
        if (this.responseMocked) {
            this.response = this.responseMocked;
        }
        this.response = (await axios.get(this.endpoint)).data;
    },
    data() {
        return {
            response: {}
        }
    }
}
</script>
