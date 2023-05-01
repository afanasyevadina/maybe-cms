<template>
    <select v-model="field.value" class="form-control">
        <option v-for="(option, optionKey) in field.options" :value="optionKey" :key="optionKey">{{ option }}</option>
    </select>
</template>

<script>
export default {
    name: "SelectField",
    props: {
        field: {
            type: Object
        }
    }
}
</script>
