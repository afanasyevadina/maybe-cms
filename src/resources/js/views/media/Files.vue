<template>
    <div class="p-4">
        <div>
            <div class="row">
                <div class="col mb-4">
                    <ul class="nav nav-tabs">
                        <li class="nav-item">
                            <router-link :to="{name: 'Images'}" class="nav-link">Изображения</router-link>
                        </li>
                        <li class="nav-item">
                            <router-link :to="{name: 'Video'}" class="nav-link">Видео</router-link>
                        </li>
                        <li class="nav-item">
                            <router-link :to="{name: 'Files'}" class="nav-link active">Файлы</router-link>
                        </li>
                    </ul>
                </div>
                <div class="col-auto mb-4" v-if="files.data.length">
                    <a href="#" data-bs-toggle="modal" data-bs-target="#upload-file" class="btn btn-success">Загрузить файл</a>
                </div>
            </div>
            <div class="text-center" v-if="loading">
                <div class="spinner-border my-5 text-secondary" role="status">
                    <span class="sr-only">Загружаем...</span>
                </div>
            </div>
            <template v-else>
                <table class="table table-striped mb-4">
                    <tbody v-if="!files.data.length">
                    <tr>
                        <td colspan="5" class="text-center py-3">
                            Пока нет файлов
                            <br>
                            <br>
                            <a href="#" data-bs-toggle="modal" data-bs-target="#upload-file" class="btn btn-outline-dark">Загрузить первый файл</a>
                        </td>
                    </tr>
                    </tbody>
                    <template v-else>
                        <thead>
                        <tr>
                            <th>#</th>
                            <th>Имя файла</th>
                            <th>Тип</th>
                            <th>Размер</th>
                            <th>Автор</th>
                            <th>Последнее обновление</th>
                            <th></th>
                        </tr>
                        </thead>
                        <tbody>
                        <template v-for="file in files.data" :key="file.id">
                            <tr>
                                <td>{{ file.id }}</td>
                                <td>{{ file.original_name }}</td>
                                <td>{{ file.mime }}</td>
                                <td>{{ formatSize(file.size) }}</td>
                                <td>{{ file.user.name }}</td>
                                <td>{{ formatDate(file.updated_at) }}</td>
                                <td class="text-nowrap text-end">
                                    <a :href="file.path" class="btn btn-light me-2" target="_blank">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <DeleteFile :id="file.id"></DeleteFile>
                                </td>
                            </tr>
                        </template>
                        </tbody>
                    </template>
                </table>
                <Pagination :pagination="files.meta" @paginate="loadFiles"></Pagination>
            </template>
        </div>
        <UploadFile :modal-key="'upload-file'" @upload="loadFiles"></UploadFile>
    </div>
</template>

<script>
import DeleteFile from "../../components/media/DeleteFile.vue";
import UploadFile from "../../components/media/UploadFile.vue";
import Pagination from "../../components/Pagination.vue";

export default {
    name: 'Files',
    components: {
        DeleteFile,
        UploadFile,
        Pagination
    },
    data() {
        return {
            files: {
                data: [],
                meta: {}
            },
            loading: true
        }
    },
    methods: {
        loadFiles: function(page = 1) {
            this.loading = true
            this.getJson(`/api/files?type=file&page=${page}`,json => {
                this.files = json
                this.loading = false
            })
        }
    },
    mounted() {
        this.loadFiles()
    }
}
</script>
