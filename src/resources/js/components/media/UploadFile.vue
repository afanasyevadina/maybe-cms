<template>
    <div class="modal fade" :id="modalKey" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <form action="#" method="POST" class="modal-content" @submit.prevent="upload">
                <div class="modal-header">
                    <h5 class="modal-title">Загрузить файл</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <template v-if="filePreview">
                        <div class="btn-group w-100 border">
                            <div class="w-100 d-flex align-items-center px-3">{{ filePreview.name }}</div>
                            <button type="button" class="btn btn-light" @click.prevent="filePreview = null">
                                <i class="fas fa-trash"></i>
                            </button>
                        </div>
                    </template>
                    <input type="file" class="form-control" @change="preview" v-else>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cancel</button>
                    <button class="btn btn-success">Upload</button>
                </div>
            </form>
        </div>
    </div>
</template>

<script>
export default {
    name: 'UploadFile',
    props: ['modalKey'],
    data() {
        return {
            uploadState: {
                loading: false,
                progress: 0
            },
            filePreview: null,
        }
    },
    methods: {
        startProgress: function() {
            this.uploadState = {
                loading: true,
                progress: 0
            }
        },
        resetProgress: function() {
            this.uploadState = {
                loading: false,
                progress: 0
            }
            this.filePreview = null
        },
        preview: function (event) {
            this.filePreview = null
            if (event.target.files && event.target.files[0]) {
                this.filePreview = event.target.files[0]
            }
        },
        upload: function () {
            if (this.filePreview) {
                this.startProgress()
                let request = new XMLHttpRequest()
                let formData = new FormData()
                formData.append('file', this.filePreview)
                request.open('POST', `/api/files`)
                formData.append('type', 'file')
                request.setRequestHeader('Authorization', `Bearer ${this.$store.getters.apiToken}`)
                request.responseType = 'json'
                request.send(formData)
                request.onload = () => {
                    this.hideModal()
                    this.$emit('upload')
                    this.resetProgress()
                }
            }
        }
    }
}
</script>
