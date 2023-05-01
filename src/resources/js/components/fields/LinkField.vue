<template>
    <input type="url" v-model="field.value" class="form-control" :placeholder="field.title">
</template>

<script>
export default {
    name: "LinkField",
    props: {
        field: {
            type: Object
        },
    }
}
</script>
