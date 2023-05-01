<template>
    <textarea v-model="field.value" class="form-control" :placeholder="field.title"></textarea>
</template>

<script>
export default {
    name: "TextField",
    props: {
        field: {
            type: Object
        }
    }
}
</script>
