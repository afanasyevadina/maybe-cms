export default {
    methods: {
        getJson: function (url, callback) {
            fetch(url, {
                headers: {
                    'Authorization': `Bearer ${this.$store.getters.apiToken}`
                }
            })
                .then(response => {
                    if (response.status === 401 || response.status === 403) {
                        this.$store.commit('unsetUser')
                        this.$router.push({ name: 'Login' })
                    } else if (response.status === 404) {
                        this.$router.push({ name: 'NotFound' })
                    } else if (Math.floor(response.status / 100) === 5) {
                        this.$store.commit('setFlashError', 'Что-то пошло не так!')
                    } else {
                        return response.text()
                    }
                })
                .then(json => callback(json ? JSON.parse(json) : {}))
        },
        postJson: function (url, body, callback) {
            fetch(url, {
                method: 'POST',
                body: JSON.stringify(body),
                headers: {
                    'Content-Type': 'application/json',
                    'Authorization': `Bearer ${this.$store.getters.apiToken}`
                }
            })
                .then(response => {
                    if (response.status === 401 || response.status === 403) {
                        this.$store.commit('unsetUser')
                        this.$router.push({ name: 'Login' })
                    } else if (response.status === 404) {
                        this.$router.push({ name: 'NotFound' })
                    } else if (Math.floor(response.status / 100) === 5) {
                        this.$store.commit('setFlashError', 'Что-то пошло не так!')
                    } else {
                        this.$store.commit('setFlashSuccess', 'Надежно сохранено!')
                        return response.text()
                    }
                })
                .then(json => callback(json ? JSON.parse(json) : {}))
        },
        deleteRequest: function (url, callback) {
            fetch(url, {
                method: 'DELETE',
                headers: {
                    'Authorization': `Bearer ${this.$store.getters.apiToken}`
                }
            })
                .then(response => {
                    if (response.status === 401 || response.status === 403) {
                        this.$store.commit('unsetUser')
                        this.$router.push({ name: 'Login' })
                    } else if (response.status === 404) {
                        this.$router.push({ name: 'NotFound' })
                    } else if (Math.floor(response.status / 100) === 5) {
                        this.$store.commit('setFlashError', 'Что-то пошло не так!')
                    } else {
                        this.$store.commit('setFlashSuccess', 'Удалили ненужное!')
                        return callback()
                    }
                })
        },
    }
}
