<template>
    <div>
        <div class="mb-4">
            <label>Meta title</label>
            <input type="text" v-model="meta.title" class="form-control">
        </div>
        <div class="mb-4">
            <label>Meta description</label>
            <textarea rows="2" v-model="meta.description" class="form-control"></textarea>
        </div>
        <label>Open graph image</label>
        <image-field :field="meta"></image-field>
    </div>
</template>

<script>
export default {
    name: "MetaFields",
    props: {
        meta: {
            type: Object
        }
    }
}
</script>
