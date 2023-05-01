<template>
    <div class="position-fixed col-sm-8 col-lg-6 alert alert-danger" v-if="flashError" @click="setFlashError(null)">{{ flashError }}</div>
</template>

<script>
import {mapState} from 'vuex'
import {mapMutations} from 'vuex'
export default {
    name: "FlashError",
    computed: {
        ...mapState([
            'flashError',
        ])
    },
    methods: {
        ...mapMutations([
            'setFlashError',
        ]),
    }
}
</script>
