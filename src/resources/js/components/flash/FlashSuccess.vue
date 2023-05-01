<template>
    <div class="position-fixed col-sm-8 col-lg-6 alert alert-success" v-if="flashSuccess" @click="setFlashSuccess(null)">{{ flashSuccess }}</div>
</template>

<script>
import {mapState} from 'vuex'
import {mapMutations} from 'vuex'
export default {
    name: "FlashSuccess",
    computed: {
        ...mapState([
            'flashSuccess',
        ])
    },
    methods: {
        ...mapMutations([
            'setFlashSuccess',
        ]),
    }
}
</script>
