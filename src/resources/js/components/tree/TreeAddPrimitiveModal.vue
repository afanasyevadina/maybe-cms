<template>
    <div class="modal fade" tabindex="-1" :id="modalKey">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Выбрать примитив</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-6 col-md-4 mb-3" v-for="(primitive, primitiveKey) in allowedPrimitives" :key="primitiveKey">
                            <a href="#" class="btn btn-outline-dark w-100 h-100" data-bs-dismiss="modal"
                               @click.prevent="$emit('addBlock', primitiveKey)">
                                <span class="h1">
                                    <i :class="primitive.class || 'far fa-square'"></i>
                                </span>
                                <br>
                                {{ primitive.title }}
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    name: "TreeAddPrimitiveModal",
    props: {
        modalKey: {
            type: String
        },
        allowedPrimitives: {
            type: Object
        }
    }
}
</script>
