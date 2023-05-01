<template>
    <input type="text" v-model="field.value" class="form-control" :placeholder="field.title" autocomplete="off">
</template>

<script>
export default {
    name: "SingleLineTextField",
    props: {
        field: {
            type: Object
        }
    }
}
</script>
