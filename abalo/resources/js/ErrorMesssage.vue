<template>
    <div>
        <h1>error comp</h1>
    <div v-if="message">
        {{ message }}
    </div>
    </div>
</template>

<script>
export default {
    props: ['message']
}
</script>
