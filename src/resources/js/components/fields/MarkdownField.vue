<template>
    <quill-editor theme="snow" ref="quillEditor" @ready="ready" @textChange="textChange"></quill-editor>
</template>

<script>
import { QuillEditor } from '@vueup/vue-quill'
import '@vueup/vue-quill/dist/vue-quill.snow.css';
export default {
    name: "MarkdownField",
    components: {
        QuillEditor
    },
    props: {
        field: {
            type: Object
        }
    },
    data() {
        return {
            text: '',
        }
    },
    methods: {
        ready: function () {
            this.$refs.quillEditor.setHTML(this.field.value || '')
        },
        textChange: function () {
            this.field.value = this.$refs.quillEditor.getHTML()
        }
    }
}
</script>
