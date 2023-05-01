import { createStore } from 'vuex'

// Create a new store instance.
const store = createStore({
    state () {
        return {
            user: null,
            activeElement: null,
            postTypes: [],
            primitives: [],
            fieldTypes: [],
            relationTypes: [],
            presets: [],
            components: [],
            flashError: null,
            flashSuccess: null,
            collapsedNodes: []
        }
    },
    getters: {
        apiToken (state) {
            return state.user?.token
        }
    },
    mutations: {
        setUser (state, user) {
            state.user = user
        },
        unsetUser (state) {
            state.user = null
            localStorage.removeItem('_cms_user')
        },
        setActiveElement (state, element) {
            state.activeElement = element
        },
        setPostTypes (state, postTypes) {
            state.postTypes = postTypes
        },
        setPrimitives (state, primitives) {
            state.primitives = primitives
        },
        setFieldTypes (state, fieldTypes) {
            state.fieldTypes = fieldTypes
        },
        setRelationTypes (state, relationTypes) {
            state.relationTypes = relationTypes
        },
        setPresets (state, presets) {
            state.presets = presets
        },
        setComponents (state, components) {
            state.components = components
        },
        setFlashSuccess(state, text) {
            state.flashSuccess = text
            setTimeout(() => state.flashSuccess = null, 3000)
        },
        setFlashError(state, text) {
            state.flashError = text
            setTimeout(() => state.flashError = null, 3000)
        },
        setCollapsedNodes(state, collapsedNodes) {
            state.collapsedNodes = collapsedNodes
        }
    }
})

export default store
